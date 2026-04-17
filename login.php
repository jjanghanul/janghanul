<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/db.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'POST 요청만 허용됩니다.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$email = trim((string)($_POST['email'] ?? ''));
$password = (string)($_POST['password'] ?? '');

if ($email === '' || $password === '') {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => '이메일과 비밀번호를 입력해 주세요.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => '이메일 형식이 올바르지 않습니다.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $pdo = getDbConnection();

    $stmt = $pdo->prepare('SELECT id, name, email, password_hash FROM users WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, (string)$user['password_hash'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => '이메일 또는 비밀번호가 올바르지 않습니다.',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    session_start();
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => (int)$user['id'],
        'name' => (string)$user['name'],
        'email' => (string)$user['email'],
    ];

    echo json_encode([
        'success' => true,
        'message' => '로그인되었습니다.',
        'user' => [
            'name' => (string)$user['name'],
            'email' => (string)$user['email'],
        ],
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => '서버 오류가 발생했습니다: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
