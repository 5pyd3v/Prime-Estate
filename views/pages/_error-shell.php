<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?></title>
<style>
    :root { color-scheme: light; }
    * { box-sizing: border-box; }
    body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Inter, Roboto, sans-serif;
        background: #FAF9F6;
        color: #1A1A1A;
        padding: 24px;
    }
    .wrap { text-align: center; max-width: 480px; }
    .code {
        font-size: clamp(72px, 15vw, 128px);
        font-weight: 700;
        line-height: 1;
        color: #16302B;
        letter-spacing: -0.03em;
        margin: 0 0 8px;
    }
    h1 { font-size: 22px; margin: 0 0 8px; font-weight: 600; }
    p { color: #6b6b63; line-height: 1.6; margin: 0 0 28px; }
    a.btn {
        display: inline-block;
        padding: 13px 28px;
        border-radius: 999px;
        background: #16302B;
        color: #fff;
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
        transition: transform .15s ease, background .15s ease;
    }
    a.btn:hover { background: #1f4238; transform: translateY(-1px); }
</style>
</head>
<body>
    <div class="wrap">
        <p class="code"><?= e($heading) ?></p>
        <h1><?= e($message) ?></h1>
        <p><?= e($hint) ?></p>
        <a class="btn" href="/">Back to Homepage</a>
    </div>
</body>
</html>
