<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    public function index(){
        $events = event::orderBy('id','desc')->get();
        return view('backend.pages.event.manage', compact('events'));
    }

    public function add(Request $request){
        $request->validate([
            'title' => 'required',
            'image' => 'required|max:100|mimes:jpeg,png,jpg',
        ]);
        $event = new event();
      
        $event->title=$request->title;
        $event->description=$request->description;
        if( $request->image ){
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/event/' . $img);
            Image::make($image)->save($location);
            $event->image = $img;
        }
        
        $event->save();
        Toastr::success('Item Added Successfully');

        return back();
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'image' => 'max:100|mimes:jpeg,png,jpg',
        ]);
        $event = event::find($id);
      
        $event->title=$request->title;
        $event->description=$request->description;
        if( $request->image ){
            if( File::exists('images/event/'. $event->image) ){
                File::delete('images/event/'. $event->image);
            }
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/event/' . $img);
            Image::make($image)->save($location);
            $event->image = $img;
        }
        
        $event->save();
        Toastr::success('Item Updated Successfully');
        return back();
    }

    public function delete($id)
    {
        $event = event::find($id);
        if( File::exists('images/event/'. $event->image) ){
            File::delete('images/event/'. $event->image);
        }
        $event->delete();
        Toastr::error('Event Deleted');
        return back();
    }
}
