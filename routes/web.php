<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [QuestionController::class, 'home'])->name('home');
Route::get('/quiz', [QuestionController::class, 'quiz'])->name('quiz');
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/questions/create', [QuestionController::class, 'create'])->middleware('admin')->name('questions.create');
Route::post('/questions', [QuestionController::class, 'store'])->middleware('admin')->name('questions.store');
Route::post('/questions/bulk', [QuestionController::class, 'bulkStore'])->middleware('admin')->name('questions.bulk');
Route::delete('/questions', [QuestionController::class, 'destroyAll'])->middleware('admin')->name('questions.destroyAll');
Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->middleware('admin')->name('questions.destroy');
Route::post('/questions/{question}/tip', [QuestionController::class, 'tip'])->name('questions.tip');
Route::post('/questions/{question}/ai-explain', [QuestionController::class, 'aiExplain'])->name('questions.ai');
