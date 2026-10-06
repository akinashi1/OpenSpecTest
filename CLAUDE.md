# OpenSpecTest

OpenSpec の動作確認用のメモ帳アプリ（Laravel + Next.js + MySQL、Docker で動かす）。
検証用なので、最小限の実装にとどめる。

- 構成・開発環境・TDD の方針は `openspec/config.yaml` を読む
- 機能の追加・変更は OpenSpec で進める（`/opsx:propose` → `/opsx:apply` → `/opsx:archive`）
- 開発は Docker のみで行う。ホストに PHP・Composer・Node を入れない。操作は `docker compose ...` に統一する
- 実装の前に、失敗するテストを先に書く（TDD）
- コミット・push は、明示的に頼まれたときだけ行う
