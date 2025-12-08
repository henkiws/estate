<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnquiryController extends Controller
{
    /**
     * Display user's enquiries
     */
    public function index()
    {
        $user = Auth::user();
        
        $enquiries = $user->propertyEnquiries()
            ->with(['property.agency', 'property.featuredImage'])
            ->latest()
            ->paginate(15);
        
        return view('user.enquiries', compact('enquiries'));
    }
}