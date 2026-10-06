<?php

// spec: dev-environment / Requirement: API と画面のテストを実行できる
// （テストは開発用 memo ではなく、テスト用 memo_test だけを使う）

test('テストはテスト用 DB に接続している', function () {
    expect(config('database.connections.mysql.database'))->toBe('memo_test');
});
