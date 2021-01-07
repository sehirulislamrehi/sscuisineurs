<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\config;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


class configController extends Controller
{
    
    public function index()
    {
        $configs = config::orderBy('id','asc')->get();
        return view('backend.pages.priceConfig.manage',compact('configs'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'price' => 'required|min:0'
        ]); 
        $config = config::all();

        foreach( $request['price'] as $key => $price ):
            $config[$key]->price = $price;
            $config[$key]->save();
        endforeach;
        Toastr::success('Price Updated');
        return back();
    }

}
