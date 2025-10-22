<?php

namespace App\Exports;

use App\Models\Admin\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $fname;
    protected $lname;
    protected $email;
    protected $phone;
    protected $status;

    public function __construct($request)
    {
        $this->fname = $request->fname;
        $this->lname = $request->lname;
        $this->email = $request->email;
        $this->phone = $request->phone;
        $this->status = $request->status;
    }

    public function collection()
    {
        // Get orders with relationships
        $users = User::with('orders')
            ->when($this->fname, fn($query) => $query->where('fname', 'LIKE', '%'.$this->fname.'%'))
            ->when($this->lname, fn($query) => $query->where('lname', 'LIKE', '%'.$this->lname.'%'))
            ->when($this->email, fn($query) => $query->where('email', 'LIKE', '%'.$this->email.'%'))
            ->when($this->phone, fn($query) => $query->where('phone', 'LIKE', '%'.$this->phone.'%'))
            ->when($this->status, fn($query) => $query->where('status', $this->status))
            ->get();

        // Determine max number of products for any order
        $maxOrders = $users->map(fn($user) => $user->orders->count())->max();

        // Define static headings
        $headings = [
            'Sr. No.', 'First Name', 'Last Name', 'Email', 'Phone', 'Role', 'Last Password Changed', 'Last Login', 'Login Attempts', 'Is Locked', 'Registered At', 'Billing First Name', 'Billing Last Name', 'Billing Phone', 'Billing Email', 'Billing Company', 'Billing Address', 'Billing City', 'Billing State', 'Billing Country', 'Billing Postcode', 'Shipping First Name', 'Shipping Last Name', 'Shipping Phone', 'Shipping Email', 'Shipping Company', 'Shipping Address', 'Shipping City', 'Shipping State', 'Shipping Country', 'Shipping Postcode', 'Status', 'Created By', 'Updated By', 'Created At', 'Updated At'
        ];

        // Add dynamic product columns
        for ($i = 1; $i <= $maxOrders; $i++) {
            $headings[] = "Order Ref Id $i";
        }

        // Create the dataset with orders
        $data = collect([$headings]); // First row as headings

        $users->each(function ($user, $loopIndex) use ($maxOrders, &$data) {
            $row = [
                $loopIndex + 1,
                $user->fname,
                $user->lname,
                $user->email,
                $user->phone,
                $user->role,
                $user->last_password_changed,
                $user->last_login,
                $user->login_attempts,
                $user->is_locked ? 'Yes' : 'No',
                $user->registered_at,
                $user->billing_fname,
                $user->billing_lname,
                $user->billing_phone,
                $user->billing_email,
                $user->billing_company,
                $user->billing_address,
                $user->billing_city,
                $user->billing_state,
                $user->billing_country,
                $user->billing_postcode,
                $user->shipping_fname,
                $user->shipping_lname,
                $user->shipping_phone,
                $user->shipping_email,
                $user->shipping_company,
                $user->shipping_address,
                $user->shipping_city,
                $user->shipping_state,
                $user->shipping_country,
                $user->shipping_postcode,
                $user->status,
                $user->created_by,
                $user->updated_by,
                $user->created_at,
                $user->updated_at,
            ];

            foreach ($user->orders as $order) {
                $row[] = $order->order_ref_id; // Store the Order ref if
            }

            $data->push($row);
        });

        return $data;
    }
}
