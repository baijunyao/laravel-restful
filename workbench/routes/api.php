<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::resource('categories', Workbench\App\Http\Controllers\Resources\CategoryController::class);
Route::patch('categories/{category}/restore', [Workbench\App\Http\Controllers\Resources\CategoryController::class, 'restore'])->name('categories.restore');
Route::delete('categories/{category}/forceDelete', [Workbench\App\Http\Controllers\Resources\CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

Route::resource('tags', Workbench\App\Http\Controllers\Resources\TagController::class)->only('index', 'show', 'update');
Route::patch('tags/{tag}/restore', [Workbench\App\Http\Controllers\Resources\TagController::class, 'restore'])->name('tags.restore');
Route::delete('tags/{tag}/forceDelete', [Workbench\App\Http\Controllers\Resources\TagController::class, 'forceDelete'])->name('tags.forceDelete');

Route::resource('admin/categories', Workbench\App\Http\Controllers\Admin\Resources\CategoryController::class)->only('show', 'update');
Route::resource('admin/tags', Workbench\App\Http\Controllers\Admin\Resources\TagController::class)->only('index', 'show', 'update');
