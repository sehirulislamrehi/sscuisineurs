<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index(){
        $all_discount = Discount::all();
        return view('backend.pages.discount.manage', compact('all_discount'));
    }

    public function add(Request $request){
        $request->validate([
            'code' => 'required',
            'type' => 'required',
        ]);

        $discount = new Discount();

        $discount->code = $request->code;
        $discount->type = $request->type;

        if( $discount->save() ):
            Toastr::success('Code Added Successfully');
            return back();
        endif;
    }

    public function update(Request $request, $id){

        $request->validate([
            'code' => 'required',
            'type' => 'required',
        ]);

        $discount =  Discount::find($id);

        $discount->code = $request->code;
        $discount->type = $request->type;

        if( $discount->save() ):
            Toastr::success('Code Updated Successfully');
            return back();
        endif;
    }

    public function delete($id){

        $discount =  Discount::find($id);

        if( $discount->delete() ):
            Toastr::success('Code Deleted Successfully');
            return back();
        endif;
    }
}
