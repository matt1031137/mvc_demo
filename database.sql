CREATE DATABASE IF NOT EXISTS mvc_demo DEFAULT CHARACTER SET utf8mb4;
USE mvc_demo;

CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME NOT NULL
);

INSERT INTO posts (title, content, created_at) VALUES
('第一篇文章', '這是我用手刻 MVC 寫的第一篇文章內容。', NOW()),
('關於 MVC 架構', 'MVC 把程式拆成 Model、View、Controller 三層,讓職責更清楚。', NOW());
