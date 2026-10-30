<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AwardNominationController;
use App\Http\Controllers\GoogleSheetAwardNominationsController;

// Awards API
Route::post('/api/awards/nominate', [AwardNominationController::class, 'store'])->name('api.awards.nominate');

// Awards Pages
Route::get('/', function () {
    return Inertia::render('Awards/NetworkAwards');
})->name('network.awards');

Route::get('/Organization', function () {
    return Inertia::render('Awards/OrganizationAwards', [
        'isMlAuthenticated' => session()->has('ml_user')
    ]);
})->name('network.awards.organization');

Route::get('/Individual', function () {
    return Inertia::render('Awards/IndividualAwards', [
        'isMlAuthenticated' => session()->has('ml_user')
    ]);
})->name('network.awards.individual');

Route::get('/Nominate/{awardId}', function (string $awardId) {
    $isMlAuthenticated = session()->has('ml_user');
    $fullName = '';
    $isReadOnly = false;
    
    if (session()->has('ml_user')) {
        $mlUser = session('ml_user');
        $user = \App\Models\User::where('ml_id', $mlUser->ml_id)->first();
        if ($user) {
            $fullName = trim($user->name . ' ' . $user->surname);
            $isReadOnly = true;
        }
    }

    return Inertia::render('Awards/AwardNominationForm', [
        'awardId' => $awardId,
        'prefilledName' => $fullName,
        'isNameReadOnly' => $isReadOnly,
        'isMlAuthenticated' => $isMlAuthenticated,
    ]);
})->name('network.awards.nominate');

Route::get('/NominateStudent/{awardId}', function (string $awardId) {
    $isMlAuthenticated = session()->has('ml_user');
    $fullName = '';
    $isReadOnly = false;
    
    if (session()->has('ml_user')) {
        $mlUser = session('ml_user');
        $user = \App\Models\User::where('ml_id', $mlUser->ml_id)->first();
        if ($user) {
            $fullName = trim($user->name . ' ' . $user->surname);
            $isReadOnly = true;
        }
    }

    return Inertia::render('Awards/StudentAwardNominationForm', [
        'awardId' => $awardId,
        'prefilledName' => $fullName,
        'isNameReadOnly' => $isReadOnly,
        'isMlAuthenticated' => $isMlAuthenticated,
    ]);
})->name('network.awards.nominate.student');

// Backwards-compatible redirects (old path -> new path)
Route::redirect('/MSLNetworkAwards', '/', 301);
Route::redirect('/MSLNetworkAwards/Organization', '/Organization', 301);
Route::redirect('/MSLNetworkAwards/Individual', '/Individual', 301);
Route::redirect('/MSLNetworkAwards/Nominate/{awardId}', '/Nominate/{awardId}', 301);
Route::redirect('/MSLNetworkAwards/NominateStudent/{awardId}', '/NominateStudent/{awardId}', 301);
