<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'MVC Demo') ?></title>
    <style>
        body { font-family: sans-serif; max-width: 700px; margin: 40px auto; padding: 0 20px; }
        a { color: #2563eb; text-decoration: none; }
        article { border-bottom: 1px solid #e5e7eb; padding: 16px 0; }
    </style>
</head>
<body>
    <h1><a href="<?= BASE_URL ?>/post">我的部落格</a></h1>
    <hr>

    <?php
    // 進階用法(選用): 若想統一外框, 可以讓 Controller 改用以下方式渲染:
    //   ob_start();
    //   require __DIR__ . '/post/index.php';
    //   $content = ob_get_clean();
    //   require __DIR__ . '/layout.php';
    // 本範例為求簡單, 直接在 Controller 用 $this->view() 渲染各自的 view, 不套用 layout
    ?>

</body>
</html>
