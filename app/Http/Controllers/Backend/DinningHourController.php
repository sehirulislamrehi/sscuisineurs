<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DinningHour;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;

class DinningHourController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dinings = DinningHour::orderBy('id','desc')->get();
        return view('backend.pages.dininghour.manage',compact('dinings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'image' => 'required|max:100|mimes:jpg,jpeg,png'
        ]);
        $dining = new DinningHour();
      
        $dining->caption = $request->caption;
        if( $request->image ){
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/dining/' . $img);
            Image::make($image)->save($location);
            $dining->image = $img;
        }
        
        $dining->save();
        Toastr::success('dining Image Created');

        return redirect()->route('dining.all');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DinningHour $dining,Request $request)
    {
        $request->validate([
            'image' => 'max:100|mimes:jpg,jpeg,png'
        ]);
        
        $dining->caption = $request->caption;
        
        if( $request->image ){
            if( File::exists('images/dining/'. $dining->image) ){
                File::delete('images/dining/'. $dining->image);
            }
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/dining/' . $img);
            Image::make($image)->save($location);
            $dining->image = $img;
        }
        $dining->save();
        Toastr::success('Updated Successfully');
        return redirect()->route('dining.all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DinningHour $dining)
    {
        if( File::exists('images/dining/'. $dining->image) ){
            File::delete('images/dining/'. $dining->image);
        }
        $dining->delete();
        Toastr::error('Deleted Successfully');
        return redirect()->route('dining.all');
    }
}
