<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\InvoicesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreInvoicesRequest;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Requests\V1\StoreInvoiceRequest as V1StoreInvoiceRequest;
use App\Http\Requests\V1\UpdateInvoiceRequest as V1UpdateInvoiceRequest;
use App\Http\Resources\V1\InvoiceCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use PHPUnit\Framework\MockObject\Invocation;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if (!$request->user()->tokenCan('view')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $filter=new InvoicesFilter();
        $queryItems=$filter->transform($request);   // [['coulmn','operator','value']]

        if (Count($queryItems)==0){
            return new InvoiceCollection(Invoice::paginate());

        }else{
            $Invoices = Invoice::where($queryItems)->paginate();
            return new InvoiceCollection($Invoices->appends($request->query()));

        }

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
    public function store(V1StoreInvoiceRequest $request)
    {
        if (!$request->user()->tokenCan('create')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $invoice=Invoice::create($request->all());
        return new InvoiceResource($invoice);
    }

    public function bulkStore(BulkStoreInvoicesRequest $request)
    {

        if (!$request->user()->tokenCan('create')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $bulk = collect($request->all())->map(function($arr, $key){
                return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']);
            });
            Invoice::insert($bulk->toArray());
    
            return response()->json(['message' => 'Invoices inserted successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to insert invoices.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice, Request $request)
    {

        if (!$request->user()->tokenCan('view')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        //
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Invoice $invoice)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(V1UpdateInvoiceRequest $request, Invoice $invoice)
    {
        if (!$request->user()->tokenCan('update')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $invoice->update($request->all());
        return new InvoiceResource($invoice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice, Request $request)
    {

        if (!$request->user()->tokenCan('delete')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully.']);
    }
}
