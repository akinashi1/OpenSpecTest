# Design

## Context

リポジトリは空（README のみ）。動機は proposal.md の Why を参照。
開発者の手元には Docker Desktop（Windows は WSL2 バックエンド、macOS は Apple Silicon / Intel）しかなく、
PHP・Composer・Node は入っていない前提。方針の詳細は `openspec/config.yaml` に従う。

## Goals / Non-Goals

**Goals:**
- `docker compose up -d` だけで4コンテナが起動し、API・画面・DB 管理ツールに疎通できる
- API と画面のテストが、それぞれ1コマンドで動く

**Non-Goals:**
- 本番用のイメージ・CI・HTTPS
- メモ・認証・権限などのアプリの機能

## Decisions

- **フォルダ構成**: ルート直下に `backend/`・`frontend/`・`compose.yaml`。
  Laravel と Next.js はそれぞれ独立したプロジェクトとして置く（モノレポのツールは使わない）。
- **雛形の作り方**: ホストに PHP / Node が無いので、使い捨てコンテナで生成する
  （`docker run --rm -v ... composer create-project laravel/laravel` と `npx create-next-app`）。
  *代替案*: ホストに入れて生成 → 前提が増えるので不採用。
- **コンテナ**:
  - mysql: 公式 `mysql:8.4`（arm64 対応）。ホストにはポートを公開しない（phpMyAdmin とは内部ネットワークで接続）
  - phpmyadmin: 公式 `phpmyadmin`、ホスト 8080
  - backend: `php:8.3-cli` ベースに必要な拡張（pdo_mysql）と Composer を入れた小さな Dockerfile。
    `php artisan serve --host=0.0.0.0 --port=8000`、ホスト 8000
  - frontend: `node:22-alpine`、`npm run dev`、ホスト 3000
- **ボリューム**: `backend/vendor` と `frontend/node_modules`（と `.next`）は名前付きボリューム。
  ソースはバインドマウント。Next.js は `WATCHPACK_POLLING=true`。
- **DB の初期化**: mysql の `docker-entrypoint-initdb.d` に SQL を置き、`memo_test` の作成と権限付与を行う
  （`memo` は環境変数 `MYSQL_DATABASE` で作る）。初回のボリューム作成時にだけ実行される。
- **テスト用 DB の切り替え**: `backend/phpunit.xml` で `DB_DATABASE=memo_test` を指定する。
  開発用 DB はテストから触れない。
- **テストツール**: API は Pest（Laravel プラグイン）、画面は Vitest + React Testing Library（jsdom）。
- **ヘルスチェック**: `GET /api/health` で DB に `SELECT 1` を実行し、成功時に `{"status":"ok"}` を返す。
  `routes/api.php` は Laravel 12 では標準で無いので、`install:api` で有効にする。
- **画面と API のつなぎ**: 今回は疎通できる状態（API の URL を環境変数で持つ）までで、画面から API を呼ぶ処理は作らない。

## Risks / Trade-offs

- [Windows のバインドマウントでファイル変更の検知が遅い] → Next.js はポーリングで動かす
- [Windows で CRLF になり、コンテナ内のスクリプトが動かない] → `.gitattributes` で LF に固定する
- [`mysql` の初回起動前にバックエンドが DB に繋ごうとして失敗する] → mysql に healthcheck を付け、
  backend は `depends_on: condition: service_healthy` で待つ
- [ポート 3000 / 8000 / 8080 が他のアプリと衝突する] → ホスト側のポートは `.env` で変更できるようにする
