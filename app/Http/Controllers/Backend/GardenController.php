<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Garden;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;
class GardenController extends Controller
{
    public function index(){
        $gardens = Garden::orderBy('id','desc')->get();
        return view('backend.pages.garden.manage',compact('gardens'));
    }
    
    public function add(Request $request){
        $request->validate([
            'title' => 'required',
            'image' => 'required|max:100|mimes:jpeg,png,jpg',
        ]);
        $garden = new Garden();
      
        $garden->title=$request->title;
        $garden->description=$request->description;
        if( $request->image ){
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/garden/' . $img);
            Image::make($image)->save($location);
            $garden->image = $img;
        }
        
        $garden->save();
        Toastr::success('Item Added Successfully');

        return back();
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'image' => 'max:100|mimes:jpeg,png,jpg',
        ]);
        $garden = Garden::find($id);
      
        $garden->title=$request->title;
        $garden->description=$request->description;
        if( $request->image ){
            if( File::exists('images/garden/'. $garden->image) ){
                File::delete('images/garden/'. $garden->image);
            }
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/garden/' . $img);
            Image::make($image)->save($location);
            $garden->image = $img;
        }
        
        $garden->save();
        Toastr::success('Item Updated Successfully');
        return back();
    }

    public function delete($id)
    {
        $garden = Garden::find($id);
        if( File::exists('images/garden/'. $garden->image) ){
            File::delete('images/garden/'. $garden->image);
        }
        $garden->delete();
        Toastr::error('Garden Deleted');
        return back();
    }
}
