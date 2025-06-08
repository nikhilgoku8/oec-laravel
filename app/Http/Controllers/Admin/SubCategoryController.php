<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Category;
use App\Model\Admin\SubCategory;

class SubCategoryController extends Controller
{
    public function index()
    {
        $result = SubCategory::with('category')->paginate(100);
        return view('admin.sub-categories.index', compact('result'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.sub-categories.create', compact('categories'));
    }

    public function show(SubCategory $subCategory)
    {
        $result = $subCategory;
        $categories = Category::all();
        return view('admin.sub-categories.show', compact('result', 'categories'));
    }

    public function edit(SubCategory $subCategory)
    {
        $result = $subCategory;
        $categories = Category::all();
        return view('admin.sub-categories.edit', compact('result', 'categories'));
    }

    public function store(Request $request)
    {
        return $this->handleSubCategoryRequest($request, new SubCategory(), true);
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        return $this->handleSubCategoryRequest($request, $subCategory, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleSubCategoryRequest(Request $request, SubCategory $subCategory, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|string|max:255|unique:sub_categories,title,'.$dataID,
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
                $subCategory = SubCategory::create($validated);
            } else {
                $subCategory->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'SubCategory created successfully!' : 'SubCategory updated successfully!',
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

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        return redirect()->route('admin.sub-categories.index')->with('success', 'SubCategory deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $subCategory = SubCategory::find($id);
            if ($subCategory) {

                $subCategory->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
