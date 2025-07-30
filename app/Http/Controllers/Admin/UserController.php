<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $result = User::orderByDesc('updated_at')
            ->when($request->fname, function($query) use ($request){
                $query->where('fname','LIKE', "%{$request->fname}%");
            })
            ->when($request->lname, function($query) use ($request){
                $query->where('lname','LIKE', "%{$request->lname}%");
            })
            ->when($request->email, function($query) use ($request){
                $query->where('email','LIKE', "%{$request->email}%");
            })
            ->when($request->phone, function($query) use ($request){
                $query->where('phone','LIKE', "%{$request->phone}%");
            })
            ->when($request->status, function($query) use ($request){
                $query->where('status', $request->status);
            })
            ->paginate(100);
        return view('admin.users.index', compact('result'));
    }

    public function pending()
    {
        // with('user','orderProducts')->
        $result = User::where('status', 'pending')->orderByDesc('updated_at')->paginate(100);
        return view('admin.users.index', compact('result'));
    }

    public function approved()
    {
        $result = User::where('status', 'approved')->orderByDesc('updated_at')->paginate(100);
        return view('admin.users.index', compact('result'));
    }

    public function denied()
    {
        $result = User::where('status', 'denied')->orderByDesc('updated_at')->paginate(100);
        return view('admin.users.index', compact('result'));
    }

    public function create()
    {        
        return view('admin.users.create');
    }

    public function show(User $user)
    {
        $result = $user;
        return view('admin.users.show', compact('result'));
    }

    public function edit(User $user)
    {
        $result = $user;
        return view('admin.users.edit', compact('result'));
    }

    public function store(Request $request)
    {
        return $this->handleUserRequest($request, new User(), true);
    }

    public function update(Request $request, User $user)
    {
        return $this->handleUserRequest($request, $user, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleUserRequest(Request $request, User $user, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'fname' => 'required|string|max:50',
                'lname' => 'required|string|max:50',
                'email' => 'required|email|unique:users,email,'.$dataID,
                // 'sort_order' => $isNew ? 'nullable|numeric' : 'required|numeric',
                'phone' => 'nullable|string|max:20',
                'password' => $isNew ? 'required|bail|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/' : 'nullable|bail|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                'confirm_password' => 'nullable|bail|required_with:password|same:password',
                'is_locked' => $isNew ? 'nullable' : 'required',
                'status' => $isNew ? 'nullable' : 'required',
            ];

            $messages = [];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            // Not to set Password NULL if empty
            if (array_key_exists('password', $validated) && is_null($validated['password'])) {
                unset($validated['password']);
            }

            if ($isNew) {
                $validated['created_by'] = session('username');
            }
            $validated['updated_by'] = session('username');

            if ($request->password) {
                $validated['password'] = Hash::make($request->password);
                $validated['last_password_changed'] = now();
            }

            // Directly handle the save/update logic here
            if ($isNew) {
                $user = User::create($validated);
            } else {
                $user->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'User created successfully!' : 'User updated successfully!',
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
    
    public function address_update(Request $request)
    {

        try {

            $rules = [
                'dataID'=>'required|exists:users,id',
                'billing_fname'=>'required|string|max:50',
                'billing_lname'=>'required|string|max:50',
                'billing_email'=>'required|email',
                'billing_phone'=>'nullable|string|max:20|regex:/^\+?[0-9\s\-()]+$/',
                'billing_company'=>'nullable|string|max:255',
                'billing_address'=>'nullable|string|max:255',
                'billing_city'=>'nullable|string|max:100',
                'billing_state'=>'nullable|string|max:50',
                'billing_country'=>'nullable|string|max:60',
                'billing_postcode'=>'nullable|string|max:20',
                'same_address'=>'nullable',
                'shipping_fname'=>'required|string|max:50',
                'shipping_lname'=>'required|string|max:50',
                'shipping_email'=>'required|email',
                'shipping_phone'=>'nullable|string|max:20|regex:/^\+?[0-9\s\-()]+$/',
                'shipping_company'=>'nullable|string|max:255',
                'shipping_address'=>'nullable|string|max:255',
                'shipping_city'=>'nullable|string|max:100',
                'shipping_state'=>'nullable|string|max:50',
                'shipping_country'=>'nullable|string|max:60',
                'shipping_postcode'=>'nullable|string|max:20',
            ];

            $validator = Validator::make($request->all(), $rules);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            $validated['updated_by'] = session('username');

            if($request->same_address){
                $validated['same_address'] = 1;
            }else{
                $validated['same_address'] = 0;
            }
            // dd($validated['same_address']);

            User::find($validated['dataID'])->update($validated);

            // $user = User::find(session('userId'));

            // $user->save();

            session()->flash('success','Data Updation Successful');
            return response()->json([
                'success' => true,
                'message' => 'Data Updation Successful'
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

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted!');
    }

    // public function sortCategories(Request $request, User $user)
    // {
    //     $syncData = [];

    //     foreach ($request->sorted as $item) {
    //         $syncData[$item['id']] = ['sort_order' => $item['sort_order']];
    //     }

    //     $users->products()->sync($syncData); // replaces all existing pivot rows

    //     return response()->json(['message' => 'Sort order updated']);
    // }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $user = User::find($id);
            if ($user) {
                // Storage::disk('public')->delete('uploads/users/'.$users->img_file);
                // Storage::disk('public')->delete('uploads/users/catalogue_files/'.$users->catalogue_file);

                // if($user->banners){
                //     foreach($user->banners as $banner){
                //         Storage::disk('public')->delete('uploads/users/banners/'.$banner->img_file);
                //         $banner->delete();
                //     }
                // }

                $user->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
