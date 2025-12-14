<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ApplicationDraft;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationDraftController extends Controller
{
    /**
     * Display user's application drafts
     */
    public function index()
    {
        $drafts = ApplicationDraft::forUser(Auth::id())
            ->active()
            ->with('property')
            ->latest('last_edited_at')
            ->get();

        return view('user.drafts.index', compact('drafts'));
    }

    /**
     * Create a new draft
     */
    public function create(Request $request)
    {
        $propertyCode = $request->get('property_code');
        $property = null;

        if ($propertyCode) {
            $property = Property::where('property_code', $propertyCode)->first();
        }

        return view('user.drafts.create', compact('property'));
    }

    /**
     * Store a new draft
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'nullable|exists:properties,id',
            'property_address' => 'nullable|string',
            'property_code' => 'nullable|string',
            'form_data' => 'nullable|array',
            'current_step' => 'integer|min:1|max:10',
        ]);

        $draft = ApplicationDraft::create([
            'user_id' => Auth::id(),
            'property_id' => $validated['property_id'] ?? null,
            'property_address' => $validated['property_address'] ?? null,
            'property_code' => $validated['property_code'] ?? null,
            'form_data' => $validated['form_data'] ?? [],
            'current_step' => $validated['current_step'] ?? 1,
            'total_steps' => 10,
            'status' => 'draft',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Draft created successfully',
            'draft' => $draft
        ]);
    }

    /**
     * Show a specific draft
     */
    public function show($id)
    {
        $draft = ApplicationDraft::forUser(Auth::id())
            ->with('property')
            ->findOrFail($id);

        return view('user.drafts.show', compact('draft'));
    }

    /**
     * Update a draft
     */
    public function update(Request $request, $id)
    {
        $draft = ApplicationDraft::forUser(Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'form_data' => 'nullable|array',
            'current_step' => 'integer|min:1|max:10',
        ]);

        $draft->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Draft updated successfully',
            'draft' => $draft
        ]);
    }

    /**
     * Delete a draft
     */
    public function destroy($id)
    {
        $draft = ApplicationDraft::forUser(Auth::id())->findOrFail($id);
        $draft->delete();

        return redirect()->route('user.dashboard')
            ->with('success', 'Draft deleted successfully');
    }

    /**
     * Continue editing a draft
     */
    public function continue($id)
    {
        $draft = ApplicationDraft::forUser(Auth::id())
            ->with('property')
            ->findOrFail($id);

        // Redirect to application form with draft data
        return redirect()->route('user.apply', [
            'code' => $draft->property_code ?? $draft->property_id
        ])->with('draft_id', $draft->id);
    }
}