<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ReachUs;
use Illuminate\Support\Facades\Validator;

class ReachUsController extends Controller
{
    public function index()
    {
        $this->data['result'] = ReachUs::orderByDesc('created_at')->paginate(50);
        return view('admin.reach-us.index', $this->data);
    }

    public function show(ReachUs $reachUs)
    {
        $result = $reachUs;
        return view('admin.reach-us.show', compact('result'));
    }

    public function edit(ReachUs $reachUs)
    {
        $result = $reachUs;
        return view('admin.reach-us.edit', compact('result'));
    }

    public function store(Request $request)
    {
        return $this->handleReachUsRequest($request, new ReachUs(), true);
    }

    public function update(Request $request, ReachUs $reachUs)
    {
        return $this->handleReachUsRequest($request, $reachUs, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleReachUsRequest(Request $request, ReachUs $reachUs, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'title' => 'required|string|max:255|unique:reach_us_enquiries,title,'.$dataID,
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
                $reachUs = ReachUs::create($validated);
            } else {
                $reachUs->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'ReachUs created successfully!' : 'ReachUs updated successfully!',
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

    public function destroy(ReachUs $reachUs)
    {
        $reachUs->delete();
        return redirect()->route('admin.reach-us.index')->with('success', 'ReachUs deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $reachUs = ReachUs::find($id);
            if ($reachUs) {
                $reachUs->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
