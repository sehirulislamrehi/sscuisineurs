<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\slider;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



class homeSlider extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('id','desc')->get();
        return view('backend.pages.homeSlider.manage',compact('sliders'));
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
            'image' => 'required|max:100|mimes:jpeg,png,jpg'
        ]);
        $slider = new slider();
      
        $slider->title= $request->title ? $request->title : '';
        if( $request->image ){
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/slider/' . $img);
            Image::make($image)->save($location);
            $slider->image = $img;
        }
        
        $slider->save();
        Toastr::success('Banner Image Created');

        return redirect()->route('sliderShow');
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
    public function update(Slider $slider,Request $request)
    {
        $request->validate([
            'image' => 'max:100|mimes:jpeg,png,jpg'
        ]);

        $slider->title= $request->title ? $request->title : '';

         if( $request->image ){
            if( File::exists('images/slider/'. $slider->image) ){
                File::delete('images/slider/'. $slider->image);
            }
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/slider/' . $img);
            Image::make($image)->save($location);
            $slider->image = $img;
        }
        $slider->save();
        Toastr::success('Slider Updated');
        return redirect()->route('sliderShow');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        if( File::exists('images/slider/'. $slider->image) ){
            File::delete('images/slider/'. $slider->image);
        }
        $slider->delete();
        Toastr::error('Slider Deleted');
        return redirect()->route('sliderShow');
    }
}
