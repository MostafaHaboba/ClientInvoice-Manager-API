<?php

namespace App\Filters\V1;
use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class InvoicesFilter extends ApiFilter{
    protected $safeParms=[
        'id'=>['eq','gt','lt','lte','gte'],
        'CustomerId'=>['eq','gt','lt','lte','gte'],
        'amount'=>['eq','gt','lt','lte','gte'],
        'status'=>['eq','ne'],
        'billedDate'=>['eq','gt','lt','lte','gte'],
        'paidDate'=>['eq','gt','lt','lte','gte'],
    ];

    protected $coulmnMap =[
        'customerId'=>'customer_id',
        'billedDate'=>'billed_date',
        'paidDate'=>'paid_date',

    ];
    protected $operatorMap =[
        'eq'=>'=',
        'lt'=>'<',
        'gt'=>'>',
        'lte'=>'<=',
        'gte'=>'>=',
        'ne'=>'!=',


    ];
}