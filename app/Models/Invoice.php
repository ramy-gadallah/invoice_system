<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table="invoices";

    // protected $fillable=[];
    protected $guarded=[];

        //  section وال  invoice علاقة بين ال

    public function section(){
        return $this->belongsTo(Section::class);
    }
        // انتهاء

        //  products وال  invoices علاقة بين ال 
    public function products(){
        return $this->belongsTo(Product::class,'product_id');
    }



   

}
