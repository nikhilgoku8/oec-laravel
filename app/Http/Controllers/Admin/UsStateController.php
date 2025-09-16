<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\UsState;
use App\Models\Admin\SalesRepresentative;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UsStateController extends Controller
{
    public function index()
    {
        $result = UsState::with('salesRepresentatives')->paginate(100);
        return view('admin.us-states.index', compact('result'));
    }

    public function create()
    {
        $data['salesRepresentatives'] = SalesRepresentative::all();
        return view('admin.us-states.create', $data);
    }

    public function show(UsState $usState)
    {
        $data['result'] = $usState->loadMissing('salesRepresentatives');
        $data['salesRepresentatives'] = SalesRepresentative::all();
        return view('admin.us-states.show', $data);
    }

    public function edit(UsState $usState)
    {
        $data['result'] = $usState->loadMissing('salesRepresentatives');
        $data['salesRepresentatives'] = SalesRepresentative::all();
        return view('admin.us-states.edit', $data);
    }

    public function store(Request $request)
    {
        return $this->handleUsStateRequest($request, new UsState(), true);
    }

    public function update(Request $request, UsState $usState)
    {
        return $this->handleUsStateRequest($request, $usState, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleUsStateRequest(Request $request, UsState $usState, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'title' => 'required|string|max:255',
                'abbr' => 'bail|required|size:2|unique:us_states,abbr,'.$dataID,
                'rep_id' => $isNew ? 'nullable' : 'required|array|min:1',
                'rep_id.*' => $isNew ? 'bail|nullable|exists:sales_representatives,id' : 'bail|required|exists:sales_representatives,id',
            ];

            $messages = [];

            $attributes = [
                'abbr' => 'Abbrevation',
                'rep_id.*' => 'Sales Representative',
            ];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            // Directly handle the save/update logic here
            if ($isNew) {
                $usState = UsState::create($validated);
            } else {
                $usState->update($validated);
            }

            // Update pivot table
            $usState->salesRepresentatives()->sync($validated['rep_id']);

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'Us State created successfully!' : 'Us State updated successfully!',
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

    public function destroy(UsState $usState)
    {
        $usState->delete();
        return redirect()->route('admin.us-states.index')->with('success', 'UsState deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $usState = UsState::find($id);
            if ($usState) {
                $usState->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
