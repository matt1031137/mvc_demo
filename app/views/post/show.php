<?php
/**
 * @var string $title
 * @var array{title:string, created_at:string, content:string} $post
 */
?>

<p><a href="<?= BASE_URL ?>/post">&larr; 回文章列表</a></p>

<h2><?= htmlspecialchars($post['title']) ?></h2>
<small><?= htmlspecialchars($post['created_at']) ?></small>

<div style="margin-top: 16px;">
    <?= nl2br(htmlspecialchars($post['content'])) ?>
</div>
