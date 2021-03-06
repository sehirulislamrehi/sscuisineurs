<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abouts = About::orderBy('id','desc')->get();
        return view('backend.pages.aboutUs.manage',compact('abouts'));
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
        
        $about = new About();

        $about->description = $request->description;
        $about->title = $request->title;

        if( $request->image ){
            $image  = $request->file('image');
            $img    = time() . Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/about/' . $img);
            Image::make($image)->save($location);
            $about->image = $img;
        }

        $about->save();
        Toastr::success('about Created');

        return redirect()->route('aboutShow');
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
    public function update(About $about, Request $request)
    {
        
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'max:100|mimes:jpeg,png,jpg'
        ]);

        $about->description = $request->description;
        $about->title = $request->title;

        if( $request->image ){
            if( File::exists('images/about/'. $about->image) ){
                File::delete('images/about/'. $about->image);
            }
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/about/' . $img);
            Image::make($image)->save($location);
            $about->image = $img;
        }

        $about->save();
        Toastr::success('about updated');

        return redirect()->route('aboutShow');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( About $about)
    {
        $about->delete();
        Toastr::error('about Deleted');
        return redirect()->route('aboutShow');
    }
}
