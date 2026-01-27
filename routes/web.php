<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AgencyRegistrationController;
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
    Route::get('/register/agency', [AgencyRegistrationController::class, 'showRegistrationForm'])->name('register.agency');
    // Handle registration submission
    Route::post('/register/agency', [AgencyRegistrationController::class, 'register'])->name('register.agency.store');
    // AJAX validation endpoints
    Route::prefix('register/agency/check')->name('register.agency.check.')->group(function () {
        Route::get('abn/{abn}', [AgencyRegistrationController::class, 'checkABN'])->name('abn');
        Route::get('license/{licenseNumber}', [AgencyRegistrationController::class, 'checkLicense'])->name('license');
        Route::get('email/{email}', [AgencyRegistrationController::class, 'checkBusinessEmail'])->name('email');
    });
});

// ============================================
// User Registration Routes (Guest Only)
// ============================================
Route::middleware('guest')->group(function () {
    // Show user registration form
    Route::get('/register/user', [App\Http\Controllers\Auth\UserRegistrationController::class, 'showRegistrationForm'])->name('register.user');
    // Handle user registration submission
    Route::post('/register/user', [App\Http\Controllers\Auth\UserRegistrationController::class, 'register'])->name('register.user.store');
    // Optional: AJAX validation endpoint for email uniqueness
    Route::get('/register/user/check-email/{email}', [App\Http\Controllers\Auth\UserRegistrationController::class, 'checkEmail'])->name('register.user.check.email');
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
        if ($user->hasRole('user')) {
            return redirect()->route('user.dashboard');
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
    Route::get('/file-preview/{path}', [App\Http\Controllers\Agency\OnboardingController::class, 'filePreview'])->where('path', '.*')->name('file-preview');
    Route::get('/{step?}', [App\Http\Controllers\Agency\OnboardingController::class, 'show'])->name('show')->where('step', '[1-2]');
    // Complete Step 1 (Welcome)
    Route::post('/step1/complete', [App\Http\Controllers\Agency\OnboardingController::class, 'completeStep1'])->name('complete-step1');
    // Document Upload/Delete
    Route::post('/documents/upload', [App\Http\Controllers\Agency\OnboardingController::class, 'uploadDocument'])->name('documents.upload');
    Route::delete('/documents/{id}', [App\Http\Controllers\Agency\OnboardingController::class, 'deleteDocument'])->name('documents.delete');
    // Submit for Admin Approval
    Route::post('/submit', [App\Http\Controllers\Agency\OnboardingController::class, 'submitForApproval'])->name('submit');
    // Skip Onboarding
    Route::post('/skip', [App\Http\Controllers\Agency\OnboardingController::class, 'skip'])->name('skip');
});

// ============================================
// Agency Routes (Protected - Agency Role Only)
// ============================================
Route::middleware(['auth', 'role:agency', 'verified'])->prefix('agency')->name('agency.')->group(function () {
    // Agency Dashboard (status-aware routing)
    Route::get('/dashboard', [App\Http\Controllers\Agency\DashboardController::class, 'index'])->name('dashboard');
    // Document Management
    Route::get('/documents', [App\Http\Controllers\Agency\DashboardController::class, 'documents'])->name('documents');
    Route::post('/documents/upload', [App\Http\Controllers\Agency\DashboardController::class, 'uploadDocument'])->name('documents.upload');
    Route::delete('/documents/{id}', [App\Http\Controllers\Agency\DashboardController::class, 'deleteDocument'])->name('documents.delete');
    Route::post('/onboarding/new-application', [App\Http\Controllers\Agency\DashboardController::class, 'newApplication'])->name('onboarding.new-application');
    // Subscription Routes
    Route::prefix('subscription')->name('subscription.')->group(function () {
        // Checkout
        Route::post('/checkout/{plan}', [App\Http\Controllers\Agency\SubscriptionController::class, 'checkout'])->name('checkout');
        // Success/Cancel pages
        Route::get('/success', [App\Http\Controllers\Agency\SubscriptionController::class, 'success'])->name('success');
        Route::get('/cancel', [App\Http\Controllers\Agency\SubscriptionController::class, 'cancel'])->name('cancel');
        // Manage subscription (only for active agencies)
        Route::middleware('can:manage-subscription')->group(function () {
            Route::get('/manage', [App\Http\Controllers\Agency\SubscriptionController::class, 'manage'])->name('manage');
            Route::post('/cancel', [App\Http\Controllers\Agency\SubscriptionController::class, 'cancelSubscription'])->name('cancel-subscription');
            Route::post('/resume', [App\Http\Controllers\Agency\SubscriptionController::class, 'resumeSubscription'])->name('resume');
        });
    });
    
    // Protected routes (only for ACTIVE agencies)
    Route::middleware('agency.active')->group(function () {
        // Agency Profile Management
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/edit', [App\Http\Controllers\Agency\AgencyProfileController::class, 'edit'])->name('edit');
            Route::patch('/update', [App\Http\Controllers\Agency\AgencyProfileController::class, 'update'])->name('update');
            Route::delete('/logo', [App\Http\Controllers\Agency\AgencyProfileController::class, 'deleteLogo'])->name('delete-logo');
            Route::delete('/license-attachment', [App\Http\Controllers\Agency\AgencyProfileController::class, 'deleteLicenseAttachment'])->name('delete-license-attachment');
            Route::delete('/insurance-attachment', [App\Http\Controllers\Agency\AgencyProfileController::class, 'deleteInsuranceAttachment'])->name('delete-insurance-attachment');
        });
        // Billing & Subscription History
        Route::prefix('billing')->name('billing.')->group(function () {
            Route::get('/', [App\Http\Controllers\Agency\BillingController::class, 'index'])->name('index');
            Route::get('/invoice/{transaction}', [App\Http\Controllers\Agency\BillingController::class, 'downloadInvoice'])->name('download-invoice');
        });
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
            // Property Applications & Bookings
            Route::get('/{property}/applications', [App\Http\Controllers\Agency\PropertyController::class, 'applications'])->name('applications');
            Route::get('/{property}/bookings', [App\Http\Controllers\Agency\PropertyController::class, 'bookings'])->name('bookings');
            Route::get('applications/{application}/download', [App\Http\Controllers\Agency\PropertyController::class, 'downloadApplication'])->name('applications.download');
        });
        Route::prefix('applications')->name('applications.')->group(function () {
            Route::get('/', [ApplicationController::class, 'index'])->name('index');
            Route::get('/{application}', [ApplicationController::class, 'show'])->name('show');
            Route::post('/{application}/approve', [ApplicationController::class, 'approve'])->name('approve');
            Route::post('/{application}/reject', [ApplicationController::class, 'reject'])->name('reject');
            Route::delete('/{application}', [ApplicationController::class, 'destroy'])->name('destroy');
        });

        Route::controller(App\Http\Controllers\Agency\ApplicationController::class)
            ->prefix('applications')->name('applications.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{application}', 'show')->name('show');
                Route::post('/{application}/approve', 'approve')->name('approve');
                Route::post('/{application}/reject', 'reject')->name('reject');
                Route::post('/{application}/under-review', 'markUnderReview')->name('under-review');
            });

        Route::controller(App\Http\Controllers\Agency\TenantController::class)
            ->prefix('tenants')->name('tenants.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{tenant}', 'show')->name('show');
                Route::get('/{tenant}/edit', 'edit')->name('edit');
                Route::put('/{tenant}', 'update')->name('update');
                Route::post('/{tenant}/move-in', 'markAsMovedIn')->name('move-in');
                Route::post('/{tenant}/move-out', 'markAsMovedOut')->name('move-out');
                Route::post('/{tenant}/give-notice', 'giveNotice')->name('give-notice');
                Route::post('/{tenant}/mark-bond-paid', 'markBondPaid')->name('mark-bond-paid');
                Route::post('/{tenant}/update-payment-due', 'updatePaymentDue')->name('update-payment-due');
            });

        Route::controller(App\Http\Controllers\Agency\ReportController::class)
            ->prefix('reports')->name('reports.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/properties', 'properties')->name('properties');
                Route::get('/applications', 'applications')->name('applications');
                Route::get('/tenants', 'tenants')->name('tenants');
                Route::get('/financial', 'financial')->name('financial');
                Route::post('/export', 'export')->name('export');
            });
    });

    Route::controller(App\Http\Controllers\Agency\NotificationController::class)
        ->prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{notification}', 'show')->name('show');
        });

    // Support & Help
    Route::controller(App\Http\Controllers\Agency\SupportController::class)
        ->prefix('support')->name('support.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{ticket}', 'show')->name('show');
            Route::post('/{ticket}/reply', 'reply')->name('reply');
            Route::patch('/{ticket}/close', 'close')->name('close');
        });
});

