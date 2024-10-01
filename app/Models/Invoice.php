<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Invoice extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable=['customer_id','amount','status','billed_date','paid_date'];
    
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
