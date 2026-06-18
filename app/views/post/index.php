<?php
/**
 * @var string $title
 * @var array<int, array{id:int, title:string, created_at:string}> $posts
 */
?>


<h2><?= htmlspecialchars($title) ?></h2>

<?php if (empty($posts)): ?>
    <p>目前還沒有文章。</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <article>
            <h3>
                <a href="<?= BASE_URL ?>/post/show/<?= $post['id'] ?>">
                    <?= htmlspecialchars($post['title']) ?>
                </a>
            </h3>
            <small><?= htmlspecialchars($post['created_at']) ?></small>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
