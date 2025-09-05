<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Competitor;
use App\Models\Admin\Product;
use Illuminate\Support\Facades\Validator;

class CompetitorController extends Controller
{
    public function index()
    {
        $result = Competitor::orderByDesc('created_at')->paginate(100);
        return view('admin.competitors.index', compact('result'));
    }

    public function create()
    {
        $products = Product::orderBy('title')->get();
        return view('admin.competitors.create', compact('products'));
    }

    public function show(Competitor $competitor)
    {
        $result = $competitor;
        $products = Product::orderBy('title')->get();
        return view('admin.competitors.show', compact('result','products'));
    }

    public function edit(Competitor $competitor)
    {
        $result = $competitor;
        $products = Product::orderBy('title')->get();
        return view('admin.competitors.edit', compact('result','products'));
    }

    public function store(Request $request)
    {
        return $this->handleCompetitorRequest($request, new Competitor(), true);
    }

    public function update(Request $request, Competitor $competitor)
    {
        return $this->handleCompetitorRequest($request, $competitor, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleCompetitorRequest(Request $request, Competitor $competitor, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'title' => 'required|string|max:255|unique:competitors,title,'.$dataID,
                'product_id' => 'required|exists:products,id',
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
                $competitor = Competitor::create($validated);
            } else {
                $competitor->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'Competitor created successfully!' : 'Competitor updated successfully!',
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

    public function destroy(Competitor $competitor)
    {
        $competitor->delete();
        return redirect()->route('admin.competitors.index')->with('success', 'Competitor deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $competitor = Competitor::find($id);
            if ($competitor) {
                $competitor->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
