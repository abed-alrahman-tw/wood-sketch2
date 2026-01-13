<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function show(Customer $customer): View
    {
        $customer->load([
            'jobs.project',
            'jobs.booking',
            'jobs.quoteRequest',
        ]);

        return view('admin.customers.show', [
            'customer' => $customer,
        ]);
    }
}
