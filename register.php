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

$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$password = (string)($_POST['password'] ?? '');
$confirmPassword = (string)($_POST['confirmPassword'] ?? '');

if ($name === '' || $email === '' || $password === '' || $confirmPassword === '') {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => '모든 항목을 입력해 주세요.',
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

if (strlen($password) < 8) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => '비밀번호는 8자 이상이어야 합니다.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($password !== $confirmPassword) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => '비밀번호가 일치하지 않습니다.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $pdo = getDbConnection();

    $existsStmt = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
    $existsStmt->execute(['email' => $email]);
    if ($existsStmt->fetch()) {
        http_response_code(409);
        echo json_encode([
            'success' => false,
            'message' => '이미 가입된 이메일입니다.',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $insertStmt = $pdo->prepare(
        'INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :password_hash)'
    );
    $insertStmt->execute([
        'name' => $name,
        'email' => $email,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
    ]);

    echo json_encode([
        'success' => true,
        'message' => '회원가입이 완료되었습니다.',
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => '서버 오류가 발생했습니다: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
