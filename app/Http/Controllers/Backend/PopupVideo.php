<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PopupVideoModal;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;


class PopupVideo extends Controller
{
    public function index(){
        $videos = PopupVideoModal::all();
        return view('backend.pages.video.manage', compact('videos'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'video' => 'required',
        ]);

        $video = PopupVideoModal::find($id);
        $video->video = $request->video;

        if($video->save()):
            Toastr::Success('Video Updated');
            return back();
        endif;
    }
}
