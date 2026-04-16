<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['shops', 'freelancerProfiles'])->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        return view('admin.categories.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'icon' => 'required|string|max:255',
        ]);
        
        $category = Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'icon' => $request->icon,
            'sort_order' => Category::max('sort_order') + 1,
            'is_active' => true,
        ]);
        
        ActivityLogger::log('category_created', $category);
        
        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }
    
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'icon' => 'required|string|max:255',
        ]);
        
        $category->update($request->only(['name', 'slug', 'icon']));
        
        ActivityLogger::log('category_updated', $category);
        
        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }
    
    public function destroy(Category $category)
    {
        // Check if category is in use
        if ($category->shops()->count() > 0 || $category->freelancerProfiles()->count() > 0) {
            return back()->with('error', 'Cannot delete category that is in use.');
        }
        
        $category->delete();
        
        ActivityLogger::log('category_deleted', $category);
        
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
    
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:categories,id',
        ]);
        
        foreach ($request->order as $index => $categoryId) {
            Category::where('id', $categoryId)->update(['sort_order' => $index + 1]);
        }
        
        ActivityLogger::log('categories_reordered');
        
        return response()->json(['success' => true]);
    }
}
