<?php
/**
 * Post Model
 * 負責跟 posts 資料表互動, Controller 不應該直接寫 SQL
 */
class Post
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * 取得所有文章, 依建立時間新到舊排序
     */
    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM posts ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    /**
     * 依 id 取得單篇文章
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM posts WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $post = $stmt->fetch();

        return $post ?: null;
    }

    /**
     * 新增文章
     */
    public function create(string $title, string $content): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO posts (title, content, created_at) VALUES (:title, :content, NOW())'
        );

        return $stmt->execute([
            'title'   => $title,
            'content' => $content,
        ]);
    }
}
