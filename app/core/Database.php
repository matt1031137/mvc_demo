<?php
/**
 * Database
 * 負責建立並提供 PDO 連線實例
 * 使用單例模式 (Singleton) 確保整個請求生命週期只建立一次連線
 */
class Database
{
    private static ?PDO $instance = null;

    // 禁止外部直接 new Database()
    private function __construct() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                // 實務上應該記錄到 log, 而不是直接輸出錯誤訊息給使用者
                die('資料庫連線失敗: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
