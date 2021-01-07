@extends('backend.template.layout')

@section('body-content')
<!-- main content start -->
<div class="main-content">
    <div class="container-fluid">

        <!-- page indicator start -->
        <section class="page-indicator">
            <div class="row">
                <div class="col-md-12">
                    <ul>
                        <li>
                            <i class="fas fa-bars"></i>
                        </li>
                        <li>
                            Date wise person count And Reservation
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- page indicator end -->

        <!-- dashbaord statistics seciton start -->
        <section class="statistics">

            @if ($errors->any())
            <div class="alert alert-danger" style="background: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    <a href="https://pixlr.com/x/" target="__blank">Click here to reduce image size</a>
                </ul>
            </div>
            @endif

            <!-- add row start -->
            <div class="row add-row">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Find
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">gallery</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('total.person.count') }}" method="get">
                                        @csrf

                                        <div class="row">
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Date</label>
                                                    <input type="date" required class="form-control" name="date">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Check</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- add row end -->


            <!-- manage row start -->
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-12">
                    <h2>Date : {{ \Carbon\Carbon::parse($date)->toDateString() }}</h2>
                    @foreach( $day->category as $cat )
                    <h2>{{ $cat->name  }} :
                        @php
                            $all_r = App\Models\reservation::whereDate('booking_date',$date)->where('is_delete', false)->where('category_id', $cat->id)->get();
                            $sum = $all_r->sum('adult') + $all_r->sum('child_under_132_cm') +  $all_r->sum('child_under_120_cm');
                        @endphp
                        {{ $sum }}
                    </h2>
                    @endforeach
                    <h2>Total Adult Reserved Till Now : {{ $adult }}</h2>
                    <h2>Total Child Below 12 Years Reserved Till Now : {{ $child_below_12 }}</h2>
                    <h2>Total Child Below 5 Years Reserved Till Now : {{ $child_below_5 }}</h2>
                    <h2>Total Person Till Now : {{ $total_person }}</h2>
                    @php
                        $total_amount_book = 0;
                        foreach($reservations as $reservation){
                            $total_amount_book += $reservation->bookingTransation->discounted_amount ? $reservation->bookingTransation->discounted_amount : $reservation->bookingTransation->amount;
                        }
                    @endphp
                    @if( Auth::user()->role == 1 || Auth::user()->role == 0 || Auth::user()->role == 3 )
                    <h2>Total Reservation Amount : {{ $total_amount_book }} BDT</h2>
                    <h2>Total Payment Done : {{ $total_payment_done}}</h2>
                    <h2>Total On Spot Payment : {{$on_spot_payment}} </h2>
                    <h2>Total Online Payment : {{$online_payment}} </h2>
                    @endif
                    
                </div>
            </div>
            <!-- manage row end -->

        </section>
        <!-- dashbaord statistics seciton end -->
        
        <!-- dashbaord statistics seciton start -->
        <section class="statistics">



            <!-- manage row start -->
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <td>R. Date</td>
                                <td>name</td>
                                <td>Grand Total</td>
                                <td>Grand Total After Discount</td>
                                <td>phone</td>
                                <td>Barcode</td>
                                <td>Payment Status</td>
                                <td>Arrival</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @foreach($reservations as $reservation)
                            <tr>
                                <td>
                                    {{$reservation->booking_date}} 
                                </td>
                                <td>
                                    {{$reservation->name}}
                                </td>
                                <td>
                                    {{$reservation->bookingTransation->amount}} BDT
                                </td>
                                <td>
                                    @if( $reservation->bookingTransation->discounted_amount )
                                        {{ $reservation->bookingTransation->discounted_amount }} BDT ( {{ $reservation->discount_type ? ( $reservation->discount_type == 'Brac' ? 'Brac Bank' : $reservation->discount_type ) : 'No Discount'  }} )
                                        @if( $reservation->discount_percent ) ( {{ $reservation->discount_percent }}% ) @endif
                                    @else
                                        No Discount
                                    @endif
                                </td>
                                <td>
                                    {{$reservation->phone}}
                                </td>
                                <td>
                                    {{$reservation->random}}
                                </td>
                                <td>
                                    @if ($reservation->bookingTransation->is_payment_done == true)
                                    <p class="badge badge-success">Paid @if($reservation->payment_type) ({{ $reservation->payment_type }}) @endif </p>
                                    @else
                                    <p class="badge badge-danger">Not Paid</p>
                                    @endif
                                </td>

                                <td>
                                    @if ($reservation->arrived==0)
                                    <p class="badge badge-danger">Not Arrived</p>
                                    @else
                                    <p class="badge badge-success">Arrived</p>
                                    @endif

                                </td>

                                <td>

                                    <!-- edit start -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#edit{{ $reservation->id }}">
                                        View
                                    </button>
                                    <div class="modal fade" id="edit{{ $reservation->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">reservation</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('update.date', $reservation->id) }}" method="post">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Name </label>
                                                                    <p>{{$reservation->name}}</p>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Email </label>
                                                                    <p style="text-transform: lowercase;">
                                                                        {{$reservation->email}}</p>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Phone </label>
                                                                    <p>{{$reservation->phone}}</p>
                                                                </div>
                                                            </div>
                                                            
                                                            @if( Auth::user()->role == 1 )
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Reservation Date </label>
                                                                    <input type="date" class="form-control" name="reservation_date" value="{{$reservation->booking_date}}" >
                                                                </div>
                                                            </div>
                                                            @endif
    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Reservation Date </label>
                                                                    <p>{{$reservation->booking_date}}</p>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Menu Item</label>
                                                                    <p>{{$reservation->category->name}}</p>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Menu Item Price</label>
                                                                    <p>{{$reservation->category_price}} BDT</p>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Adult</label>
                                                                    <p>{{$reservation->adult}} </p>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Child Below 12 years old</label>
                                                                    <p>{{$reservation->child_under_132_cm}}</p>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Child Below 5 years old</label>
                                                                    <p>{{$reservation->child_under_120_cm}}</p>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Address</label>
                                                                    <p>{{$reservation->address}}</p>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Message</label>
                                                                    <p>{{$reservation->message}}</p>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Grand Total</label>
                                                                    <p>{{$reservation->bookingTransation->amount}} BDT
                                                                    </p>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Grand Total After Discount</label>
                                                                    <p>{{ $reservation->bookingTransation->discounted_amount ? $reservation->bookingTransation->discounted_amount : 'You have no discount in' }}
                                                                        BDT</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Discount From</label>
                                                                    <p class="badge badge-success">
                                                                        {{ $reservation->discount_type ? ( $reservation->discount_type == 'Brac' ? 'Brac Bank' : $reservation->discount_type ) : 'N/A'  }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Payment Status</label>
                                                                    @if ($reservation->bookingTransation->is_payment_done ==
                                                                    true)
                                                                    <p class="badge badge-success">Paid</p>
                                                                    @else
                                                                    <p class="badge badge-danger">Not Paid</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Payment Method</label>
                                                                    <p class="badge badge-success">
                                                                        @if( $reservation->bookingTransation->paid_by == 'Cash' )
                                                                            On Spot Payment
                                                                        @else
                                                                            Online Payment
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Is Arrived ?</label>
                                                                    @if( $reservation->arrived == 1 )
                                                                    <p class="badge badge-success">Arrived</p>
                                                                    @else
                                                                    <p class="badge badge-danger">Not Arrived</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if( Auth::user()->role == 1 )
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button type="submit" class="btn btn-success">Update</button>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- edit end -->

                                    <!-- delete start -->
                                    @if( Auth::user()->role == 1 || Auth::user()->role == 0 || Auth::user()->role == 3)
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#delete{{ $reservation->id }}">
                                        Cancel
                                    </button>
                                    @endif
                                    <div class="modal fade" id="delete{{ $reservation->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">Are you sure want to cancel this reservation?
                                                    </h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('reservationDelete', $reservation->id) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">yes</button>
                                                    </form>
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- delete end -->

                                </td>


                            </tr>
                            @php
                            $i++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- manage row end -->

        </section>
        <!-- dashbaord statistics seciton end -->

    </div>
</div>
<!-- main content end -->
@endsection