<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoListController;

Route::get('todo-list', [TodoListController::class, 'index']);
Route::get('todo-list/{todolist}', [TodoListController::class, 'show']);
Route::post('todo-list', [TodoListController::class, 'store']);
Route::delete('todo-list/{id}', [TodoListController::class, 'destroy']);
Route::patch('todo-list/{list}', [TodoListController::class, 'update']);

