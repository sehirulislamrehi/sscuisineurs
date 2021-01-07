<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reservation as ResourcesReservation;
use App\Models\reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationMail;
use App\Mail\PaidReservationMail;
use App\Models\Bogo;
use App\Models\BookingTransaction;
use App\Models\category;
use App\Models\config;
use App\Models\ContactFormModel;
use App\Models\Day;
use App\Models\Discount;
use App\Models\Holiday;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Egulias\EmailValidator\EmailValidator;
use GuzzleHttp\Client;
use Milon\Barcode\BarcodeServiceProvider;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use phpDocumentor\Reflection\Types\Null_;
use Yajra\DataTables\Facades\DataTables;

class reservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //HELLO
    public function index()
    {
        return view('backend.pages.reservation.manage');
    }

    public function all_data(Request $request)
    {
        $reservation = reservation::orderBy('id', 'desc')->where('is_delete', false)->get();
        return DataTables::of($reservation)
            ->rawColumns(['action', 'payment_status', 'arrival'])
            
            ->editColumn('grand_total', function (reservation $reservations) {
                return $reservations->bookingTransation->amount . ' BDT';
            })
            ->editColumn('discount', function (reservation $reservations) {
                if ($reservations->bookingTransation->discounted_amount) {
                    if ($reservations->discount_type == 'Brac') {
                        return $reservations->bookingTransation->discounted_amount . ' BDT (' . 'Brac Bank' . ' )';
                    } else {
                        if ($reservations->discount_percent) {
                            return $reservations->bookingTransation->discounted_amount . ' BDT ( ' . $reservations->discount_type . ' ' . $reservations->discount_percent . '% )';
                        } else {
                            return $reservations->bookingTransation->discounted_amount . ' BDT ( ' . $reservations->discount_type . ' )';
                        }
                    }
                } else {
                    return 'No Discount';
                }
            })
            ->editColumn('payment_status', function (reservation $reservations) {
                if ($reservations->bookingTransation->is_payment_done == true) {
                    if ($reservations->payment_type) {
                        return '<p class="badge badge-success">Paid (' . $reservations->payment_type . ')</p>';
                    } else {
                        return '<p class="badge badge-success">Paid </p>';
                    }
                } else {
                    return '<p class="badge badge-danger">Not Paid </p>';
                }
            })
            ->editColumn('arrival', function (reservation $reservations) {
                if ($reservations->arrived == 0) {
                    return '<p class="badge badge-danger">Not Arrived </p>';
                } else {
                    return '<p class="badge badge-success">Arrived </p>';
                }
            })
            ->editColumn('action', function (reservation $reservations) {
                return '
                <button type="button" data-content="' . route('reservation.view', $reservations->id) . '" data-target="#myModal" class="btn btn-primary" data-toggle="modal">
                    View
               </button>';
            })->make(true);
    }

    public function data_view($id)
    {
        $reservation = reservation::find($id);
        return view('backend.modals.reservation.view', compact('reservation'));
    }

    public function paid()
    {
        $reservations = reservation::orderBy('id', 'desc')->where('is_delete', 0)->where('payment_method', 1)->whereDate('booking_date', Carbon::now())->get();
        return view('backend.pages.reservation.paid', compact('reservations'));
    }


    public function not_paid()
    {
        $reservations = reservation::orderBy('id', 'desc')->where('is_delete', 0)->where('payment_method', 0)->whereDate('booking_date', Carbon::now())->get();
        return view('backend.pages.reservation.notPaid', compact('reservations'));
    }

    public function arrived()
    {
        $reservations = reservation::orderBy('id', 'desc')->where('is_delete', 0)->where('arrived', 1)->get();
        return view('backend.pages.reservation.arrived', compact('reservations'));
    }

    public function not_arrived()
    {
        $reservations = reservation::orderBy('id', 'desc')->where('is_delete', 0)->where('arrived', 0)->get();
        return view('backend.pages.reservation.notArrived', compact('reservations'));
    }

    //onspot reservation edit
    public function edit($id)
    {
        $reservation = reservation::find($id);
        return view('backend.pages.reservation.edit', compact('reservation'));
    }

    //online reservation edit
    public function edit_online($id)
    {
        $reservation = reservation::find($id);
        return view('backend.pages.reservation.edit_online', compact('reservation'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    public function gp_star($code, $amount)
    {
        if ($amount != 0) {
            $all_code = Discount::where('type', 'GPStar')->get();
            foreach ($all_code as $single_code) :
                if ($single_code->code == $code) :
                    $discount = (20 / 100) * $amount;
                    $discount_amount = $amount - floor($discount);
                    return response()->json(['discount_amount' => $discount_amount], 200);
                endif;
            endforeach;
            return response()->json(['discount_failed' => 'Invalid Code'], 200);
        } else {
            return response()->json(['please_select' => 'Please use valid information of adult, child, time and date'], 200);
        }
    }

    public function city_gem($code, $amount)
    {
        if ($amount != 0) {
            $all_code = Discount::where('type', 'CityGem')->get();
            foreach ($all_code as $single_code) :
                if ($single_code->code == $code) :
                    $discount = (15 / 100) * $amount;
                    $discount_amount = $amount - floor($discount);
                    return response()->json(['discount_amount' => $discount_amount], 200);
                endif;
            endforeach;
            return response()->json(['discount_failed' => 'Invalid Code'], 200);
        } else {
            return response()->json(['please_select' => 'Please use valid information of adult, child, time and date'], 200);
        }
    }

    public function brac_bank($card, $amount, $menu, $date)
    {
        $bogos = Bogo::whereDate('reservation_date', $date)->get();
        foreach ($bogos as $bogo) {
            if ($bogo->card_number == $card) {
                return response()->json(['already_taken' => 'You get bogo offer in your selected date at once. Please choose another date to get bogo offer. Thanks.'], 200);
            }
        }

        if ($menu != "Please Select Your Time" && $amount != 0) {
            $menu_price = category::where('id', $menu)->first()->price;
            $bracs = Discount::where('type', 'BracBank')->get();
            foreach ($bracs as $brac) {
                if ($brac->code == substr($card, 0, 6)) {
                    $bogo_amount = $amount - $menu_price;
                    return response()->json(['bogo_success' => $bogo_amount], 200);
                }
            }
            return response()->json(['bogo_failed' => 'You have no bogo offer in your Brac Bank Card'], 200);
        } else {
            return response()->json(['select_menu' => 'Please give valid information of adult, child, time and date'], 200);
        }
    }

    public function ebl($card, $amount, $menu, $date)
    {
        $bogos = Bogo::whereDate('reservation_date', $date)->get();
        foreach ($bogos as $bogo) {
            if ($bogo->card_number == $card) {
                return response()->json(['already_taken' => 'You get bogo offer in your selected date at once. Please choose another date to get bogo offer. Thanks.'], 200);
            }
        }

        if ($menu != "Please Select Your Time" && $amount != 0) {
            $menu_price = category::where('id', $menu)->first()->price;
            $ebls = Discount::where('type', 'EBL')->get();
            foreach ($ebls as $ebl) {
                if ($ebl->code == substr($card, 0, 6)) {
                    $bogo_amount = $amount - $menu_price;
                    return response()->json(['bogo_success' => $bogo_amount], 200);
                }
            }
            return response()->json(['bogo_failed' => 'You have no bogo offer in your EBL Card'], 200);
        } else {
            return response()->json(['select_menu' => 'Please give valid information of adult, child, time and date'], 200);
        }
    }

    public function validate_bogo($card_number)
    {
        $bogo_validation = Discount::orWhere('type', 'EBL')->orWhere('type', 'BracBank')->get();
        foreach ($bogo_validation as $single_validation) {
            if (substr($card_number, 0, 6) ==  $single_validation->code) {
                return response()->json(['validation_success' => 'This card is applicable for bogo'], 200);
            }
        }
        return response()->json(['validation_failed' => 'This person is not applicable for bogo'], 200);
    }


    public function validate_bogo_ebl($card_number, $menu_price, $total_amount, $date)
    {

        $bogos = Bogo::whereDate('reservation_date', $date)->get();
        foreach ($bogos as $bogo) {
            if ($bogo->card_number == $card_number) {
                return response()->json(['validation_failed' => 'You get bogo offer in your selected date at once. Please choose another date to get bogo offer. Thanks.'], 200);
            }
        }

        $ebl_validate = Discount::orWhere('type', 'EBL')->get();
        foreach ($ebl_validate as $single_validation) {
            if (substr($card_number, 0, 6) ==  $single_validation->code) {
                $total_amount -= $menu_price;
                return response()->json(['validation_success' => $total_amount], 200);
            }
        }
        return response()->json(['validation_failed' => 'This person is not applicable for bogo'], 200);
    }

    public function validate_bogo_brac($card_number, $menu_price, $total_amount, $date)
    {
        $bogos = Bogo::whereDate('reservation_date', $date)->get();
        foreach ($bogos as $bogo) {
            if ($bogo->card_number == $card_number) {
                return response()->json(['validation_failed' => 'You get bogo offer in your selected date at once. Please choose another date to get bogo offer. Thanks.'], 200);
            }
        }

        $ebl_validate = Discount::orWhere('type', 'BracBank')->get();
        foreach ($ebl_validate as $single_validation) {
            if (substr($card_number, 0, 6) ==  $single_validation->code) {
                $total_amount -= $menu_price;
                return response()->json(['validation_success' => $total_amount], 200);
            }
        }
        return response()->json(['validation_failed' => 'This person is not applicable for bogo'], 200);
    }


    public function validate_amex_bogo($card_number, $menu_price, $total_amount,$date)
    {
        $bogos = Bogo::whereDate('reservation_date', $date)->get();
        
            foreach( $bogos as $bogo ){
                if($bogo->card_number == $card_number){
                    return response()->json(['already_exist' => 'This person already use bogo offer today. He is not applicable for bogo today'], 200);
                }
            }
        
            $total_amount -= $menu_price;
            return response()->json(['bogo_success' => $total_amount], 200);
    }

    public function dynamic_dependent($booking_date)
    {
        $holidays = Holiday::all();
        if ($booking_date == '2020-12-15' || $booking_date == '2021-02-21' || $booking_date == '2021-03-07') {
            foreach ($holidays as $holiday) {
                if ($holiday->date == '2020-12-15' || $holiday->date == '2021-02-21' || $holiday->date == '2021-03-07') {
                    $day = Day::where('day', 'Saturday')->first();
                    return  $day->category()->get();
                }
            }
        }
        foreach ($holidays as $holiday) {
            if ($holiday->date == $booking_date) {
                $day = Day::where('day', 'Saturday')->first();
                return  $day->category()->get();
            }
        }

        $booking_date = Carbon::parse($booking_date)->format('l');
        $day = Day::where('day', $booking_date)->first();
        return  $day->category()->get();
    }

    //backend reservation start
    public function make_reservation_page(){
        return view('backend.pages.reservation.reservation');
    }

    public function make_reservation(Request $request){
        $message = [
            'payment_method.required' => 'Please select a payment method',
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email address',
            'phone.required' => 'Please enter your phone number',
            'phone.numeric' => 'Please give a valid phone number',
            'booking_date.required' => 'Please choose your booking date',
            'menu_id.required' => 'Please choose your time',
            'menu_id.numeric' => 'Please choose your time',
            'address.required' => 'Please enter your address',
            'city.required' => 'Please enter your city name',
            'country.required' => 'Please enter your country name',

            'adult.required' => 'Please set adult at least 1',
            'adult.min' => 'Please set adult at least 1',

            'child_under_120_cm.required' => 'Please set adult at least 0',
            'child_under_120_cm.min' => 'Please set adult at least 0',

            'child_under_132_cm.required' => 'Please set adult at least 0',
            'child_under_132_cm.min' => 'Please set adult at least 0',
        ];

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|digits:11|numeric',
            'booking_date' => 'required',
            'menu_id' => 'required|numeric|min:1|max:5',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'adult' => 'required|numeric|min:1',
            'child_under_120_cm' => 'required|numeric|min:0',
            'child_under_132_cm' => 'required|numeric|min:0',
            'payment_method' => 'required|numeric|min:0|max:1'
        ], $message);

        //choose category
       $category = category::where('id', $request->menu_id)->first();

        $reservation = new reservation();
        $reservation->name = $request->name;
        $reservation->email = $request->email;
        $reservation->phone = $request->phone;
        $reservation->booking_date = $request->booking_date;
        $reservation->category_id = $request->menu_id;
        $reservation->category_price = $category->price;
        $reservation->adult = $request->adult;
        $reservation->child_under_120_cm = $request->child_under_120_cm;
        $reservation->child_under_132_cm = $request->child_under_132_cm;
        $reservation->city = $request->city;
        $reservation->country = $request->country;
        $reservation->address = $request->address;
        $reservation->message = $request->message;
        $reservation->random = rand(10000, 9999999);

        //total amount calculation
        $price_for_adult = $category->price;
        $price_for_132 =  floor($category->price / 2);
        $totalAmount = ($request->adult * $price_for_adult) + ($request->child_under_132_cm * $price_for_132);
        $discount_amount = $request->discount_amount;
        $reservation->payment_method = $request->payment_method;

        if ($reservation->save()) :
            $transaction = new BookingTransaction();
            $transaction->amount = $totalAmount;
            $transaction->discounted_amount = $discount_amount ? $discount_amount : NULL;
            $transaction->reservation_id = $reservation->id;
            $transaction->paid_by = 'Cash';
            $transaction->is_payment_done = false;

            if ($transaction->save()) :
                
                // Mail::to('info@sscuisineurs.com')->send(new ReservationMail($reservation, 'New Reservation'));
                // Mail::to($reservation->email)->send(new ReservationMail($reservation, 'Reservation Success'));
                $code = $transaction->reservation->random;
                $request->session()->flash('code',$code);
                return redirect()->route('reservation.make.page');
            endif;
        endif;
    }
    //backend reservation end



















    public function store(Request $request)
    {
        //validation
        $message = [
            'payment_method.required' => 'Please select a payment method',
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email address',
            'phone.required' => 'Please enter your phone number',
            'phone.numeric' => 'Please give a valid phone number',
            'booking_date.required' => 'Please choose your booking date',
            'menu_id.required' => 'Please choose your time',
            'menu_id.numeric' => 'Please choose your time',
            'address.required' => 'Please enter your address',
            'city.required' => 'Please enter your city name',
            'country.required' => 'Please enter your country name',

            'adult.required' => 'Please set adult at least 1',
            'adult.min' => 'Please set adult at least 1',

            'child_under_120_cm.required' => 'Please set adult at least 0',
            'child_under_120_cm.min' => 'Please set adult at least 0',

            'child_under_132_cm.required' => 'Please set adult at least 0',
            'child_under_132_cm.min' => 'Please set adult at least 0',
        ];

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|digits:11|numeric',
            'booking_date' => 'required',
            'menu_id' => 'required|numeric|min:1|max:5',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'adult' => 'required|numeric|min:1',
            'child_under_120_cm' => 'required|numeric|min:0',
            'child_under_132_cm' => 'required|numeric|min:0',
            'payment_method' => 'required|numeric|min:0|max:1'
        ], $message);

        $validator = new EmailValidator();
        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation()
        ]);

        $validator->isValid($request->email, $multipleValidations);

        if ($validator->isValid($request->email, $multipleValidations) == false) {
            return response()->json(['email' => 'Please give a valid'], 200);
        }

        //choose category
        $category = category::where('id', $request->menu_id)->first();

        $reservation = new reservation();
        $reservation->name = $request->name;
        $reservation->email = $request->email;
        $reservation->phone = $request->phone;
        $reservation->booking_date = $request->booking_date;
        $reservation->category_id = $request->menu_id;
        $reservation->category_price = $category->price;
        $reservation->adult = $request->adult;
        $reservation->child_under_120_cm = $request->child_under_120_cm;
        $reservation->child_under_132_cm = $request->child_under_132_cm;
        $reservation->city = $request->city;
        $reservation->country = $request->country;
        $reservation->address = $request->address;
        $reservation->message = $request->message;
        $reservation->random = rand(10000, 9999999);

        //total amount calculation
        $price_for_adult = $category->price;
        $price_for_132 =  floor($category->price / 2);
        $totalAmount = ($request->adult * $price_for_adult) + ($request->child_under_132_cm * $price_for_132);
        $discount_amount = $request->discount_amount;
        $reservation->payment_method = $request->payment_method;

        $reservation->save();
        if ($request->discount_amount == 0) {
            $reservation->discount_type = NULL;
        } else {
            $reservation->discount_type = $request->discount;
            $bogo = new Bogo();
            if ($request->brac_bank_card != NULL || $request->ebl_card != NULL) {
                if ($request->brac_bank_card != NULL) {
                    $bogo->card_number = $request->brac_bank_card;
                    $bogo->reservation_id = $reservation->id;
                    $bogo->reservation_date = $reservation->booking_date;
                } else if ($request->ebl_card != NULL) {
                    $bogo->card_number = $request->ebl_card;
                    $bogo->reservation_id = $reservation->id;
                    $bogo->reservation_date = $reservation->booking_date;
                }
                $bogo->save();
            }
        }

        if ($reservation->save()) :
            if ($request->payment_method == 0) :
                return $this->onSpotPayment($reservation, $totalAmount, $discount_amount);
            else :
                return $this->SSLCommerz($reservation, $totalAmount, $discount_amount);
            endif;
        endif;
    }

    public function onSpotPayment($reservation, $totalAmount, $discount_amount)
    {
        $transaction = new BookingTransaction();
        $transaction->amount = $totalAmount;
        $transaction->discounted_amount = $discount_amount ? $discount_amount : NULL;
        $transaction->reservation_id = $reservation->id;
        $transaction->paid_by = 'Cash';
        $transaction->is_payment_done = false;

        if ($transaction->save()) :

            Mail::to('info@sscuisineurs.com')->send(new ReservationMail($reservation, 'New Reservation'));
            Mail::to($reservation->email)->send(new ReservationMail($reservation, 'Reservation Success'));

            return response()->json($reservation, 200);
        endif;
    }

    public function SSLCommerz($reservation, $totalAmount, $discount_amount)
    {
        $transaction = new BookingTransaction();
        $transaction->amount = $totalAmount;
        $transaction->discounted_amount = $discount_amount;
        $transaction->reservation_id = $reservation->id;
        $transaction->is_payment_done = false;
        $transaction->save();

        $post_data = [
            'store_id' => 'sscuisineurslive',
            'store_passwd' => '5FE178BC8820186703',
            'total_amount' => $discount_amount ? $discount_amount : $totalAmount,
            'tran_id' => $transaction->refresh()->id,
            'currency' => 'BDT',
            'product_category' => 'Reservation Amount Pay',
            'success_url' => 'http://sscuisineurs.com/sslcommerz/success',
            'fail_url' => 'http://sscuisineurs.com/sslcommerz/fail',
            'cancel_url' => 'http://sscuisineurs.com/sslcommerz/cancel',
            'ipn_url' => 'http://sscuisineurs.com/sslcommerz/ipn',
            'emi_option' => 0,
            'cus_name' => $reservation->name,
            'cus_email' => $reservation->email,
            'cus_city' => $reservation->city,
            'cus_country' => $reservation->country,
            'cus_add1' => $reservation->address,
            'cus_phone' => $reservation->phone,
            'shipping_method' => 'NO',
            'num_of_item' => 1,
            'product_name' => "Reservation Amount Pay",
            'product_profile' => 'non-physical-goods',
            'value_a' => $reservation->id,
        ];

        $client = new Client();
        $response = $client->post('https://securepay.sslcommerz.com/gwprocess/v4/api.php', ['form_params' => $post_data, 'verify' => false])->getBody();

        $transaction->payment_initiation_server_response = $response->getContents();
        $transaction->save();

        return $transaction->payment_initiation_server_response;
    }

    public function SSLSuccess(Request $request)
    {
        $transaction = BookingTransaction::find($request->get('tran_id'));
        $transaction->payment_validation_server_response = $request->all();
        $transaction->paid_by = 'Online Payment';
        $transaction->status = 'SUCCESS';
        $transaction->is_payment_done = true;

        $val_id = urlencode($_POST['val_id']);
        $store_id = urlencode("sscuisineurslive");
        $store_passwd = urlencode("5FE178BC8820186703");
        $requested_url = ("https://securepay.sslcommerz.com/validator/api/validationserverAPI.php?val_id=" . $val_id . "&store_id=" . $store_id . "&store_passwd=" . $store_passwd . "&v=1&format=json");

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $requested_url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

        $result = curl_exec($handle);

        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if ($code == 200 && !(curl_errno($handle))) {

            # TO CONVERT AS ARRAY
            # $result = json_decode($result, true);
            # $status = $result['status'];

            # TO CONVERT AS OBJECT
            $result = json_decode($result);

            # TRANSACTION INFO
            $status = $result->status;
            $tran_date = $result->tran_date;
            $tran_id = $result->tran_id;
            $val_id = $result->val_id;
            $amount = $result->amount;
            $store_amount = $result->store_amount;
            $bank_tran_id = $result->bank_tran_id;
            $card_type = $result->card_type;

            # EMI INFO
            $emi_instalment = $result->emi_instalment;
            $emi_amount = $result->emi_amount;
            $emi_description = $result->emi_description;
            $emi_issuer = $result->emi_issuer;

            # ISSUER INFO
            $card_no = $result->card_no;
            $card_issuer = $result->card_issuer;
            $card_brand = $result->card_brand;
            $card_issuer_country = $result->card_issuer_country;
            $card_issuer_country_code = $result->card_issuer_country_code;

            # API AUTHENTICATION
            $APIConnect = $result->APIConnect;
            $validated_on = $result->validated_on;
            $gw_version = $result->gw_version;
        } else {
            $request->session()->flash('payment_failed', 'Failed to connect with SSLCOMMERZ');
            return redirect()->route('reservation');
        }

        if ($transaction->save()) {
            $reservation = $transaction->reservation;
            $reservation->payment_type = 'Card';
            $reservation->save();
            Mail::to('info@sscuisineurs.com')->send(new PaidReservationMail($reservation, 'New Reservation'));
            Mail::to($reservation->email)->send(new PaidReservationMail($reservation, 'Reservation Success'));
            $request->session()->flash('payment_done', 'Your transaction and reservation is successfully completed. We will mail you soon. Your code number is '.$reservation->random.' (Please remember this code number when arrive).');
            return redirect()->route('reservation');
        }
    }

    public function SSLFailed(Request $request)
    {
        $transaction = BookingTransaction::find($request->get('tran_id'));
        $transaction->payment_validation_server_response = $request->all();
        $transaction->status = 'FAILED';
        $transaction->is_payment_done = false;
        $transaction->paid_by = 'Online Payment';

        if ($transaction->save()) :
            $request->session()->flash('payment_failed', 'Failed to connect with SSLCOMMERZ');
            return redirect()->route('reservation');
        endif;
    }
    public function SSLCancel(Request $request)
    {
        $transaction = BookingTransaction::find($request->get('tran_id'));
        $transaction->payment_validation_server_response = $request->all();
        $transaction->status = 'CANCELLED';
        $transaction->is_payment_done = false;

        $request->session()->flash('payment_failed', 'Failed to connect with SSLCOMMERZ');
        return redirect()->route('reservation');
    }
    public function SSLIpn(Request $request)
    {
        $transaction = BookingTransaction::find($request->get('tran_id'));
        $transaction->payment_validation_server_response = $request->all();
        $transaction->save();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPass(reservation $reservation, Request $request)
    {
        return view('backend.pages.reservation.getPass', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(reservation $reservation, Request $request)
    {
        $reservation->name = $request->name;
        $reservation->email = $request->email;
        $reservation->phone = $request->phone;
        $reservation->payment_status = $request->payment_status;
        $reservation->arrived = $request->arrived;

        $reservation->save();
        Toastr::success('Reservation Updated');

        return back();
    }


    public function paid_reservation_update(reservation $reservation, Request $request)
    {
        $reservation->arrived = $request->arrived;
        
        $reservation->bookingTransation->is_payment_done = true;
        $reservation->bookingTransation->save();
        $reservation->save();
        Toastr::success('Reservation Updated');
        return back();
    }

    public function not_paid_reservation_update(reservation $reservation, Request $request)
    {
        $reservation->bookingTransation->is_payment_done = $request->payment_status;
        $reservation->bookingTransation->status = 'SUCCESS';
        $reservation->payment_type = $request->payment_type;
        if ($reservation->bookingTransation->save()) :
            $reservation->arrived = $request->arrived;
            if ($request->discount_price != 0) {
                $bogo = new Bogo();
                if ($request->ebl_card != NULL) {
                    $bogo->card_number = $request->ebl_card;
                    $bogo->reservation_id = $request->reservation_id;
                    $bogo->reservation_date = $request->reservation_date;
                    $bogo->save();
                    $reservation->bookingTransation->discounted_amount = $request->discount_price;
                    $reservation->bookingTransation->save();
                    $reservation->discount_type = 'EBL';
                    $reservation->discount_percent = $request->custom_discount;
                } else if ($request->brac_card != NULL) {
                    $bogo->card_number = $request->brac_card;
                    $bogo->reservation_id = $request->reservation_id;
                    $bogo->reservation_date = $request->reservation_date;
                    $bogo->save();
                    $reservation->bookingTransation->discounted_amount = $request->discount_price;
                    $reservation->bookingTransation->save();
                    $reservation->discount_type = 'Brac';
                    $reservation->discount_percent = $request->custom_discount;
                } else if ($request->amex_card_number != NULL) {
                    $bogo->card_number = $request->amex_card_number;
                    $bogo->reservation_id = $request->reservation_id;
                    $bogo->reservation_date = $request->reservation_date;
                    $bogo->save();
                    $reservation->bookingTransation->discounted_amount = $request->discount_price;
                    $reservation->bookingTransation->save();
                    $reservation->discount_type = 'AmEx';
                    $reservation->discount_percent = $request->custom_discount;
                } else if ($request->custom_discount != NULL) {
                    $reservation->bookingTransation->discounted_amount = $request->discount_price;
                    $reservation->bookingTransation->save();
                    $reservation->discount_type = 'Authority';
                    $reservation->discount_percent = $request->custom_discount;
                }
            }

            $reservation->save();
            Toastr::success('Reservation Updated');
            return back();
        endif;
    }

    public function not_arrived_update(reservation $reservation, Request $request)
    {
        return 1;
        $reservation->arrived = $request->arrived;

        $reservation->save();
        Toastr::success('Reservation Updated');

        return back();
    }

    //update date
    public function update_date($id, Request $request){
        $reservation = reservation::find($id);
        $reservation->booking_date = $request->reservation_date;
        if( $reservation->save() ){
            Toastr::success('Reservation Updated');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = reservation::find($id);

        $reservation->is_delete = true;
        $reservation->bookingTransation->is_delete = true;

        if ($reservation->save()) :
            $reservation->bookingTransation->save();
            Toastr::success('Reservation Deleted');
            return back();
        endif;
    }

    public function online_destroy($id)
    {
        $reservation = reservation::find($id);

        $reservation->is_delete = true;
        $reservation->bookingTransation->is_delete = true;

        if ($reservation->save()) :
            $reservation->bookingTransation->save();
            Toastr::success('Reservation Deleted');
            return redirect()->route('paid');
        endif;
    }

    public function onspot_destroy($id)
    {
        $reservation = reservation::find($id);

        $reservation->is_delete = true;
        $reservation->bookingTransation->is_delete = true;

        if ($reservation->save()) :
            $reservation->bookingTransation->save();
            Toastr::success('Reservation Deleted');
            return redirect()->route('notPaid');
        endif;
    }

    public function confirmed()
    {
        $reservations = reservation::orderBy('id', 'desc')->where('is_delete', 0)->get();
        return view('backend.pages.history.delivered.index', compact('reservations'));
    }
}
