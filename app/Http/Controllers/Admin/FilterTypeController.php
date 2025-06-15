<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\FilterType;

class FilterTypeController extends Controller
{
    public function index()
    {
        $result = FilterType::with('filterValues')->orderBy('title')->paginate(100);
        return view('admin.filter-types.index', compact('result'));
    }

    public function create()
    {
        return view('admin.filter-types.create');
    }

    public function show(FilterType $filterType)
    {
        $result = $filterType;
        return view('admin.filter-types.show', compact('result'));
    }

    public function edit(FilterType $filterType)
    {
        $result = $filterType;
        return view('admin.filter-types.edit', compact('result'));
    }

    public function store(Request $request)
    {
        return $this->handleFilterTypeRequest($request, new FilterType(), true);
    }

    public function update(Request $request, FilterType $filterType)
    {
        return $this->handleFilterTypeRequest($request, $filterType, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleFilterTypeRequest(Request $request, FilterType $filterType, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'title' => 'required|string|max:255|unique:filter_type,title,'.$dataID,
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
                $filterType = FilterType::create($validated);
            } else {
                $filterType->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'FilterType created successfully!' : 'FilterType updated successfully!',
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

    public function destroy(FilterType $filterType)
    {
        $filterType->delete();
        return redirect()->route('admin.filter-types.index')->with('success', 'FilterType deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $filterType = FilterType::find($id);
            if ($filterType) {
                $filterType->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
