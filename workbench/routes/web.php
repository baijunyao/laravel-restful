<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::resource('home/categories', Workbench\App\Http\Controllers\Home\CategoryController::class);
Route::patch('home/categories/{category}/restore', [Workbench\App\Http\Controllers\Home\CategoryController::class, 'restore'])->name('categories.restore');
Route::delete('home/categories/{category}/forceDelete', [Workbench\App\Http\Controllers\Home\CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

Route::resource('home/tags', Workbench\App\Http\Controllers\Home\TagController::class)->only('index', 'show', 'update');
Route::patch('home/tags/{tag}/restore', [Workbench\App\Http\Controllers\Home\TagController::class, 'restore'])->name('tags.restore');
Route::delete('home/tags/{tag}/forceDelete', [Workbench\App\Http\Controllers\Home\TagController::class, 'forceDelete'])->name('tags.forceDelete');

Route::resource('admin/categories', Workbench\App\Http\Controllers\Admin\CategoryController::class)->only('show', 'update');
Route::resource('admin/tags', Workbench\App\Http\Controllers\Admin\TagController::class)->only('show', 'update');