// ============================================
// Admin Routes (Protected - Admin Role Only)
// ============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard');
    // Agency Management
    Route::prefix('agencies')->name('agencies.')->group(function () {
        // List & CRUD
        Route::get('/', [App\Http\Controllers\Admin\AgencyController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\Admin\AgencyController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\AgencyController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [App\Http\Controllers\Admin\AgencyController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\AgencyController::class, 'destroy'])->name('destroy');
        // Approval Actions
        Route::post('/{id}/approve', [App\Http\Controllers\Admin\AgencyController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [App\Http\Controllers\Admin\AgencyController::class, 'reject'])->name('reject');
        Route::post('/{id}/suspend', [App\Http\Controllers\Admin\AgencyController::class, 'suspend'])->name('suspend');
        Route::post('/{id}/reactivate', [App\Http\Controllers\Admin\AgencyController::class, 'reactivate'])->name('reactivate');
        // Document Management
        Route::post('/{agencyId}/documents/{documentId}/approve', [App\Http\Controllers\Admin\AgencyController::class, 'approveDocument'])->name('documents.approve');
        Route::post('/{agencyId}/documents/{documentId}/reject', [App\Http\Controllers\Admin\AgencyController::class, 'rejectDocument'])->name('documents.reject');
        Route::get('/{agencyId}/documents/{documentId}/preview', [App\Http\Controllers\Admin\AgencyController::class, 'previewDocument'])->name('documents.preview');
        Route::get('/{agencyId}/documents/{documentId}/download', [App\Http\Controllers\Admin\AgencyController::class, 'downloadDocument'])->name('documents.download');
        // API Endpoints
        Route::get('/api/pending-count', [App\Http\Controllers\Admin\AgencyController::class, 'getPendingCount'])->name('api.pending-count');
    });
    // Properties Management
    Route::prefix('properties')->name('properties.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PropertyController::class, 'index'])->name('index');
        Route::get('/statistics', [App\Http\Controllers\Admin\PropertyController::class, 'statistics'])->name('statistics');
        Route::get('/export', [App\Http\Controllers\Admin\PropertyController::class, 'export'])->name('export');
        Route::get('/{property}', [App\Http\Controllers\Admin\PropertyController::class, 'show'])->name('show');
        Route::get('/{property}/edit', [App\Http\Controllers\Admin\PropertyController::class, 'edit'])->name('edit');
        Route::put('/{property}', [App\Http\Controllers\Admin\PropertyController::class, 'update'])->name('update');
        Route::delete('/{property}', [App\Http\Controllers\Admin\PropertyController::class, 'destroy'])->name('destroy');
        // Property Actions
        Route::post('/{property}/toggle-featured', [App\Http\Controllers\Admin\PropertyController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::post('/{property}/toggle-verified', [App\Http\Controllers\Admin\PropertyController::class, 'toggleVerified'])->name('toggle-verified');
        Route::post('/bulk-update', [App\Http\Controllers\Admin\PropertyController::class, 'bulkUpdate'])->name('bulk-update');
    });
    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::get('/statistics', [App\Http\Controllers\Admin\UserController::class, 'statistics'])->name('statistics');
        Route::get('/export', [App\Http\Controllers\Admin\UserController::class, 'export'])->name('export');
        Route::get('/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
        // User Actions
        Route::post('/{user}/toggle-admin', [App\Http\Controllers\Admin\UserController::class, 'toggleAdmin'])->name('toggle-admin');
        Route::post('/{user}/verify-email', [App\Http\Controllers\Admin\UserController::class, 'verifyEmail'])->name('verify-email');
        Route::post('/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/bulk-update', [App\Http\Controllers\Admin\UserController::class, 'bulkUpdate'])->name('bulk-update');
    });
    // Payment Management
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('index');
        Route::get('/statistics', [App\Http\Controllers\Admin\PaymentController::class, 'statistics'])->name('statistics');
        Route::get('/export', [App\Http\Controllers\Admin\PaymentController::class, 'export'])->name('export');
        Route::get('/subscriptions', [App\Http\Controllers\Admin\PaymentController::class, 'subscriptions'])->name('subscriptions');
        Route::get('/failed', [App\Http\Controllers\Admin\PaymentController::class, 'failedPayments'])->name('failed');
        Route::get('/refunds', [App\Http\Controllers\Admin\PaymentController::class, 'refunds'])->name('refunds');
        Route::get('/{transaction}', [App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('show'); 
        // Payment Actions
        Route::post('/{transaction}/refund', [App\Http\Controllers\Admin\PaymentController::class, 'processRefund'])->name('process-refund');
        Route::post('/{transaction}/retry', [App\Http\Controllers\Admin\PaymentController::class, 'retryPayment'])->name('retry');
        Route::post('/subscriptions/{subscription}/cancel', [App\Http\Controllers\Admin\PaymentController::class, 'cancelSubscription'])->name('cancel-subscription');
    });
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('index');
        Route::get('/overview', [App\Http\Controllers\Admin\ReportController::class, 'overview'])->name('overview');
        Route::get('/agencies', [App\Http\Controllers\Admin\ReportController::class, 'agencies'])->name('agencies');
        Route::get('/properties', [App\Http\Controllers\Admin\ReportController::class, 'properties'])->name('properties');
        Route::get('/users', [App\Http\Controllers\Admin\ReportController::class, 'users'])->name('users');
        Route::get('/revenue', [App\Http\Controllers\Admin\ReportController::class, 'revenue'])->name('revenue');
        Route::get('/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('export');
    });
    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('update');
        // Password
        Route::put('/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('password.update');
        // Avatar
        Route::post('/avatar', [App\Http\Controllers\Admin\ProfileController::class, 'updateAvatar'])->name('avatar.update');
        Route::delete('/avatar', [App\Http\Controllers\Admin\ProfileController::class, 'deleteAvatar'])->name('avatar.delete');
        // Settings
        Route::get('/settings', [App\Http\Controllers\Admin\ProfileController::class, 'settings'])->name('settings');
        Route::put('/settings', [App\Http\Controllers\Admin\ProfileController::class, 'updateSettings'])->name('settings.update');
        // Security
        Route::get('/security', [App\Http\Controllers\Admin\ProfileController::class, 'security'])->name('security');
        Route::post('/security/2fa/enable', [App\Http\Controllers\Admin\ProfileController::class, 'enableTwoFactor'])->name('security.2fa.enable');
        Route::post('/security/2fa/disable', [App\Http\Controllers\Admin\ProfileController::class, 'disableTwoFactor'])->name('security.2fa.disable');
        // Activity
        Route::get('/activity', [App\Http\Controllers\Admin\ProfileController::class, 'activity'])->name('activity');
    });
    Route::controller(App\Http\Controllers\Admin\NotificationController::class)
        ->prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/analytics', 'analytics')->name('analytics');
            Route::get('/{notification}', 'show')->name('show');
            Route::delete('/{notification}', 'destroy')->name('destroy');
        });
    // Support Management
    Route::controller(App\Http\Controllers\Admin\SupportController::class)
        ->prefix('support')->name('support.')->group(function () {
            Route::get('/tickets', 'index')->name('tickets.index');
            Route::get('/analytics', 'analytics')->name('analytics');
            Route::get('/tickets/{ticket}', 'show')->name('tickets.show');
            Route::post('/tickets/{ticket}/reply', 'reply')->name('tickets.reply');
            Route::patch('/tickets/{ticket}/status', 'updateStatus')->name('tickets.update-status');
            Route::patch('/tickets/{ticket}/priority', 'updatePriority')->name('tickets.update-priority');
            Route::patch('/tickets/{ticket}/assign', 'assign')->name('tickets.assign');
        });
    Route::get('/profiles/{profile}/history', [App\Http\Controllers\Admin\ProfileApprovalController::class, 'history'])->name('profiles.history');
    // Profile approval
    Route::get('/profiles', [App\Http\Controllers\Admin\ProfileApprovalController::class, 'index'])->name('profiles.index');
    Route::get('/profiles/{profile}', [App\Http\Controllers\Admin\ProfileApprovalController::class, 'show'])->name('profiles.show');
    Route::post('/profiles/{profile}/approve', [App\Http\Controllers\Admin\ProfileApprovalController::class, 'approve'])->name('profiles.approve');
    Route::post('/profiles/{profile}/reject', [App\Http\Controllers\Admin\ProfileApprovalController::class, 'reject'])->name('profiles.reject');
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
    
    Route::controller(App\Http\Controllers\Agent\NotificationController::class)
        ->prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{notification}', 'show')->name('show');
        });
});

