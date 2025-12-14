<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display user's favorite properties
     */
    public function index()
    {
        $user = Auth::user();
        
        $favorites = Favorite::with(['property', 'property.images', 'property.agency'])
            ->forUser($user->id)
            ->recent()
            ->paginate(12);
        
        return view('user.favorites.index', compact('favorites'));
    }

    /**
     * Toggle favorite (add or remove)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
        ]);
        
        $user = Auth::user();
        $propertyId = $request->property_id;
        
        $added = Favorite::toggle($user->id, $propertyId);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'favorited' => $added,
                'message' => $added ? 'Property added to favorites' : 'Property removed from favorites',
                'count' => Favorite::countForUser($user->id),
            ]);
        }
        
        return redirect()->back()->with(
            'success',
            $added ? 'Property added to favorites!' : 'Property removed from favorites.'
        );
    }

    /**
     * Remove from favorites
     */
    public function destroy(Favorite $favorite)
    {
        $user = Auth::user();
        
        // Ensure user owns this favorite
        if ($favorite->user_id !== $user->id) {
            abort(403);
        }
        
        $favorite->delete();
        
        return redirect()->route('user.favorites.index')
            ->with('success', 'Property removed from favorites.');
    }
}