# 開発の進め方（OpenSpec）

> **このファイルは人間向けのメモです。Claude への指示ではなく、Claude は作業の判断に使いません。**
> Claude への指示は `CLAUDE.md` と `openspec/config.yaml` に書く。

このリポジトリは Claude Code で開き、`OpenSpecTest` を作業フォルダにして進める。

## 1機能（1変更）あたりのフロー

```
/opsx:propose <変更名>  →  確認  →  コミット（提案）
/opsx:apply             →  テスト確認  →  コミット（実装）
/opsx:archive           →  コミット（アーカイブ）
```

| # | 手順 | 内容 | 確認すること |
|---|---|---|---|
| 1 | `/opsx:propose <変更名>` | proposal・spec・design・tasks を作る（コードは書かない） | spec の Scenario、対象外、tasks がテスト先行の順になっているか |
| 2 | 提案をコミット | `docs(openspec): <変更名> の提案を追加する` | — |
| 3 | `/opsx:apply` | tasks に沿って、テストを先に書いて実装する | `docker compose exec backend php artisan test` と `docker compose exec frontend npm test` が通る |
| 4 | 実装をコミット | `feat: ...`（機能）／ `chore: ...`（環境など） | — |
| 5 | `/opsx:archive` | 差分を `openspec/specs/` の確定した仕様に統合し、変更を `archive/` へ移す | `openspec/specs/` に仕様が入っている |
| 6 | アーカイブをコミット | `docs(openspec): <変更名> をアーカイブする` | — |

- 前の変更は、**アーカイブしてから**次の変更に進む（次の提案が確定した仕様を参照するため）
- 途中でセッションを閉じても、tasks のチェックボックスを見て続きから進められる
- コミット・push は、頼まれたときだけ行う

## 具体的な指示はどこで出すか

置き場所は4つある。決めたい内容によって使い分ける。

| 場所 | 使いどき | 例 |
|---|---|---|
| ① `/opsx:propose` の後ろ | その変更だけの具体的な要望 | `/opsx:propose add-memo-crud メモはタイトル必須、本文は任意。削除は物理削除` |
| ② 提案ができたあとの会話 | 提案の内容を直す | 「他人のメモは 404 ではなく 403 にして」「ページネーションは対象外にして」 |
| ③ 成果物のファイルを直接編集 | 細かい文言や数値の修正 | `openspec/changes/<変更名>/specs/…/spec.md` を直接書き換える |
| ④ `openspec/config.yaml` | すべての変更に共通する前提・ルール | スタック、TDD、「Scenario には正常系と異常系を書く」 |

- **変更ごとの仕様**（メモの項目、エラーの返し方など）は ① か ② で伝える。④ には書かない（古くなり、spec と二重管理になるため）。
- 指示が足りなくても提案は作られる。仕様を左右する曖昧さだけ質問が返り、細かいことは仮定を置いて proposal に書かれる。
- **提案の確認が一番大事**。`/opsx:apply` で実装に入る前に、spec の Scenario と tasks を読み、直すならここで直す。

## 変更の順番

1. `setup-environment`: Docker 環境と雛形
2. `add-memo-crud`: メモの作成・一覧・取得・更新・削除
3. `add-auth`: 登録・ログイン・ログアウト
4. `add-permissions`: ロール（user / admin）と所有者チェック

構成・方針の詳細は [`openspec/config.yaml`](../openspec/config.yaml) にある。
