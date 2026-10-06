<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// DB に届くことも含めて確認する
Route::get('/health', function () {
    DB::select('select 1');

    return response()->json(['status' => 'ok']);
});
