<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index(){
        $holidays = Holiday::orderBy('id','desc')->get();
        return view('backend.pages.holiday.manage', compact('holidays'));
    }

    public function add(Request $request){
        $request->validate([
            'name' => 'required|unique:holidays,name',
            'date' => 'required',
        ]);

        $holiday = new Holiday();

        $holiday->name = $request->name;
        $holiday->date = $request->date;

        if( $holiday->save() ){
            Toastr::success('Holiday Added Successfully');
            return back();
        }
    }

    public function update(Request $request, $id){
        $holiday = Holiday::find($id);

        $request->validate([
            'name' => 'required|unique:holidays,name,'.$id,
            'date' => 'required',
        ]);

        $holiday->name = $request->name;
        $holiday->date = $request->date;

        if( $holiday->save() ){
            Toastr::success('Holiday Updated Successfully');
            return back();
        }
    }

    public function delete($id){
        $holiday = Holiday::find($id);

        if( $holiday->delete() ){
            Toastr::success('Holiday Deleted Successfully');
            return back();
        }
    }
}
