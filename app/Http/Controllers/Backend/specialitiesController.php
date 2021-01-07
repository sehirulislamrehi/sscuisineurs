<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\specialities;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class specialitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $speciality = specialities::orderBy('id','desc')->get();
        return view('backend.pages.specializations.manage',compact('speciality'));
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
        $request->validate([
            'title' => 'required',
            'image' => 'required|max:500|mimes:jpeg,png,jpg',
        ]);
        $specialities = new specialities();
      
        $specialities->title=$request->title;
        $specialities->description=$request->description;
        if( $request->image ){
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/specialities/' . $img);
            Image::make($image)->save($location);
            $specialities->image = $img;
        }
        
        $specialities->save();
        Toastr::success('Created');

        return redirect()->route('specialityShow');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(specialities $specialities,Request $request)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(specialities $specialities,Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'max:100|mimes:jpeg,png,jpg',
        ]);

        $specialities->title=$request->title;
        $specialities->description=$request->description;

        if( $request->image ){
           if( File::exists('images/specialities/'. $specialities->image) ){
               File::delete('images/specialities/'. $specialities->image);
           }
           $image  = $request->file('image');
           $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
           $location = public_path('images/specialities/' . $img);
           Image::make($image)->save($location);
           $specialities->image = $img;
       }

       $specialities->save();

       Toastr::success('specialities Updated');
       return redirect()->route('specialityShow');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(specialities $specialities)
    {
        if( File::exists('images/specialities/'. $specialities->image) ){
            File::delete('images/specialities/'. $specialities->image);
        }
        $specialities->delete();
        Toastr::error('specialities Deleted');
        return back();
    }
}
