<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{

    public function index()
    {
        // Retrieve all categories. You might also want to paginate or sort as needed.
        $categories = Category::with('parent')->get();

        // Return an Inertia response to render the 'Category/Index' component,
        // passing the retrieved categories as props.
        return Inertia::render('Category/Index', [
            'categories' => $categories,
        ]);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'parent_id' => 'nullable',
            'name'      => 'required',
            'slug'      => 'nullable',
        ]);

        // Create the category
        Category::create($validated);

        // Redirect back with a success message
        return redirect()->route('categories.index')
                         ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('parent');

        // Return an Inertia page with the category data
        return Inertia::render('Category/Show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success', 'Category deleted successfully.');
    }
}
