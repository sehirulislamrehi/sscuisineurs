<?php

namespace App\Http\Controllers;

use App\Exports\CustomReport;
use App\Mail\OrderPlaceMail;
use App\Models\menu;
use App\Models\order;
use App\Models\orderItem;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Brian2694\Toastr\Facades\Toastr;
use App\Exports\ReportExport;
use App\Http\Controllers\Backend\reservationController;
use App\Mail\ContactFormMail;
use App\Models\BookingTransaction;
use App\Models\ContactFormModel;
use App\Models\DinningHour;
use App\Models\gallery;
use App\Models\reservation;
use Carbon\Carbon;
use Excel;



class frontendController extends Controller
{
    public function contact()
    {
        return view('frontend.contact');
    }

    public function gallery()
    {
        $galleries = gallery::orderBy('id','desc')->paginate(24);
        return view('frontend.gallery',compact('galleries'));
    }

    public function dinning_hour()
    {
        $dinings = DinningHour::orderBy('id','desc')->paginate(24);
        return view('frontend.dinning_hours',compact('dinings'));
    }

    public function index()
    {
        return view('frontend.index');
    }

    public function menu()
    {
        return view('frontend.menu');
    }

    public function reservation()
    {
        return view('frontend.reservation');
    }


    public function addToCart(Request $request){
        $id = $request->id;

        $menu = menu::find($id);

        
        $cart = [
            'id' => $menu->id,
            'image' => $menu->image,
            'name' => $menu->name,  
            'qty' => 1,
            'price' => $menu->price,
            'total' => $menu->price,
        ];

        $newCart = [];
        $ex = false;
        if( $request->session()->get('cart') ):
            $session_cart = $request->session()->get('cart');

            foreach( $session_cart as $single_cart ):
                if( $single_cart['id'] == $cart['id'] ):
                    $single_cart['qty']++;
                    $single_cart['total'] = $single_cart['price'] * $single_cart['qty'];
                    $ex = true;
                endif;

                array_push($newCart, $single_cart);
            endforeach;

            if( !$ex ):
                array_push($newCart,$cart);

            endif;

        else:
            array_push($newCart,$cart);
        endif;

        $request->session()->put('cart', $newCart);

        return $this->cartitem($request);

    }   

    public function cartitem(Request $request){
        $cart = $request->session()->get('cart') or null;
        return $cart;
    }


    public function delete_cart_item(Request $request, $id){
        $cart = $this->cartitem($request) or Null;

        $delete_id = $id;
        $newCart = [];
        if($cart){
            foreach($cart as $single_cart){
                if($single_cart['id'] != $delete_id){
                    array_push($newCart, $single_cart);
                }
            }
        }

        $request->session()->put('cart', $newCart);

        return $this->cartitem($request);
    }



    public function checkout(Request $request){
        $cart = $this->cartitem($request) or null;

        $order = new order();
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->total_price = 0;

        if($order->save()){
            foreach($cart as $cart_item){
                $item = new orderItem();
                $item->item = $cart_item['name'];
                $item->price = $cart_item['price'];
                $item->qty = $cart_item['qty'];
                $item->total = $cart_item['total'];
                $item->image = $cart_item['image'];
                $item->order()->associate($order);
                $order->total_price += $item->total;
                if($item->save()){
                    $order->save();
                }
            }
        }

        Mail::to($order->email)->send(new OrderPlaceMail($order,'Your order has been placed'));
        Mail::to('test@gmail.com')->send(new OrderPlaceMail($order,'Order placed'));
        
        Toastr::success('Order Placed,We will call you soon');
        return redirect()->route('menu');
    }
    
    
    public function export(){
        $data = [];
        $all_data = BookingTransaction::whereDate('updated_at', Carbon::today())->where("is_payment_done",true)->where('is_delete', false)->get();
        foreach($all_data as $single_data){
            if($single_data->reservation->booking_date == Carbon::now()->toDateString() ){
                array_push($data, $single_data);
            }
        }
        $export = new ReportExport();
        return Excel::download($export->getDownloadByQuery($data), 'Todaysreport - '.Carbon::today()->toDateString().'.csv');


    }

    public function exportToDateFromDate(Request $request){
        $data = BookingTransaction::whereBetween('updated_at', [Carbon::parse($request->from),Carbon::parse($request->to)->addDay()])->orderBy('id','desc')->where("is_payment_done",true)->where('is_delete', false)->get();

        $export = new ReportExport();
        return Excel::download($export->getDownloadByQuery($data), 'DayWiseReport - '.Carbon::parse($request->from)->toDateString().' - '.Carbon::parse($request->to)->toDateString().'.csv');

    }


    public function exportcustom(Request $request){
        $data = [];
        $all_tran = BookingTransaction::whereBetween('updated_at', [Carbon::parse($request->from),Carbon::parse($request->to)->addDay()])->orderBy('id','desc')->where("is_payment_done",true)->where('paid_by', $request->payment_method)->where('is_delete', false)->get();
        if($all_tran->count() != 0){
            foreach( $all_tran as $single_tran ){
                if( $single_tran->reservation->discount_type == $request->discount_type && $single_tran->reservation->payment_type == $request->payment_type ){
                    array_push($data,$single_tran->reservation);
                }
            }
            $export = new CustomReport();
            return Excel::download($export->getDownloadByQuery($data), 'DayWiseReport - '.Carbon::parse($request->from)->toDateString().' - '.Carbon::parse($request->to)->toDateString().'.csv');
        }
        else{
            $data = $all_tran;
        $export = new CustomReport();
        return Excel::download($export->getDownloadByQuery($data), 'DayWiseReport - '.Carbon::parse($request->from)->toDateString().' - '.Carbon::parse($request->to)->toDateString().'.csv');
        }
        
        
        
        
        

        
        
        
        
    }

    public function contact_form(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|email:rfc,dns|regex:/(.*)@gmail\.com/i',
            'phone' => 'required|digits:11|numeric',
            'message' => 'required',
        ]);

        $message = new ContactFormModel();
        $message->name = $request->name;
        $message->email = $request->email;
        $message->phone = $request->phone;
        $message->message = $request->message;
        if( $message->save() ):
            Mail::to('info@sscuisineurs.com')->send(new ContactFormMail($message,'You have a new message'));
            return response()->json($message, 200);
        endif;
    }

}
