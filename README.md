# OpenSpecTest

[OpenSpec](https://github.com/Fission-AI/OpenSpec) の動作確認用のメモ帳アプリ。
メモの CRUD・ログイン・ユーザーごとの権限を、仕様駆動（OpenSpec）と TDD で作る。

| 役割 | 技術 |
|---|---|
| API（`backend/`） | Laravel 12 / PHP 8.3 |
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

このリポジトリは Claude Code で開き、次の順に進める。

1. `/opsx:propose <変更名>`: 提案（proposal・spec・design・tasks）を作る
2. 内容を確認する
3. `/opsx:apply`: テストを先に書いて実装する
4. `/opsx:archive`: 変更を `openspec/specs/` の確定した仕様に統合する

変更の順番:

1. `setup-environment`: Docker 環境と雛形
2. `add-memo-crud`: メモの作成・一覧・取得・更新・削除
3. `add-auth`: 登録・ログイン・ログアウト
4. `add-permissions`: ロール（user / admin）と所有者チェック

構成・方針の詳細は [`openspec/config.yaml`](openspec/config.yaml) にある。

## フォルダ

```
openspec/
  config.yaml   プロジェクトの前提
  specs/        確定した仕様
  changes/      進行中の変更（提案）
backend/        API（setup-environment で作る）
frontend/       画面（setup-environment で作る）
```
