<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;

Route::get('/', [ActivityController::class, 'index'])->name('activity.index');
Route::post('/activity', [ActivityController::class, 'store'])->name('activity.store');
Route::delete('/activity/{id}', [ActivityController::class, 'delete'])->name('activity.delete');
Route::post('/activity/{id}/markAsDone', [ActivityController::class, 'markAsDone'])->name('activity.markAsDone');
Route::post('/activity/{id}/update', [ActivityController::class, 'update'])->name('activity.update');
