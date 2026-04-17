# MySQL + PHP 연동 실행 방법

아래 명령은 Ubuntu/WSL 기준입니다.

## 1) 패키지 설치

```bash
sudo apt-get update
sudo apt-get install -y default-mysql-server default-mysql-client php-mysql
```

## 2) MySQL 시작 및 스키마 적용

```bash
sudo service mysql start
sudo mysql < mysql_schema.sql
```

## 3) 웹 서버 실행

```bash
php -S localhost:8000
```

브라우저에서 `http://localhost:8000/signup.html` 접속 후 회원가입하면 `users` 테이블에 저장됩니다.

## 4) 저장 데이터 확인

```bash
mysql -u janghanul_user -p -D janghanul -e "SELECT id,name,email,created_at FROM users ORDER BY id DESC;"
```
