<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bogo;
use Illuminate\Http\Request;

class BogoController extends Controller
{
    public function index(){
        $bogos = Bogo::orderBy('id','desc')->get();
        return view('backend.pages.bogos.manage', compact('bogos'));
    }
}
