<?php

// spec: dev-environment / Requirement: API のヘルスチェックに応答する

test('正常に応答する', function () {
    $this->getJson('/api/health')
        ->assertOk()
        ->assertExactJson(['status' => 'ok']);
});

test('存在しないパスは 404 を返す', function () {
    // Accept ヘッダーを付けなくても JSON のエラーボディが返ること
    $this->get('/api/not-found')
        ->assertNotFound()
        ->assertHeader('Content-Type', 'application/json')
        ->assertJsonStructure(['message']);
});