// ============================================
// Property Actions (Require Auth)
// ============================================
Route::middleware(['auth'])->group(function () {
    // Enquiries (requires login)
    Route::post('/properties/{code}/enquiry', [PublicPropertyController::class, 'submitEnquiry'])->name('properties.enquiry');
    // Save/Unsave property (requires login + user role)
    Route::post('/properties/{code}/toggle-save', [App\Http\Controllers\User\SavedPropertyController::class, 'toggle'])->name('properties.toggle-save')->middleware('role:user');
});

// ============================================
// USER ROUTES - Protected by Auth + User Role
// ============================================
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
   // ============================================
    // PROFILE COMPLETION (No profile.complete middleware)
    // ============================================
    Route::prefix('profile')->name('profile.')->group(function () {
        // Profile overview - NEW card-based interface (main entry point)
        Route::get('/overview', [App\Http\Controllers\User\ProfileCompletionController::class, 'overview'])->name('overview');
        // Profile completion flow (legacy - redirects to overview)
        Route::get('/complete', [App\Http\Controllers\User\ProfileCompletionController::class, 'index'])->name('complete');
        // Update any step (handles form submissions from cards)
        Route::post('/update-step', [App\Http\Controllers\User\ProfileCompletionController::class, 'updateStep'])->name('update-step');
        Route::post('/previous-step', [App\Http\Controllers\User\ProfileCompletionController::class, 'previousStep'])->name('previous-step');
        // View profile (read-only) - accessible anytime
        Route::get('/view', [App\Http\Controllers\User\ProfileCompletionController::class, 'view'])->name('view');
        // Legacy step-based route (for backward compatibility)
        Route::get('/complete/{step?}', [App\Http\Controllers\User\ProfileCompletionController::class, 'show'])->name('step');
    });

    // ============================================
    // PROTECTED ROUTES (Require completed profile)
    // ============================================
    Route::middleware(['profile.complete'])->group(function () {
        // ------------------------------------------
        // Dashboard
        // ------------------------------------------
        Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
        // ------------------------------------------
        // User Profile (View after completion)
        // ------------------------------------------
        Route::put('/profile/update-state', [App\Http\Controllers\User\ProfileController::class, 'updateState'])->name('profile.update-state');
        // ------------------------------------------
        // Application Management
        Route::controller(App\Http\Controllers\User\ApplicationController::class)->prefix('applications')->name('applications.')->group(function () {
            Route::get('/', 'index')->name('index');                    // List all applications
            Route::get('/browse-properties', 'browse')->name('browse'); // Browse properties to apply
            Route::get('/create', 'create')->name('create');            // Show application form
            Route::post('/', 'store')->name('store');                   // Submit application
            Route::get('/{id}', 'show')->name('show');                  // View single application
            Route::get('/{id}/edit', 'edit')->name('edit');             // Edit application form
            Route::put('/{id}', 'update')->name('update');              // Update application
            Route::patch('/{id}/withdraw', 'withdraw')->name('withdraw'); // Withdraw application
            Route::delete('/{id}', 'destroy')->name('destroy');         // Delete application
        });

        // Saved Properties
        Route::get('/saved-properties', [App\Http\Controllers\User\SavedPropertyController::class, 'index'])->name('saved-properties.index');
        Route::delete('/saved-properties/{property}', [App\Http\Controllers\User\SavedPropertyController::class, 'destroy'])->name('saved-properties.destroy');

        // Apply for property (create application)
        Route::get('/properties/{code}/apply', [App\Http\Controllers\User\ApplicationController::class, 'create'])->name('apply');
        Route::post('/properties/{code}/apply', [App\Http\Controllers\User\ApplicationController::class, 'store'])->name('apply.store');
        // Alternative apply route (if using property model instead of code)
        Route::post('/properties/{property}/apply', [App\Http\Controllers\User\PropertyApplicationController::class, 'store'])->name('properties.apply');
        // ------------------------------------------
        // Saved Properties (Favorites)
        // ------------------------------------------
        Route::prefix('saved-properties')->name('saved-properties.')->group(function () {
            // List saved properties
            Route::get('/', [App\Http\Controllers\User\SavedPropertyController::class, 'index'])->name('index');
            // Remove from saved
            Route::delete('/{property}', [App\Http\Controllers\User\SavedPropertyController::class, 'destroy'])->name('destroy');
        });
        // Toggle favorite (add/remove)
        Route::post('/properties/{property}/favorite', [App\Http\Controllers\User\FavoriteController::class, 'toggle'])->name('properties.favorite');
        // List favorites (alternative to saved-properties)
        Route::get('/favorites', [App\Http\Controllers\User\FavoriteController::class, 'index'])->name('favorites');
        // ------------------------------------------
        // Groups (Placeholder for future)
        // ------------------------------------------
        Route::prefix('groups')->name('groups.')->group(function () { 
            Route::get('/', function() {
                return view('user.groups.index');
            })->name('index');
        });
        
    });

    Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
        Route::get('/favorites', [App\Http\Controllers\User\FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/favorites/toggle', [App\Http\Controllers\User\FavoriteController::class, 'toggle'])->name('favorites.toggle');
        Route::delete('/favorites/{favorite}', [App\Http\Controllers\User\FavoriteController::class, 'destroy'])->name('favorites.destroy');
    });

    Route::controller(App\Http\Controllers\User\NotificationController::class)
        ->prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{notification}', 'show')->name('show');
        });

    // Support & Help
    Route::controller(App\Http\Controllers\User\SupportController::class)->prefix('support')->name('support.')->group(function () {
        Route::get('/', 'index')->name('index');                    // List all tickets
        Route::get('/create', 'create')->name('create');            // Show create ticket form
        Route::post('/', 'store')->name('store');                   // Submit new ticket
        Route::get('/{ticket}', 'show')->name('show');              // View single ticket
        Route::post('/{ticket}/reply', 'reply')->name('reply');     // Reply to ticket
        Route::patch('/{ticket}/close', 'close')->name('close');    // Close ticket
    });
   
});

