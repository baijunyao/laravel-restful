<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('home/categories', \App\Http\Controllers\Home\CategoryController::class);
Route::patch('home/categories/{category}/restore', [\App\Http\Controllers\Home\CategoryController::class, 'restore'])->name('categories.restore');
Route::delete('home/categories/{category}/forceDelete', [App\Http\Controllers\Home\CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

Route::resource('home/tags', \App\Http\Controllers\Home\TagController::class)->only('index', 'show', 'update');
Route::patch('home/tags/{tag}/restore', [\App\Http\Controllers\Home\TagController::class, 'restore'])->name('tags.restore');
Route::delete('home/tags/{tag}/forceDelete', [\App\Http\Controllers\Home\TagController::class, 'forceDelete'])->name('tags.forceDelete');

Route::resource('admin/categories', \App\Http\Controllers\Admin\CategoryController::class)->only('show', 'update');
Route::resource('admin/tags', \App\Http\Controllers\Admin\TagController::class)->only('show', 'update');
