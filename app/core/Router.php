<?php
/**
 * Router
 * 負責解析網址, 找到對應的 Controller / Action / 參數, 並執行它
 *
 * 網址格式: /controller/action/param1/param2
 * 範例:    /post/show/1   => PostController->show(1)
 *          /              => 使用 config.php 裡的 DEFAULT_CONTROLLER / DEFAULT_ACTION
 */
class Router
{
    //class最終的dispatch()，但變數跟解析路由字串的動作都是protected，代表每個頁面都能建立實例處理解析，解析行為只會發生在自己的實例內部，每個人都不同也無法從外部取用。最終用public的dispatch()設定控制的方法與動作
    protected string $controllerName = DEFAULT_CONTROLLER;
    protected string $action = DEFAULT_ACTION;
    protected array $params = [];

    //把執行parseUrl()放到建構子，是設計成建立實例後，新的實例->dispatch() 就能直接處理好路由，將controllName跟action跟參數的param都做好備用的關係？
    public function __construct()
    {
        $this->parseUrl();
    }

    /**
     * 從 $_GET['url'] (由 .htaccess 帶入) 解析出 controller / action / params
     */
    protected function parseUrl(): void
    {
        if (empty($_GET['url'])) {
            return; // 沒有路徑時直接使用預設值
        }

        // 去除頭尾斜線後依 / 切割, 例如 "post/show/1" => ['post', 'show', '1']
        // 移除首尾的斜線跟空白
        $url = trim($_GET['url'], '/');
        //用斜線拆分成陣列(跟js的split相同)
        $segments = explode('/', $url);

        // ucfirst()將字串的第一個字符轉換為大寫
        // strtolower()將整個字串轉換為小寫
        // 看起來是將第一個轉換字首大寫其餘小寫，再設成controllerName的值
        if (!empty($segments[0])) {
            $this->controllerName = ucfirst(strtolower($segments[0]));
        }

        //如果有第二個，全部轉小寫並放到action的變數內
        if (!empty($segments[1])) {
            $this->action = strtolower($segments[1]);
        }

        // 從第二個值開始，剩下的部分都當作參數傳給 action(新的陣列，不影響原本的資料)
        $this->params = array_slice($segments, 2);
    }

    /**
     * 執行對應的 Controller / Action
     */
    public function dispatch(): void
    {
        $controllerClass = $this->controllerName . 'Controller';
        $controllerFile  = __DIR__ . '/../controllers/' . $controllerClass . '.php';

        // 先確認有無檔案
        if (!file_exists($controllerFile)) {
            $this->notFound("找不到 Controller: {$controllerClass}");
            return;
        }

        require_once $controllerFile;

        // 拉了檔案後在確認是否存在class
        if (!class_exists($controllerClass)) {
            $this->notFound("Controller 類別不存在: {$controllerClass}");
            return;
        }

        //確定找得到對應的class，則建立新的控制方法的實例
        $controller = new $controllerClass();


        // 檢查方法內是否存在某些屬性，類似js的Object.hasOwn(obj, 'name')
        // 此範例目前只有PostController.php，查看PostController.php有idnex方法跟show方法，對應$segments[1]賦予action的值決定
        if (!method_exists($controller, $this->action)) {
            $this->notFound("找不到 Action: {$this->action}");
            return;
        }

        // 用 params 陣列展開呼叫對應方法, 例如 show(1)
        // 將params陣列內的值，作為函式的參數放到$controller實例內的action名稱的函式
        // 注意如果第一個參數不是動態抓，而是直接放函式的場合，要寫字串(跟js不同)，而且函式用字串是預設的行為。
        call_user_func_array([$controller, $this->action], $this->params);
    }

    //內部使用的報錯+http錯誤代碼，並印出的函式
    protected function notFound(string $message): void
    {
        http_response_code(404);
        echo "404 - {$message}";
    }
}
