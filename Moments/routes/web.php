<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

use Illuminate\Support\Facades\Route;
use Plugins\Moments\Config\ConfigInfo;
use Plugins\Moments\Controllers\AdminController;

$routeName = ConfigInfo::ROUTE_NAME;

Route::prefix($routeName)->name("{$routeName}.")->group(function () {
    // settings
    Route::prefix('admin')->name('admin.')->middleware(['panel', 'panelAuth'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::put('update', [AdminController::class, 'update'])->name('update');
        Route::put('update-languages', [AdminController::class, 'updateLanguages'])->name('update.languages');
    });
});
