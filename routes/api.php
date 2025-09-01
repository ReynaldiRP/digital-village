<?php

use App\Http\Controllers\HeadOfFamilyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::get('users/all/paginated', [UserController::class, 'getAllPaginated']);


Route::apiResource('head-of-families', HeadOfFamilyController::class);
Route::get('head-of-families/all/paginated', [HeadOfFamilyController::class, 'getAllPaginated']);
