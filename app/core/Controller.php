<?php
/**
 * Controller (基礎類別)
 * 所有的 Controller 都應該繼承這個類別
 * 提供共用的 view 渲染與 model 載入方法
 */
abstract class Controller
{
    /**
     * 渲染指定的 view 檔案
     * @param string $view  view 路徑, 例如 'post/index' 對應 app/views/post/index.php
     * @param array  $data  要傳遞給 view 的資料, 會自動展開成變數
     */
    protected function view(string $view, array $data = []): void
    {
        // 將陣列的 key 轉成變數名稱, 讓 view 裡可以直接用 $title, $posts 等變數
        extract($data);

        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("View 不存在: {$view}");
        }

        require $viewPath;
    }

    /**
     * 載入並建立指定的 model 實例
     * @param string $modelName 例如 'Post'
     */
    protected function model(string $modelName)
    {
        require_once __DIR__ . '/../models/' . $modelName . '.php';
        return new $modelName();
    }
}
