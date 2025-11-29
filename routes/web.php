<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AgencyRegistrationController;
use App\Http\Controllers\Admin\AgencyController as AdminAgencyController;
use App\Http\Controllers\Agency\DashboardController as AgencyDashboardController;
use App\Http\Controllers\Agency\OnboardingController;
use App\Http\Controllers\Agency\SubscriptionController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
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
        
        // Agent Management
        Route::prefix('agents')->name('agents.')->group(function () {
            Route::get('/', [App\Http\Controllers\Agency\AgentController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Agency\AgentController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Agency\AgentController::class, 'store'])->name('store');
            Route::get('/{agent}', [App\Http\Controllers\Agency\AgentController::class, 'show'])->name('show');
            Route::get('/{agent}/edit', [App\Http\Controllers\Agency\AgentController::class, 'edit'])->name('edit');
            Route::patch('/{agent}', [App\Http\Controllers\Agency\AgentController::class, 'update'])->name('update');
            Route::delete('/{agent}', [App\Http\Controllers\Agency\AgentController::class, 'destroy'])->name('destroy');
            
            // Actions
            Route::post('/{agent}/toggle-status', [App\Http\Controllers\Agency\AgentController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{agent}/toggle-featured', [App\Http\Controllers\Agency\AgentController::class, 'toggleFeatured'])->name('toggle-featured');
            Route::post('/{agent}/send-invitation', [App\Http\Controllers\Agency\AgentController::class, 'sendInvitation'])->name('send-invitation');
            Route::delete('/{agent}/photo', [App\Http\Controllers\Agency\AgentController::class, 'deletePhoto'])->name('delete-photo');
        });
        
        // Property Management
        Route::prefix('properties')->name('properties.')->group(function () {
            Route::get('/', [App\Http\Controllers\Agency\PropertyController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Agency\PropertyController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Agency\PropertyController::class, 'store'])->name('store');
            Route::get('/{property}', [App\Http\Controllers\Agency\PropertyController::class, 'show'])->name('show');
            Route::get('/{property}/edit', [App\Http\Controllers\Agency\PropertyController::class, 'edit'])->name('edit');
            Route::patch('/{property}', [App\Http\Controllers\Agency\PropertyController::class, 'update'])->name('update');
            Route::delete('/{property}', [App\Http\Controllers\Agency\PropertyController::class, 'destroy'])->name('destroy');
            
            // Actions ✅
            Route::post('/{property}/publish', [App\Http\Controllers\Agency\PropertyController::class, 'publish'])->name('publish');
            Route::post('/{property}/unpublish', [App\Http\Controllers\Agency\PropertyController::class, 'unpublish'])->name('unpublish');
            Route::post('/{property}/mark-sold', [App\Http\Controllers\Agency\PropertyController::class, 'markAsSold'])->name('mark-sold');
            Route::post('/{property}/toggle-featured', [App\Http\Controllers\Agency\PropertyController::class, 'toggleFeatured'])->name('toggle-featured');
            
            // Images ✅
            Route::post('/{property}/images', [App\Http\Controllers\Agency\PropertyController::class, 'uploadImages'])->name('upload-images');
            Route::delete('/{property}/images/{image}', [App\Http\Controllers\Agency\PropertyController::class, 'deleteImage'])->name('delete-image');
            Route::post('/{property}/images/{image}/featured', [App\Http\Controllers\Agency\PropertyController::class, 'setFeaturedImage'])->name('set-featured-image');
        });

        Route::prefix('applications')->name('applications.')->group(function () {
            Route::get('/', [ApplicationController::class, 'index'])->name('index');
            Route::get('/{application}', [ApplicationController::class, 'show'])->name('show');
            Route::post('/{application}/approve', [ApplicationController::class, 'approve'])->name('approve');
            Route::post('/{application}/reject', [ApplicationController::class, 'reject'])->name('reject');
            Route::delete('/{application}', [ApplicationController::class, 'destroy'])->name('destroy');
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

    // Properties Management
    Route::prefix('properties')->name('properties.')->group(function () {
        Route::get('/', [PropertyController::class, 'index'])->name('index');
        Route::get('/statistics', [PropertyController::class, 'statistics'])->name('statistics');
        Route::get('/export', [PropertyController::class, 'export'])->name('export');
        Route::get('/{property}', [PropertyController::class, 'show'])->name('show');
        Route::get('/{property}/edit', [PropertyController::class, 'edit'])->name('edit');
        Route::put('/{property}', [PropertyController::class, 'update'])->name('update');
        Route::delete('/{property}', [PropertyController::class, 'destroy'])->name('destroy');
        
        // Property Actions
        Route::post('/{property}/toggle-featured', [PropertyController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::post('/{property}/toggle-verified', [PropertyController::class, 'toggleVerified'])->name('toggle-verified');
        Route::post('/bulk-update', [PropertyController::class, 'bulkUpdate'])->name('bulk-update');
    });

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/statistics', [UserController::class, 'statistics'])->name('statistics');
        Route::get('/export', [UserController::class, 'export'])->name('export');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        
        // User Actions
        Route::post('/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('toggle-admin');
        Route::post('/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('verify-email');
        Route::post('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/bulk-update', [UserController::class, 'bulkUpdate'])->name('bulk-update');
    });

    // Payment Management
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/statistics', [PaymentController::class, 'statistics'])->name('statistics');
        Route::get('/export', [PaymentController::class, 'export'])->name('export');
        Route::get('/subscriptions', [PaymentController::class, 'subscriptions'])->name('subscriptions');
        Route::get('/failed', [PaymentController::class, 'failedPayments'])->name('failed');
        Route::get('/refunds', [PaymentController::class, 'refunds'])->name('refunds');
        Route::get('/{transaction}', [PaymentController::class, 'show'])->name('show');
        
        // Payment Actions
        Route::post('/{transaction}/refund', [PaymentController::class, 'processRefund'])->name('process-refund');
        Route::post('/{transaction}/retry', [PaymentController::class, 'retryPayment'])->name('retry');
        Route::post('/subscriptions/{subscription}/cancel', [PaymentController::class, 'cancelSubscription'])->name('cancel-subscription');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/overview', [ReportController::class, 'overview'])->name('overview');
        Route::get('/agencies', [ReportController::class, 'agencies'])->name('agencies');
        Route::get('/properties', [ReportController::class, 'properties'])->name('properties');
        Route::get('/users', [ReportController::class, 'users'])->name('users');
        Route::get('/revenue', [ReportController::class, 'revenue'])->name('revenue');
        Route::get('/export', [ReportController::class, 'export'])->name('export');
    });

    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [AdminProfileController::class, 'show'])->name('show');
        Route::get('/edit', [AdminProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [AdminProfileController::class, 'update'])->name('update');
        
        // Password
        Route::put('/password', [AdminProfileController::class, 'updatePassword'])->name('password.update');
        
        // Avatar
        Route::post('/avatar', [AdminProfileController::class, 'updateAvatar'])->name('avatar.update');
        Route::delete('/avatar', [AdminProfileController::class, 'deleteAvatar'])->name('avatar.delete');
        
        // Settings
        Route::get('/settings', [AdminProfileController::class, 'settings'])->name('settings');
        Route::put('/settings', [AdminProfileController::class, 'updateSettings'])->name('settings.update');
        
        // Security
        Route::get('/security', [AdminProfileController::class, 'security'])->name('security');
        Route::post('/security/2fa/enable', [AdminProfileController::class, 'enableTwoFactor'])->name('security.2fa.enable');
        Route::post('/security/2fa/disable', [AdminProfileController::class, 'disableTwoFactor'])->name('security.2fa.disable');
        
        // Activity
        Route::get('/activity', [AdminProfileController::class, 'activity'])->name('activity');
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
Route::post('/webhook/stripe', [SubscriptionController::class, 'webhook'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])->name('webhook.stripe');

// Public Property Page
Route::get('/properties/{code}', [PublicPropertyController::class, 'show'])->name('property.show');

// Submit Application
Route::post('/properties/{code}/apply', [PublicPropertyController::class, 'submitApplication'])->name('property.apply');

require __DIR__.'/auth.php';