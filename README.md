# OpenSpecTest

[OpenSpec](https://github.com/Fission-AI/OpenSpec) の動作確認用のメモ帳アプリ。
メモの CRUD・ログイン・ユーザーごとの権限を、仕様駆動（OpenSpec）と TDD で作る。

| 役割 | 技術 |
|---|---|
| API（`backend/`） | Laravel 13 / PHP 8.4 |
| 画面（`frontend/`） | Next.js（App Router）/ TypeScript |
| DB | MySQL 8.4（phpMyAdmin 付き） |

開発環境は Docker だけで動きます（Windows / macOS 共通）。

## 必要なもの

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
  - Windows は WSL2 バックエンドを使う
  - PHP・Composer・Node は入れない（コンテナの中で動かす）
- Git
- OpenSpec CLI（仕様の管理に使う場合のみ）: `npm install -g @fission-ai/openspec@latest`（Node 20.19 以上が必要）

## 使い方

> 環境の構築（`compose.yaml` など）は OpenSpec の変更 `setup-environment` で作る。
> 完成するまでは、下のコマンドは動かない。

```bash
cp .env.example .env
docker compose up -d
```

| URL | 内容 |
|---|---|
| http://localhost:3000 | 画面 |
| http://localhost:8000/api/health | API のヘルスチェック |
| http://localhost:8080 | phpMyAdmin |

テスト:

```bash
docker compose exec backend php artisan test
docker compose exec frontend npm test
```

停止は `docker compose down`（DB も消す場合は `-v` を付ける）。

## 開発の進め方（OpenSpec）

提案 → 実装 → アーカイブの流れで進める。1機能ごとの手順、指示の出し方、変更の順番は
[docs/development-flow.md](docs/development-flow.md)（人間向け）を参照。

## フォルダ

```
openspec/
  config.yaml   プロジェクトの前提
  specs/        確定した仕様
  changes/      進行中の変更（提案）
docs/           人間向けのメモ（Claude は作業の判断に使わない）
backend/        API（setup-environment で作る）
frontend/       画面（setup-environment で作る）
```
