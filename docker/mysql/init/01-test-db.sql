-- テスト用 DB（開発用 memo は MYSQL_DATABASE で作られる）。初回のボリューム作成時にだけ実行される
CREATE DATABASE IF NOT EXISTS memo_test;
GRANT ALL PRIVILEGES ON memo_test.* TO 'memo'@'%';
