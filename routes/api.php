<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;




// Retrieve a list of members with optional filters
Route::get('/members', [MemberController::class, 'index'])->name('members.index');

// Retrieve a specific member by ID
Route::get('/members/{id}', [MemberController::class, 'show'])->name('members.show');

// Create a new member
Route::post('/members', [MemberController::class, 'store'])->name('members.store');

// Update an existing member by ID
Route::put('/members/{id}', [MemberController::class, 'update'])->name('members.update');

// Delete a member by ID
Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');

