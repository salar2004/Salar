<?php

namespace App\Http\Controllers;
use App\Models\Customer;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->password = bcrypt($request->password);
        $customer->shipping_address = $request->shipping_address;
        $customer->phone_number = $request->phone_number;
        $customer->registration_date = now();
        $customer->save();

        return redirect()->route('customers.create')->with('success', 'تم إضافة الزبون بنجاح');
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->shipping_address = $request->shipping_address;
        $customer->phone_number = $request->phone_number;

        if ($request->has('password') && !empty($request->password)) {
            $customer->password = bcrypt($request->password);
        }

        $customer->save();

        return redirect()->route('customers.index')->with('success', 'تم تعديل بيانات العميل بنجاح');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'تم حذف العميل بنجاح');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $customers = Customer::where('name', 'LIKE', "%{$query}%")
                             ->orWhere('email', 'LIKE', "%{$query}%")
                             ->get();
        
        return view('customers.index', compact('customers'));
    }
    
}
