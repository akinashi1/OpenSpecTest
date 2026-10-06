# Proposal

## Why

メモ帳アプリの機能（CRUD・ログイン・権限）を作る前に、Laravel（API）・Next.js（画面）・MySQL が
Windows / macOS のどちらでも `docker compose` だけで動く土台と、TDD で開発を進められるテスト環境が必要。
機能と環境構築を同じ変更に混ぜると大きくなりすぎるため、先にこの変更だけで区切る。

## What Changes

- `compose.yaml` を追加し、mysql / phpmyadmin / backend / frontend の4コンテナを `docker compose up -d` で起動できるようにする
- `backend/` に Laravel 12 の雛形を作り、動作確認用のヘルスチェック API（`GET /api/health`）を1つだけ追加する
- `frontend/` に Next.js（App Router + TypeScript）の雛形を作り、デフォルト画面が表示される状態にする
- API のテスト（Pest）と画面のテスト（Vitest + React Testing Library）を、それぞれ1本ずつ通す
- MySQL に開発用 `memo` とテスト用 `memo_test` を作る
- `.env.example`・`.gitignore`・`.gitattributes`（LF 固定）を整える

## Capabilities

### New Capabilities
- `dev-environment`: Docker Compose で起動する開発環境と、API・画面・DB の疎通およびテストの実行

### Modified Capabilities
<!-- なし（既存の spec はない） -->

## Impact

- 新規ファイルのみ（`compose.yaml`、`backend/`、`frontend/`、`.env.example`、`.gitignore`、`.gitattributes`）
- 手元に必要なものは Docker Desktop のみ
- **Out of scope（対象外）**: メモの CRUD、ログイン・認証、権限、DB のテーブル設計、画面のデザイン、本番環境・CI
