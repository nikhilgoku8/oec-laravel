<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\SalesRepresentative;
use App\Models\Admin\UsState;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class SalesRepresentativeController extends Controller
{
    public function index()
    {
        $result = SalesRepresentative::paginate(100);
        return view('admin.sales-representatives.index', compact('result'));
    }

    public function create()
    {
        $usStates = UsState::all();
        return view('admin.sales-representatives.create', compact('usStates'));
    }

    public function show(SalesRepresentative $salesRepresentative)
    {
        $result = $salesRepresentative;
        $usStates = UsState::all();
        return view('admin.sales-representatives.show', compact('result', 'usStates'));
    }

    public function edit(SalesRepresentative $salesRepresentative)
    {
        $result = $salesRepresentative;
        $usStates = UsState::all();
        return view('admin.sales-representatives.edit', compact('result', 'usStates'));
    }

    public function store(Request $request)
    {
        return $this->handleSalesRepresentativeRequest($request, new SalesRepresentative(), true);
    }

    public function update(Request $request, SalesRepresentative $salesRepresentative)
    {
        return $this->handleSalesRepresentativeRequest($request, $salesRepresentative, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleSalesRepresentativeRequest(Request $request, SalesRepresentative $salesRepresentative, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'rep_name' => 'required|max:150|unique:sales_representatives,rep_name,'.$dataID,
                'address' => 'nullable|string|max:255',
                'website' => 'nullable|max:255',
                'email' => 'required|email|max:150|unique:sales_representatives,email,'.$dataID,
                'phone' => 'required|string|max:25',
                'state_id' => $isNew ? 'nullable' : 'required|array|min:1',
                'state_id.*' => $isNew ? 'bail|nullable|exists:us_states,id' : 'bail|required|exists:us_states,id',
            ];

            $messages = [];

            $attributes = [
                'rep_name' => 'Representative Name',
            ];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            // Directly handle the save/update logic here
            if ($isNew) {
                $salesRepresentative = SalesRepresentative::create($validated);
            } else {
                $salesRepresentative->update($validated);
            }

            // Update pivot table
            $salesRepresentative->usStates()->sync($validated['state_id']);

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'Sales Representative created successfully!' : 'Sales Representative updated successfully!',
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

    public function destroy(SalesRepresentative $salesRepresentative)
    {
        $salesRepresentative->delete();
        return redirect()->route('admin.sales-representatives.index')->with('success', 'SalesRepresentative deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $salesRepresentative = SalesRepresentative::find($id);
            if ($salesRepresentative) {
                $salesRepresentative->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
