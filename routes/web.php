<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AgencyRegistrationController;
use App\Http\Controllers\Admin\AgencyController as AdminAgencyController;
use Illuminate\Support\Facades\Route;

// ============================================
// Public Routes
// ============================================
Route::get('/', function () {
    return view('index');
})->name('homepage');

// ============================================
// Agency Registration Routes (Guest Only)
// ============================================
Route::middleware('guest')->group(function () {
    // Show registration form
    Route::get('/register/agency', [AgencyRegistrationController::class, 'showRegistrationForm'])
        ->name('register.agency');
    
    // Handle registration submission
    Route::post('/register/agency', [AgencyRegistrationController::class, 'register'])
        ->name('register.agency.store');
    
    // AJAX validation endpoints
    Route::prefix('register/agency/check')->name('register.agency.check.')->group(function () {
        Route::get('abn/{abn}', [AgencyRegistrationController::class, 'checkABN'])->name('abn');
        Route::get('license/{licenseNumber}', [AgencyRegistrationController::class, 'checkLicense'])->name('license');
        Route::get('email/{email}', [AgencyRegistrationController::class, 'checkBusinessEmail'])->name('email');
    });
});

// ============================================
// Authenticated Routes
// ============================================
Route::middleware(['auth', 'verified'])->group(function () {
    // Default dashboard (will redirect based on role)
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($user->hasRole('agency')) {
            return redirect()->route('agency.dashboard');
        }
        
        if ($user->hasRole('agent')) {
            return redirect()->route('agent.dashboard');
        }
        
        // Fallback
        return redirect()->route('homepage');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// Agency Routes (Protected - Agency Role Only)
// ============================================
Route::middleware(['auth', 'role:agency'])->prefix('agency')->name('agency.')->group(function () {
    // Agency Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Agency\DashboardController::class, 'index'])
    ->name('dashboard');
    
    // Agency Profile
    Route::get('/profile', function () {
        $agency = auth()->user()->agency;
        return view('agency.profile', compact('agency'));
    })->name('profile');
    
    // Agency Settings
    Route::get('/settings', function () {
        $agency = auth()->user()->agency;
        return view('agency.settings', compact('agency'));
    })->name('settings');
});

// ============================================
// Admin Routes (Protected - Admin Role Only)
// ============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'])
        ->name('dashboard');
    
    // Agency Management
    Route::prefix('agencies')->name('agencies.')->group(function () {
        // List agencies
        Route::get('/', [AdminAgencyController::class, 'index'])->name('index');
        
        // View agency details
        Route::get('/{id}', [AdminAgencyController::class, 'show'])->name('show');
        
        // Edit agency
        Route::get('/{id}/edit', [AdminAgencyController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [AdminAgencyController::class, 'update'])->name('update');
        
        // Approval workflow
        Route::post('/{id}/approve', [AdminAgencyController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminAgencyController::class, 'reject'])->name('reject');
        Route::post('/{id}/suspend', [AdminAgencyController::class, 'suspend'])->name('suspend');
        Route::post('/{id}/reactivate', [AdminAgencyController::class, 'reactivate'])->name('reactivate');
        
        // Delete agency
        Route::delete('/{id}', [AdminAgencyController::class, 'destroy'])->name('destroy');
        
        // API endpoint for pending count
        Route::get('/api/pending-count', [AdminAgencyController::class, 'getPendingCount'])->name('pending.count');
    });
});

// ============================================
// Agent Routes (Protected - Agent Role Only)
// ============================================
Route::middleware(['auth', 'role:agent'])->prefix('agent')->name('agent.')->group(function () {
    // Agent Dashboard
    Route::get('/dashboard', function () {
        return view('agent.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';