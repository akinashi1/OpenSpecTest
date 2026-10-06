# Spec Delta

## Purpose

メモ帳アプリの開発に使う、Windows / macOS 共通の開発環境を定義する。
API・画面・DB・DB 管理ツールがまとめて起動し、疎通とテスト実行ができる状態を保証する。

## ADDED Requirements

### Requirement: 開発環境を1つのコマンドで起動できる
The system SHALL start the database, the database admin tool, the API, and the web frontend with a single `docker compose up -d` command, using only Docker as a prerequisite on the host.

#### Scenario: 4つのサービスが起動する
- **WHEN** 開発者が `docker compose up -d` を実行する
- **THEN** mysql・phpmyadmin・backend・frontend の4コンテナがすべて実行中になる

#### Scenario: 環境変数ファイルが無い
- **WHEN** `.env` が存在しない状態で `docker compose up -d` を実行する
- **THEN** 起動は失敗し、`.env.example` をコピーして `.env` を作る必要があることがエラーから分かる

### Requirement: API のヘルスチェックに応答する
The system SHALL expose `GET /api/health` that returns HTTP 200 and a JSON body `{"status":"ok"}` when the API and the database are reachable.

#### Scenario: 正常に応答する
- **WHEN** クライアントが `GET /api/health` を送る
- **THEN** ステータス 200 と `{"status":"ok"}` が返る

#### Scenario: 存在しないパスは 404 を返す
- **WHEN** クライアントが `GET /api/not-found` を送る
- **THEN** ステータス 404 と JSON のエラーボディが返る

### Requirement: 画面と DB 管理ツールにブラウザからアクセスできる
The system SHALL serve the web frontend at `http://localhost:3000` and the database admin tool at `http://localhost:8080`, and the frontend SHALL be able to reach the API.

#### Scenario: 画面の初期ページが表示される
- **WHEN** ブラウザで `http://localhost:3000` を開く
- **THEN** ステータス 200 でフレームワークの初期ページが表示される

#### Scenario: DB 管理ツールで2つのデータベースが見える
- **WHEN** ブラウザで `http://localhost:8080` を開いてログインする
- **THEN** 開発用 `memo` とテスト用 `memo_test` の2つのデータベースが一覧に表示される

### Requirement: API と画面のテストを実行できる
The system SHALL run the API tests against the test database and the frontend tests with one command each inside the containers, and the tests SHALL NOT modify the development database.

#### Scenario: API のテストが通る
- **WHEN** `docker compose exec backend php artisan test` を実行する
- **THEN** テストがすべて成功し、開発用 `memo` のデータは変化しない

#### Scenario: 画面のテストが通る
- **WHEN** `docker compose exec frontend npm test` を実行する
- **THEN** テストがすべて成功する

#### Scenario: 失敗するテストは検出される
- **WHEN** 期待値を間違えたテストを追加して実行する
- **THEN** コマンドは 0 以外の終了コードで終わり、失敗したテストが表示される
