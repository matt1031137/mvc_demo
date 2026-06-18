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

        // 1. 定義動態的子頁面路徑
        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        //使用框架的場合--要怎麼改？
        //  ob_start();
        // require __DIR__ . '/post/index.php';
        // $content = ob_get_clean();
        // require __DIR__ . '/layout.php';


        if (!file_exists($viewPath)) {
            die("View 不存在: {$view}");
        }


        //單一輸出頁面，無統一框架
        //require $viewPath;

        // 2. 開啟輸出緩衝，開始攔截子頁面的 HTML
        ob_start();
        // 3. 動態引入子頁面
        require $viewPath;
        // 4. 把子頁面的內容存進 $content，並清空/關閉緩衝區
        $content = ob_get_clean();
        // 5. 引入統一的框架檔（在 layout.php 裡面只要 echo $content; 就能渲染子頁面）
        require __DIR__ . '/../views/layout.php'; // 請依據你實際的 layout 位置調整路徑
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
