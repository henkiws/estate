<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AgencyRegistrationController;
use App\Http\Controllers\Admin\AgencyController as AdminAgencyController;
use App\Http\Controllers\Agency\DashboardController as AgencyDashboardController;
use App\Http\Controllers\Agency\OnboardingController;
use App\Http\Controllers\Agency\SubscriptionController;
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
    // Default dashboard redirect
    Route::get('/dashboard', function() {
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
        
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// Agency Onboarding Routes (After Email Verification)
// ============================================
Route::middleware(['auth', 'role:agency', 'verified'])->prefix('agency/onboarding')->name('agency.onboarding.')->group(function () {
    // Show onboarding steps
    Route::get('/{step?}', [OnboardingController::class, 'show'])
        ->name('show')
        ->where('step', '[1-2]');
    
    // Complete Step 1 (Welcome)
    Route::post('/step1/complete', [OnboardingController::class, 'completeStep1'])
        ->name('complete-step1');
    
    // Document Upload/Delete
    Route::post('/documents/upload', [OnboardingController::class, 'uploadDocument'])
        ->name('documents.upload');
    
    Route::delete('/documents/{id}', [OnboardingController::class, 'deleteDocument'])
        ->name('documents.delete');
    
    // Submit for Admin Approval
    Route::post('/submit', [OnboardingController::class, 'submitForApproval'])
        ->name('submit');
    
    // Skip Onboarding
    Route::post('/skip', [OnboardingController::class, 'skip'])
        ->name('skip');
});

// ============================================
// Agency Routes (Protected - Agency Role Only)
// ============================================
Route::middleware(['auth', 'role:agency', 'verified'])->prefix('agency')->name('agency.')->group(function () {
    
    // Agency Dashboard (status-aware routing)
    Route::get('/dashboard', [AgencyDashboardController::class, 'index'])->name('dashboard');
    
    // Document Management
    Route::get('/documents', [AgencyDashboardController::class, 'documents'])->name('documents');
    Route::post('/documents/upload', [AgencyDashboardController::class, 'uploadDocument'])->name('documents.upload');
    Route::delete('/documents/{id}', [AgencyDashboardController::class, 'deleteDocument'])->name('documents.delete');
    
    // Subscription Routes
    Route::prefix('subscription')->name('subscription.')->group(function () {
        // Checkout
        Route::post('/checkout/{plan}', [SubscriptionController::class, 'checkout'])->name('checkout');
        
        // Success/Cancel pages
        Route::get('/success', [SubscriptionController::class, 'success'])->name('success');
        Route::get('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
        
        // Manage subscription (only for active agencies)
        Route::middleware('can:manage-subscription')->group(function () {
            Route::get('/manage', [SubscriptionController::class, 'manage'])->name('manage');
            Route::post('/cancel', [SubscriptionController::class, 'cancelSubscription'])->name('cancel-subscription');
            Route::post('/resume', [SubscriptionController::class, 'resumeSubscription'])->name('resume');
        });
    });
    
    // Protected routes (only for ACTIVE agencies)
    Route::middleware('agency.active')->group(function () {
        
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
        
        // Agent Management (will be implemented later)
        Route::prefix('agents')->name('agents.')->group(function () {
            Route::get('/', function () {
                return view('agency.agents.index');
            })->name('index');
            
            Route::get('/create', function () {
                return view('agency.agents.create');
            })->name('create');
        });
        
        // Properties (will be implemented later)
        Route::prefix('properties')->name('properties.')->group(function () {
            Route::get('/', function () {
                return view('agency.properties.index');
            })->name('index');
        });
    });
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
        // List & CRUD
        Route::get('/', [AdminAgencyController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminAgencyController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminAgencyController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [AdminAgencyController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminAgencyController::class, 'destroy'])->name('destroy');
        
        // Approval Actions
        Route::post('/{id}/approve', [AdminAgencyController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminAgencyController::class, 'reject'])->name('reject');
        Route::post('/{id}/suspend', [AdminAgencyController::class, 'suspend'])->name('suspend');
        Route::post('/{id}/reactivate', [AdminAgencyController::class, 'reactivate'])->name('reactivate');
        
        // Document Management
        Route::post('/{agencyId}/documents/{documentId}/approve', [AdminAgencyController::class, 'approveDocument'])->name('documents.approve');
        Route::post('/{agencyId}/documents/{documentId}/reject', [AdminAgencyController::class, 'rejectDocument'])->name('documents.reject');
        Route::get('/{agencyId}/documents/{documentId}/preview', [AdminAgencyController::class, 'previewDocument'])->name('documents.preview');
        Route::get('/{agencyId}/documents/{documentId}/download', [AdminAgencyController::class, 'downloadDocument'])->name('documents.download');
        
        // API Endpoints
        Route::get('/api/pending-count', [AdminAgencyController::class, 'getPendingCount'])
            ->name('api.pending-count');
    });
    
    // Subscription Plans Management (for future)
    Route::prefix('subscription-plans')->name('subscription-plans.')->group(function () {
        Route::get('/', function () {
            return view('admin.subscription-plans.index');
        })->name('index');
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
    
    // More agent routes...
});

// ============================================
// Stripe Webhook (No CSRF protection)
// ============================================
Route::post('/webhook/stripe', [SubscriptionController::class, 'webhook'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('webhook.stripe');

require __DIR__.'/auth.php';