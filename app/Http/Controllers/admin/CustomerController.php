<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('user')->get();

        return view('admin.customers.index', compact('customers'));
    }




    public function edit($id)
    {
        $customer = Customer::with('user')->findOrFail($id);

        return view('admin.customers.edit', compact('customer'));
    }

    //edit dan update data users
    public function update(Request $request, $id)
    {
        try {


        $customer = Customer::findOrFail($id);

        $data = [
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ];


        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customers account successfully edited.')->with('toast', 'customer_edit');
        } catch (\Exception $e) {
            return redirect()->route('customers.index')->with('error', 'Failed to edit customer account.')->with('toast', 'customer_edit_error');
        }
    }






public function destroy($id)
{
    try {
        

    $customer = Customer::findOrFail($id);

    $user = $customer->user;

    $customer->delete();

    if ($user) {
        $user->delete();
    }

    return redirect()->back()->with('success', 'Successfully deleted customer data')->with('toast', 'customer_delete');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete customer account')->with('toast', 'customer_delete_error');
    }
}
}
