<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventParticipantController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\HeadOfFamilyController;
use App\Http\Controllers\SocialAssistanceController;
use App\Http\Controllers\SocialAssistanceRecipientController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::get('users/all/paginated', [UserController::class, 'getAllPaginated']);


Route::apiResource('head-of-families', HeadOfFamilyController::class);
Route::get('head-of-families/all/paginated', [HeadOfFamilyController::class, 'getAllPaginated']);

Route::apiResource('family-members', FamilyMemberController::class);
Route::get('family-members/all/paginated', [FamilyMemberController::class, 'getAllPaginated']);

Route::apiResource('social-assistances', SocialAssistanceController::class);
Route::get('social-assistances/all/paginated', [SocialAssistanceController::class, 'getAllPaginated']);

Route::apiResource('social-assistance-recipients', SocialAssistanceRecipientController::class);
Route::get('social-assistance-recipients/all/paginated', [SocialAssistanceRecipientController::class, 'getAllPaginated']);

Route::apiResource('events', EventController::class);
Route::get('events/all/paginated', [EventController::class, 'getAllPaginated']);

Route::apiResource('event-participants', EventParticipantController::class);
Route::get('event-participants/all/paginated', [EventParticipantController::class, 'getAllPaginated']);
