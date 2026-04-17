<?php
$siteTitle = '간단한 PHP 웹사이트';
$now = new DateTime('now', new DateTimeZone('Asia/Seoul'));

$features = [
    'PHP로 렌더링되는 동적 페이지',
    '반응형 레이아웃',
    '가벼운 단일 파일 구조',
];
?>
<!doctype html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($siteTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <style>
    :root {
      --bg: #f4f7fb;
      --card: #ffffff;
      --text: #1f2937;
      --accent: #0f766e;
      --muted: #6b7280;
    }

    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: "Noto Sans KR", "Apple SD Gothic Neo", sans-serif;
      background: linear-gradient(135deg, #e6fffa, #eff6ff 45%, #f8fafc);
      color: var(--text);
      min-height: 100vh;
      display: grid;
      place-items: center;
      padding: 24px;
    }

    .container {
      width: min(720px, 100%);
      background: var(--card);
      border-radius: 16px;
      padding: 28px;
      box-shadow: 0 10px 30px rgba(15, 118, 110, 0.15);
    }

    h1 {
      margin-top: 0;
      margin-bottom: 8px;
      font-size: clamp(1.5rem, 3vw, 2rem);
    }

    .subtitle {
      margin-top: 0;
      color: var(--muted);
    }

    .meta {
      margin: 20px 0;
      padding: 12px 14px;
      border-left: 4px solid var(--accent);
      background: #f0fdfa;
      border-radius: 8px;
      font-size: 0.95rem;
    }

    ul {
      margin: 12px 0 0;
      padding-left: 20px;
    }

    li { margin: 8px 0; }

    .footer {
      margin-top: 24px;
      font-size: 0.9rem;
      color: var(--muted);
    }

    code {
      background: #f3f4f6;
      padding: 2px 6px;
      border-radius: 6px;
    }
  </style>
</head>
<body>
  <main class="container">
    <h1><?= htmlspecialchars($siteTitle, ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="subtitle">요청하신 PHP 기반의 간단한 웹사이트 예시입니다.</p>

    <section class="meta">
      <div><strong>현재 시간:</strong> <?= $now->format('Y-m-d H:i:s') ?> (KST)</div>
      <div><strong>PHP 버전:</strong> <?= PHP_VERSION ?></div>
      <div><strong>서버 소프트웨어:</strong> <?= htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'PHP Built-in Server', ENT_QUOTES, 'UTF-8') ?></div>
    </section>

    <section>
      <h2>포함 기능</h2>
      <ul>
        <?php foreach ($features as $feature): ?>
          <li><?= htmlspecialchars($feature, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
      </ul>
    </section>

    <p class="footer">
      실행 방법: <code>php -S localhost:8000</code> 후 <code>http://localhost:8000/index.php</code> 접속
    </p>
  </main>
</body>
</html>
