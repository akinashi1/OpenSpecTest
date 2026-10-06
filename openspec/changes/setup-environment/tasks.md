# Tasks

## 1. リポジトリの土台

- [x] 1.1 `.gitignore`（`.env`・`vendor`・`node_modules`・`.next`）と `.gitattributes`（`* text=auto eol=lf`）を作り、`git status` に `.env` や依存フォルダが出ないことを確認する
- [x] 1.2 `.env.example` を作り（DB 接続情報・各ポート）、`cp .env.example .env` 相当で `.env` ができることを確認する

## 2. MySQL と phpMyAdmin

- [x] 2.1 `compose.yaml` に mysql（healthcheck 付き）と phpmyadmin を定義し、`docker compose up -d` で2つが起動することを確認する
- [x] 2.2 初期化 SQL（`memo_test` の作成と権限付与）を `docker-entrypoint-initdb.d` に置き、`http://localhost:8080` で `memo` と `memo_test` が見えることを確認する

## 3. API（Laravel）

- [x] 3.1 使い捨てコンテナで `backend/` に Laravel（最新の安定版。13）を生成し、`composer.json` と `artisan` が揃っていることを確認する（`routes/api.php` の登録は 3.5 で行う）
- [x] 3.2 backend の Dockerfile と compose の backend サービスを作り、`http://localhost:8000` が応答することを確認する
- [x] 3.3 Pest を導入し、`phpunit.xml` でテスト用 DB を `memo_test` に切り替え、サンプルテストが通ることを確認する
- [x] 3.4 【Red】`GET /api/health` が 200 と `{"status":"ok"}`、`GET /api/not-found` が 404（JSON）を返すテストを書き、`docker compose exec backend php artisan test` が失敗することを確認する
- [x] 3.5 【Green】ヘルスチェック（`SELECT 1` を含む）を実装し、3.4 のテストが通ることを確認する

## 4. 画面（Next.js）

- [x] 4.1 使い捨てコンテナで `frontend/` に Next.js（App Router + TypeScript）を生成し、`.env` の API の URL を設定できることを確認する
- [x] 4.2 frontend の Dockerfile と compose の frontend サービス（ポーリング設定込み）を作り、`http://localhost:3000` に初期ページが表示されることを確認する
- [x] 4.3 Vitest + React Testing Library を導入し、【Red】初期ページの表示を確かめるテストを書いて失敗を確認する
- [x] 4.4 【Green】テストが通るようにし、`docker compose exec frontend npm test` が成功することを確認する

## 5. 全体の確認

- [x] 5.1 `docker compose down -v` のあと `docker compose up -d` で、初期化から4コンテナの起動までがやり直せることを確認する
- [x] 5.2 spec の全 Scenario を確認し、API のテストと画面のテストの両方が通ることを確認する（失敗するテストが検出される Scenario も確認する）

## Workflow follow-up

- 実装をコミットしたあと、`/opsx:archive` で `dev-environment` を `openspec/specs/` に統合する
