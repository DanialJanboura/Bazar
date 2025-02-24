<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ExtraField;
use App\Models\LaptopListing;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ListingController extends Controller
{

    public function index()
    {
        $listings = Listing::with(['user', 'category'])->get();

        // Retrieve all categories to populate the select options in the create modal
        $categories = Category::WhereNotNull('parent_id')->get();


        return Inertia::render('Listing/Index', [
            'listings'   => $listings,
            'categories' => $categories,
        ]);
    }


    public function create()
    {
        $categories = Category::all();

        // Fetch all extra fields
        $extraFields = ExtraField::all();

        return Inertia::render('Listing/Create', ['categories' => $categories, 'extraFields' => $extraFields]);
    }


    // Store the new listing along with its category-specific details
    public function store(Request $request)
    {

        $user = Auth::user();

        $validated = $request->validate([

            'category_id'  => 'required|exists:categories,id',
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric',
            'condition'    => 'nullable|string',
            'location'     => 'nullable|string',
            'status'       => 'nullable|string',
            'extra_fields' => 'nullable|array',
        ]);
        //        $validated['user_id'] = $user->id;
        //
        //        Listing::create($validated);
        $validated['condition'] = $validated['condition'] ?? 'used';
        $validated['status'] = $validated['status'] ?? 'active';
        $user->listings()->create($validated);

        return redirect()->route('listings.index')
                         ->with('success', 'Listing created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();

        return redirect()->route('listings.index')
                         ->with('success', 'Listing has been deleted successfully.');
    }
}
