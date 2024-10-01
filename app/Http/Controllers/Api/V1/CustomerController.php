<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CustomersFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CustomerCollection;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Requests\V1\StoreCustomerRequest as V1StoreCustomerRequest;
use App\Http\Resources\V1\CustomerResource;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if (!$request->user()->tokenCan('view')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $filter=new CustomersFilter();
        $queryItems=$filter->transform($request);   // [['coulmn','operator','value']]

        $includeInvoices = $request->query('includeInvoices');
        $Customers = Customer::where($queryItems);

        if($includeInvoices){
            $Customers=$Customers->with('invoices');
        }
        return new CustomerCollection($Customers->paginate()->appends($request->query()));

      
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(V1StoreCustomerRequest $request)
    {

        if (!$request->user()->tokenCan('create')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $customer = Customer::create($request->all());
            return new CustomerResource($customer);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not create customer.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer, Request $request)
    {
        if (!$request->user()->tokenCan('view')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        //
        // return $customer;

        $includeInvoices = $request->query('includeInvoices');

        if($includeInvoices){
            return new CustomerResource($customer->loadMissing('invoices'));
        }
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Customer $customer)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        if (!$request->user()->tokenCan('update')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $customer->update($request->all());
            return new CustomerResource($customer);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not update customer.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer, Request $request)
    {
        if (!$request->user()->tokenCan('delete')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $customer->delete();
            return response()->json(['message' => 'Customer deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not delete customer.'], 500);
        }
    }
}
