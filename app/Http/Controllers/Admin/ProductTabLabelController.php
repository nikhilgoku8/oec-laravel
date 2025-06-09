<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ProductTabLabel;

class ProductTabLabelController extends Controller
{
    public function index()
    {
        $result = ProductTabLabel::paginate(100);
        return view('admin.product-tab-labels.index', compact('result'));
    }

    public function create()
    {        
        return view('admin.product-tab-labels.create');
    }

    public function show(ProductTabLabel $productTabLabel)
    {
        $result = $productTabLabel;
        return view('admin.product-tab-labels.show', compact('result'));
    }

    public function edit(ProductTabLabel $productTabLabel)
    {
        $result = $productTabLabel;
        return view('admin.product-tab-labels.edit', compact('result'));
    }

    public function store(Request $request)
    {
        return $this->handleProductTabLabelRequest($request, new ProductTabLabel(), true);
    }

    public function update(Request $request, ProductTabLabel $productTabLabel)
    {
        return $this->handleProductTabLabelRequest($request, $productTabLabel, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleProductTabLabelRequest(Request $request, ProductTabLabel $productTabLabel, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'title' => 'required|string|max:255|unique:product_tab_labels,title,'.$dataID,
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
                $productTabLabel = ProductTabLabel::create($validated);
            } else {
                $productTabLabel->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'ProductTabLabel created successfully!' : 'ProductTabLabel updated successfully!',
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

    public function destroy(ProductTabLabel $productTabLabel)
    {
        $productTabLabel->delete();
        return redirect()->route('admin.product-tab-labels.index')->with('success', 'ProductTabLabel deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $productTabLabel = ProductTabLabel::find($id);
            if ($productTabLabel) {
                $productTabLabel->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
