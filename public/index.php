<?php
/**
 * 應用程式入口點 (Front Controller)
 * 所有請求都會經由 .htaccess 導向這個檔案
 */

// 開發階段先打開錯誤顯示, 上線後應該關閉並改為寫入 log
error_reporting(E_ALL);
ini_set('display_errors', '1');

// 載入設定檔
require_once __DIR__ . '/../app/config/config.php';

// 載入核心類別
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Router.php';

// 啟動路由, 解析網址並執行對應的 Controller / Action
$router = new Router();
$router->dispatch();
