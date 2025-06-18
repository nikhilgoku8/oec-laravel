<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\FilterType;
use App\Models\Admin\FilterValue;
use Illuminate\Validation\Rule;

class FilterValueController extends Controller
{
    public function index()
    {
        $result = FilterValue::with('filterType')->paginate(100);
        return view('admin.filter-values.index', compact('result'));
    }

    public function create()
    {
        $filterTypes = FilterType::all();
        return view('admin.filter-values.create', compact('filterTypes'));
    }

    public function show(FilterValue $filterValue)
    {
        $result = $filterValue;
        $filterTypes = FilterType::all();
        return view('admin.filter-values.show', compact('result', 'filterTypes'));
    }

    public function edit(FilterValue $filterValue)
    {
        $result = $filterValue;
        $filterTypes = FilterType::all();
        return view('admin.filter-values.edit', compact('result', 'filterTypes'));
    }

    public function store(Request $request)
    {
        return $this->handleFilterValueRequest($request, new FilterValue(), true);
    }

    public function update(Request $request, FilterValue $filterValue)
    {
        return $this->handleFilterValueRequest($request, $filterValue, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleFilterValueRequest(Request $request, FilterValue $filterValue, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'filter_type_id' => 'required|exists:filter_types,id',
                'value' => [
                    'required',
                    Rule::unique('filter_values')
                        ->ignore($dataID)
                        ->where(function ($query) use ($request) {
                            return $query->where('filter_type_id', $request->filter_type_id);
                        }),
                ],
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
                $filterValue = FilterValue::create($validated);
            } else {
                $filterValue->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'FilterValue created successfully!' : 'FilterValue updated successfully!',
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

    public function destroy(FilterValue $filterValue)
    {
        $filterValue->delete();
        return redirect()->route('admin.filter-values.index')->with('success', 'FilterValue deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $filterValue = FilterValue::find($id);
            if ($filterValue) {
                $filterValue->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }

    public function get_filter_values_by_type($id){
        return FilterValue::where('filter_type_id',$id)->get();
    }
}
