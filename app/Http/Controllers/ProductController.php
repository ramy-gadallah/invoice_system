<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections=Section::get();
        $products=Product::get();
      // $products=Product::with('section')->get();



        // return $products;
        return view('products.Products',compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules=[
            'Product_name'=>'required',
            'section_id'=>'required',
            'description'=>'required',
           ];
           $messages=[
            'Product_name.required'=>'يجب ادخال حقل اسم المنتج',
            'section_id.required'=>'يجب ادخال حقل القسم',
            'description.required'=>'يجب ادخال حقل الوصف',
           ];

       

       $validator=Validator::make($request->all(),$rules,$messages);

       if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
    };




        Product::create([
            'product_name'=>$request->Product_name,
            'section_id'=>$request->section_id,
            'description'=>$request->description,
        ]);
        session()->flash('success', 'لقد تم اضافة المنتج بنجاح');

        return redirect()->back();
        
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
 

    public function test($id){
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
              $rules=[
            'product_name'=>'required',
            'section_id'=>'required',
            'description'=>'required',
           ];
           $messages=[
            'product_name.required'=>'يجب ادخال حقل اسم المنتج',
            'section_id.required'=>'يجب ادخال حقل القسم',
            'description.required'=>'يجب ادخال حقل الوصف',
           ];
    

           $validator=Validator::make($request->all(),$rules,$messages);

           if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        };
        //   $id=Section::where('section_name',$request->section_name)->first()->id;
        //   $id = $request->id ;
        // $products=Product::findOrFail($id);
        // $products=Product::findOrFail($request->product_id);
        
        // $products->update([
        //     'product_name'=>$request->product_name,
        //     'description'=>$request->description,
        //     'section_id'=>$request->section_id,
        // ]);
        // session()->flash('edit','تم تعديل النتج بنجاح');
        // return redirect()->back();
        // dd($products);


        $products = Product::find($request->product_id);
        $products->update([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$request->section_id,
        ]);


        session()->flash('edit','تم التعديل بنجاح ');
        return redirect()->back();


        // $products=Product::find($request->id);
        // $products->product_name=$request->product_name;
        // $products->section_id=$request->section_id;
        // $products->description=$request->description;
        // $products->save();

        // return $request;



       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product=Product::find($request->product_id);
        $product->delete();
        return redirect()->back();
    }

   
}
