<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logo;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logos = Logo::orderBy('id','asc')->get();
        return view('backend.pages.logo.manage',compact('logos'));
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
        //
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
    public function update(Logo $logo,Request $request)
    {
        $request->validate([
            'image' => 'max:100|mimes:jpg,jpeg,png'
        ]);
        if( $request->image ){
            if( File::exists('images/logo/'. $logo->logo) ){
                File::delete('images/logo/'. $logo->logo);
            }
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/logo/' . $img);
            Image::make($image)->save($location);
            $logo->logo = $img;
        }
        $logo->save();
        
        Toastr::success('Logo Updated');
        return redirect()->route('logoShow');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logo $logo)
    {
        if( File::exists('images/logo/'. $logo->image) ){
            File::delete('images/logo/'. $logo->image);
        }
        $logo->delete();
        return redirect()->route('logoShow');
    }
}
