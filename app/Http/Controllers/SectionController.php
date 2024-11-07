<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections= Section::select('id','section_name','description')->get();
        // dd($sections);
            return view('sections.sections',compact('sections'));
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
            // معمول بيه validation request وفيه 
        
        // $request->validate([
        //     'section_name'=>'required',
        //     'description'=>'required',

        // ],[ 
        //     'section_name.required'=>'لازم يكون الاسم موجود',
        //     'description.required'=>'لازم يكون الوصف موجود',
        // ]
        // );


        $b_exists= Section::where('section_name','=',$request->section_name)->exists(); 
        // لو موجود قبل كده $request->section_name بيساوى section_name اللى ف الداتا بيز  column هنا بقولو لو ال
        if($b_exists){ // رجعلى رسالة قولى القسم مكرر
            session()->flash('error','خطا القسم مسجل مسبقا ');
            return redirect()->back();
        }
        else{ // ولو القسم مش موجود اعمل كرييت عادى 
            Section::create([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'created_by'=>auth()->user()->name,
            ]);

            session()->flash('error','تم اضافة القسم بنجاح');
            return redirect()->route('sections.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(SectionRequest $request)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       
        $request-> validate([
            'section_name'=>'required|unique:sections,section_name',
            'description'=>'required|unique:sections,description',
        ],[
            'section_name.required'=>'the name must be required',
            'section_name.unique'=>'the name must be unique',
            'description.required'=>'the descripthion must be required',
            'description.unique'=>'the descripthion must be unique',
            
            ]
        );

        $section = Section::find($request->id);
        $section->update([
            'section_name'=>$request->section_name,
            'description'=>$request->description,
        ]);

        session()->flash('success','تم التعديل بنجاح ');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        Section::find($request->section_id)->delete();
        session()->flash('delete','لقد تم حذف القسم بنجاح');
        return redirect()->back();
    }

}