// API Routes for all authenticated users (for topbar notifications)
Route::middleware('auth')->group(function () {
    Route::get('/api/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'getNotifications'])
        ->name('api.notifications.get');
    Route::post('/api/notifications/{notification}/read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])
        ->name('api.notifications.read');
    Route::post('/api/notifications/read-all', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])
        ->name('api.notifications.read-all');
});
// ============================================
// Stripe Webhook (No CSRF protection)
// ============================================
Route::post('/webhook/stripe', [App\Http\Controllers\Agency\SubscriptionController::class, 'webhook'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])->name('webhook.stripe');

// Property browse and detail pages
// Route::get('/properties', [App\Http\Controllers\PropertyBrowseController::class, 'index'])->name('properties.index');
Route::get('/properties/{publicUrlCode}', [App\Http\Controllers\PropertyBrowseController::class, 'show'])->name('properties.show');

Route::post('/api/favorites/{property}', [App\Http\Controllers\User\SavedPropertyController::class, 'toggle'])->name('api.favorites.toggle')->middleware('auth');

// Reference submission routes - MUST be public (no auth)
Route::get('/reference/{token}', [App\Http\Controllers\ReferenceController::class, 'show'])->name('reference.form');
Route::post('/reference/{token}', [App\Http\Controllers\ReferenceController::class, 'submit'])->name('reference.submit');

// Address Reference Routes
Route::get('/address-reference/{token}', [App\Http\Controllers\AddressReferenceController::class, 'show'])->name('address-reference.form');
Route::post('/address-reference/{token}/draft', [App\Http\Controllers\AddressReferenceController::class, 'saveDraft'])->name('address-reference.draft');
Route::post('/address-reference/{token}/submit', [App\Http\Controllers\AddressReferenceController::class, 'submit'])->name('address-reference.submit');
Route::get('/address-reference/{token}/thank-you', [App\Http\Controllers\AddressReferenceController::class, 'thankYou'])->name('address-reference.thank-you');

require __DIR__.'/auth.php';