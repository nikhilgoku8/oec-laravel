<?php

namespace App\Exports;

use App\Models\Admin\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $start_date;
    protected $end_date;
    protected $status;
    protected $order_ref_id;
    protected $user_id;

    public function __construct($request)
    {
        $this->start_date = $request->start_date;
        $this->end_date = $request->end_date;
        $this->status = $request->status;
        $this->order_ref_id = $request->order_ref_id;
        $this->user_id = $request->user_id;
    }

    public function collection()
    {
        // Get orders with relationships
        $orders = Order::with('user','orderProducts','orderProducts.product')
            ->when($this->start_date, fn($query) => $query->where('created_at', '>=', $this->start_date . ' 00:00:00'))
            ->when($this->end_date, fn($query) => $query->where('created_at', '<=', $this->end_date . ' 23:59:59'))
            ->when($this->status, fn($query) => $query->where('status', $this->status))
            ->when($this->order_ref_id, fn($query) => $query->where('order_ref_id', $this->order_ref_id))
            ->when($this->user_id, fn($query) => $query->where('user_id', $this->user_id))
            ->get();

        // Determine max number of products for any order
        $maxProducts = $orders->map(fn($order) => $order->orderProducts->count())->max();

        // Define static headings
        $headings = [
            'Sr. No.', 'Order Ref ID', 'Status', 'Billing First name', 'Billing Last name', 'billing_email', 'billing_phone', 'billing_company', 'billing_address', 'billing_city', 'billing_state', 'billing_country', 'billing_postcode', 'enquiry_notes', 'admin_remark', 'created_by', 'updated_by', 'created_at', 'updated_at'
        ];

        // Add dynamic product columns
        for ($i = 1; $i <= $maxProducts; $i++) {
            $headings[] = "Product Name $i";
            $headings[] = "Quantity $i";
        }

        // Create the dataset with orders
        $data = collect([$headings]); // First row as headings

        $orders->each(function ($order, $loopIndex) use ($maxProducts, &$data) {
            $row = [
                $loopIndex + 1,
                $order->order_ref_id,
                $order->status,
                $order->billing_fname,
                $order->billing_lname,
                $order->billing_email,
                $order->billing_phone,
                $order->billing_company,
                $order->billing_address,
                $order->billing_city,
                $order->billing_state,
                $order->billing_country,
                $order->billing_postcode,
                $order->enquiry_notes,
                $order->admin_remark,
                $order->created_by,
                $order->updated_by,
                $order->created_at,
                $order->updated_at,
            ];

            $products = collect();

            $quantities = [];

            foreach ($order->orderProducts as $p) {
                $products[$p->product_id] = $p->product; // Store the Product model
                $quantities[$p->product_id] = $p->quantity; // Store purchase quantity
            }

            // Fill in product details dynamically
            $productIds = $products->keys(); // Get unique product IDs
            for ($i = 0; $i < $maxProducts; $i++) {
                $row[] = $products[$productIds[$i] ?? null]?->title ?? ''; // Product Name
                $row[] = $quantities[$productIds[$i] ?? null] ?? ''; // Purchase Qty
            }

            $data->push($row);
        });

        return $data;
    }
}
