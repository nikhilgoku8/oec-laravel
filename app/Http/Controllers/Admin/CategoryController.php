<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $result = Category::paginate(100);
        return view('admin.categories.index', compact('result'));
    }

    public function create()
    {        
        return view('admin.categories.create');
    }

    public function show(Category $category)
    {
        $result = $category;
        return view('admin.categories.show', compact('result'));
    }

    public function edit(Category $category)
    {
        $result = $category;
        return view('admin.categories.edit', compact('result'));
    }

    public function store(Request $request)
    {
        return $this->handleCategoryRequest($request, new Category(), true);
    }

    public function update(Request $request, Category $category)
    {
        return $this->handleCategoryRequest($request, $category, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleCategoryRequest(Request $request, Category $category, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'title' => 'required|string|max:255|unique:categories,title,'.$dataID,
                'sort_order' => $isNew ? 'nullable|numeric' : 'required|numeric',
            ];

            $messages = [];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            $validated['slug'] = $this->string_filter($validated['title']);

            if ($isNew) {
                $validated['created_by'] = session('username');
            }
            $validated['updated_by'] = session('username');

            // Directly handle the save/update logic here
            if ($isNew) {
                $category = Category::create($validated);
            } else {
                $category->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'Category created successfully!' : 'Category updated successfully!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'form',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'error',
                'error_type' => 'server',
                'message' => 'Something went wrong. Please try again later.',
                'console_message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted!');
    }

    // public function sortCategories(Request $request, Category $category)
    // {
    //     $syncData = [];

    //     foreach ($request->sorted as $item) {
    //         $syncData[$item['id']] = ['sort_order' => $item['sort_order']];
    //     }

    //     $categories->products()->sync($syncData); // replaces all existing pivot rows

    //     return response()->json(['message' => 'Sort order updated']);
    // }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $category = Category::find($id);
            if ($category) {
                // Storage::disk('public')->delete('uploads/categories/'.$categories->img_file);
                // Storage::disk('public')->delete('uploads/categories/catalogue_files/'.$categories->catalogue_file);

                // if($category->banners){
                //     foreach($category->banners as $banner){
                //         Storage::disk('public')->delete('uploads/categories/banners/'.$banner->img_file);
                //         $banner->delete();
                //     }
                // }

                $category->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
