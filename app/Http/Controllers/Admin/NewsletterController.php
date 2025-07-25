<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\NewsletterSubscription;

class NewsletterController extends Controller
{
    public function index()
    {
        $this->data['result'] = NewsletterSubscription::orderByDesc('created_at')->paginate(50);
        return view('admin.newsletters.index', $this->data);
    }

    public function show(NewsletterSubscription $newsletterSubscription)
    {
        $result = $newsletterSubscription;
        return view('admin.newsletters.show', compact('result'));
    }

    public function edit(NewsletterSubscription $newsletterSubscription)
    {
        $result = $newsletterSubscription;
        return view('admin.newsletters.edit', compact('result'));
    }

    public function store(Request $request)
    {
        return $this->handleNewsletterSubscriptionRequest($request, new NewsletterSubscription(), true);
    }

    public function update(Request $request, NewsletterSubscription $newsletterSubscription)
    {
        return $this->handleNewsletterSubscriptionRequest($request, $newsletterSubscription, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleNewsletterSubscriptionRequest(Request $request, NewsletterSubscription $newsletterSubscription, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'title' => 'required|string|max:255|unique:newsletters,title,'.$dataID,
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
                $newsletterSubscription = NewsletterSubscription::create($validated);
            } else {
                $newsletterSubscription->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'NewsletterSubscription created successfully!' : 'NewsletterSubscription updated successfully!',
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

    public function destroy(NewsletterSubscription $newsletterSubscription)
    {
        $newsletterSubscription->delete();
        return redirect()->route('admin.newsletters.index')->with('success', 'NewsletterSubscription deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $newsletterSubscription = NewsletterSubscription::find($id);
            if ($newsletterSubscription) {
                $newsletterSubscription->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
