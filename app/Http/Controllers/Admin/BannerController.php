<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Http;
use App\Models\Admin\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $data['result'] = Banner::orderBy('sort_order')->paginate(100);
        return view('admin.banners.index', $data);
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function show(Banner $banner)
    {
        $result = $banner;
        return view('admin.banners.show', compact('result'));
    }

    public function edit(Banner $banner)
    {
        $result = $banner;
        return view('admin.banners.edit', compact('result'));
    }

    public function store(Request $request)
    {
        return $this->handleBannerRequest($request, new Banner(), true);
    }

    public function update(Request $request, Banner $banner)
    {
        return $this->handleBannerRequest($request, $banner, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleBannerRequest(Request $request, Banner $banner, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'title' => 'nullable|string|max:255',
                'image_file' => 'nullable|required_without:existing_image_file|file|mimes:jpg,jpeg,webp,png|max:2048',
                'link' => 'required',
                'sort_order' => 'required|numeric|min:1|unique:banners,sort_order,'.$dataID,
            ];

            $messages = [];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            if ($request->has('existing_image_file')) {
                $validated['image_file'] = $request->input('existing_image_file');
            }

            if($request->hasFile('image_file')){

                $file = $request->file('image_file');
                $fileName = 'banner_'.time().'.'.$file->getClientOriginalExtension();
                // $folderPath = public_path('uploads/banners');
                $uploadRoot = base_path(env('UPLOAD_ROOT'));
                $folderPath = $uploadRoot . '/banners';

                // Make sure the folder exists
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }

                $file->move($folderPath, $fileName);

                // Delete old file if exists
                if ($request->filled('existing_image_file')) {
                    $oldFile = $folderPath . '/' . $request->existing_image_file;
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }

                $validated['image_file'] = $fileName;
            }

            // Directly handle the save/update logic here
            if ($isNew) {
                $banner = Banner::create($validated);
            } else {
                $banner->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'Banner created successfully!' : 'Banner updated successfully!',
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

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $banner = Banner::find($id);
            if ($banner) {
                $banner->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
