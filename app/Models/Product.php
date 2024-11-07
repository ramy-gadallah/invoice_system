<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // protected $fillable=['product_name','section_id','description'];
    protected $guarded=[];


        //  section وال  product علاقة بين ال

    public function section(){
        return $this->belongsTo(Section::class);
    }
    // انتهاء 
  
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

  

}
