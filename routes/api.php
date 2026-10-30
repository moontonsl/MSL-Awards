<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AwardNominationController;

Route::post('/awards/nominate', [AwardNominationController::class, 'store'])->name('api.awards.nominate');
