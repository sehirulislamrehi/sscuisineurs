<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Backend\reservationController;
use App\Models\Bogo;
use App\Models\BookingTransaction;
use App\Models\category;
use App\Models\menu;
use App\Models\reservation;
use App\Models\ContactFormModel;
use App\Models\Day;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_menu = category::all();
        $all_food = menu::where('status',true);
        $total_sale = BookingTransaction::where('is_payment_done', true)->where('is_delete', false)->get();
        $total_amount_sale = 0;
        foreach($total_sale as $single_sale){
            $total_amount_sale += $single_sale->discounted_amount ? $single_sale->discounted_amount : $single_sale->amount;
        }
        
        $total_today_sale = 0;
        $todaySale = BookingTransaction::whereDate('updated_at', Carbon::now())->where('is_payment_done', true)->where('is_delete', false)->get();
        foreach($todaySale as $single_sale){
            if( $single_sale->reservation->booking_date == Carbon::now()->toDateString() ){
                
                $total_today_sale += $single_sale->discounted_amount ? $single_sale->discounted_amount : $single_sale->amount;
            }
            
        }

        $last_one_month_sale = BookingTransaction::where('is_payment_done', true)->where('is_delete', false)->get();
        $today = Carbon::now()->toDateString();
        $total_one_month = 0;
        $total_one_year = 0;

        foreach(  $last_one_month_sale as $single_one_month_sale ):
            $last_one_month = Carbon::parse($single_one_month_sale->updated_at->toDateString());
            $day_diff_one_month =  $last_one_month->diffInDays($today);
             if( $day_diff_one_month <= 30 ):
                $total_one_month += $single_one_month_sale->discounted_amount ? $single_one_month_sale->discounted_amount : $single_one_month_sale->amount;
             endif;
        endforeach;

        foreach(  $last_one_month_sale as $single_one_month_sale ):
            $last_one_year = Carbon::parse($single_one_month_sale->updated_at->toDateString());
            $day_diff_one_year =  $last_one_year->diffInDays($today);
             if( $day_diff_one_year <= 365 ):
                $total_one_year += $single_one_month_sale->discounted_amount ? $single_one_month_sale->discounted_amount : $single_one_month_sale->amount;
             endif;
        endforeach;

        $total_reservation = reservation::where('is_delete', false)->get();

        $unread_message = ContactFormModel::where('is_replied', false)->get();
       

        return view('backend.pages.dashboard',compact(
            'total_menu','all_food','total_sale','todaySale','total_one_month','total_one_year','total_reservation','total_amount_sale','total_today_sale','unread_message'
        ));
    }
    
    public function date_person_count(){
        $adult = 0;
        $child_below_12 = 0;
        $child_below_5 = 0;
        $total_person = 0;
        $total_payment_done = 0;
        $on_spot_payment = 0;
        $online_payment = 0;
        $reservations = reservation::whereDate('booking_date',Carbon::now())->where('is_delete', false)->get();

        
        if( Carbon::now()->toDateString() == '2020-12-15' ){
            $day = Day::where('day','Saturday')->first();
            $date = Carbon::now();
        }else{
            
            $day = Day::where('day', Carbon::now()->format('l'))->first();
            $date = Carbon::now();
        }   
        $holiday = Holiday::whereDate('date', Carbon::now()->toDateString())->first();
        if($holiday){
            if( Carbon::now()->toDateString() ==  $holiday->date ){
                $day = Day::where('day','Saturday')->first();
                $date = Carbon::now();
            }
        }
        
        
        
        
        

        foreach( $reservations as $single_reservation ){
            $adult += $single_reservation->adult;
            $child_below_12 += $single_reservation->child_under_132_cm;
            $child_below_5 += $single_reservation->child_under_120_cm;
            if($single_reservation->bookingTransation->is_payment_done){
                $total_payment_done += 1;
                if($single_reservation->bookingTransation->paid_by == "Cash"){
                    $on_spot_payment += 1;
                }else{
                    $online_payment +=1;
                }
            }
            
            
        }
        $total_person = $adult + $child_below_12 + $child_below_5;
        return view('backend.pages.date_person_count', compact('adult','child_below_12','child_below_5','total_person','reservations', 'total_payment_done', 'on_spot_payment', "online_payment",'day','date'));
    }
    
    public function total_person_count(Request $request){
        $adult = 0;
        $child_below_12 = 0;
        $child_below_5 = 0;
        $total_person = 0;
        $total_payment_done = 0;
        $on_spot_payment = 0;
        $online_payment = 0;
        $reservations = reservation::whereDate('booking_date', $request->date)->where('is_delete', false)->get();
        
        
        if( $request->date == '2020-12-15' ){
            $day = Day::where('day','Saturday')->first();
            $date = $request->date;
        }
        else{
            $day = Day::where('day', Carbon::parse($request->date)->format('l'))->first();
            $date = $request->date;  
        }
        $holiday = Holiday::whereDate('date', $request->date)->first();
        if($holiday){
            if( $request->date == $holiday->date ){
                $day = Day::where('day','Saturday')->first();
                $date = $request->date;
            }
        }
       
        

        foreach( $reservations as $single_reservation ){
            $adult += $single_reservation->adult;
            $child_below_12 += $single_reservation->child_under_132_cm;
            $child_below_5 += $single_reservation->child_under_120_cm;
            if($single_reservation->bookingTransation->is_payment_done){
                $total_payment_done += 1;
                if($single_reservation->bookingTransation->paid_by == "Cash"){
                    $on_spot_payment += 1;
                }else{
                    $online_payment +=1;
                }
            }
            
        }
        $total_person = $adult + $child_below_12 + $child_below_5;
        return view('backend.pages.date_person_count', compact('adult','child_below_12','child_below_5','total_person','reservations', 'total_payment_done', 'on_spot_payment', "online_payment",'day','date'));
    }
    
}
