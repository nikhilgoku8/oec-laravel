<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Order;
use App\Models\Admin\User;
use App\Models\Admin\OrderProduct;
use Illuminate\Support\Facades\Validator;

use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $result = Order::with('user','orderProducts')
            ->orderByDesc('created_at')
            ->when($request->start_date, function($query) use ($request){
                $query->where('created_at', '>=', $request->start_date . ' 00:00:00');
            })
            ->when($request->end_date, function($query) use ($request){
                $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
            })
            ->when($request->order_ref_id, function($query) use ($request){
                $query->where('order_ref_id','LIKE', "%{$request->order_ref_id}%");
            })
            ->when($request->user_id, function($query) use ($request){
                $query->where('user_id', $request->user_id);
            })
            ->when($request->status, function($query) use ($request){
                $query->where('status', $request->status);
            })
            ->paginate(100);
        return view('admin.orders.index', compact('result','users'));
    }

    public function pending()
    {
        $result = Order::with('user','orderProducts')->where('status', 'pending')->orderByDesc('created_at')->paginate(100);
        return view('admin.orders.index', compact('result'));
    }

    public function completed()
    {
        $result = Order::with('user','orderProducts')->where('status', 'completed')->orderByDesc('created_at')->paginate(100);
        return view('admin.orders.index', compact('result'));
    }

    public function denied()
    {
        $result = Order::with('user','orderProducts')->where('status', 'denied')->orderByDesc('created_at')->paginate(100);
        return view('admin.orders.index', compact('result'));
    }

    public function create()
    {        
        return view('admin.orders.create');
    }

    public function show(Order $order)
    {
        $order->loadMissing('orderProducts','orderProducts.product');
        $result = $order;
        return view('admin.orders.show', compact('result'));
    }

    public function edit(Order $order)
    {
        $order->loadMissing('orderProducts','orderProducts.product');
        $result = $order;
        return view('admin.orders.edit', compact('result'));
    }

    public function store(Request $request)
    {
        return $this->handleOrderRequest($request, new Order(), true);
    }

    public function update(Request $request, Order $order)
    {
        return $this->handleOrderRequest($request, $order, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleOrderRequest(Request $request, Order $order, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'status' => 'required',
                'admin_remark' => 'nullable|string',
            ];

            $messages = [];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            if ($isNew) {
                $validated['created_by'] = session('username');
            }
            $validated['updated_by'] = session('username');

            // Directly handle the save/update logic here
            if ($isNew) {
                $order = Order::create($validated);
            } else {
                $order->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'Order created successfully!' : 'Order updated successfully!',
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

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $order = Order::find($id);
            if ($order) {
                $order->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }

    public function export(Request $request) 
    {
        return Excel::download(new OrdersExport($request), 'orders.xlsx');
    }
}
