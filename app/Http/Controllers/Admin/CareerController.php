<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Career;
use Illuminate\Support\Facades\Validator;

class CareerController extends Controller
{
    public function index()
    {
        $this->data['result'] = Career::orderByDesc('created_at')->paginate(50);
        return view('admin.careers.index', $this->data);
    }

    public function show(Career $career)
    {
        $result = $career;
        return view('admin.careers.show', compact('result'));
    }

    public function edit(Career $career)
    {
        $result = $career;
        return view('admin.careers.edit', compact('result'));
    }

    public function store(Request $request)
    {
        return $this->handleCareerRequest($request, new Career(), true);
    }

    public function update(Request $request, Career $career)
    {
        return $this->handleCareerRequest($request, $career, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleCareerRequest(Request $request, Career $career, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'title' => 'required|string|max:255|unique:careers,title,'.$dataID,
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
                $career = Career::create($validated);
            } else {
                $career->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'Career created successfully!' : 'Career updated successfully!',
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

    public function destroy(Career $career)
    {
        $career->delete();
        return redirect()->route('admin.careers.index')->with('success', 'Career deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $career = Career::find($id);
            if ($career) {
                $career->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
