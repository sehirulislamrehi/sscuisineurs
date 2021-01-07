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
                            Edit
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- page indicator end -->

        <!-- dashbaord statistics seciton start -->
        <section class="statistics">



            <!-- manage row start -->
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <div class="modal-body">
                        <form action="{{ route('paid_reservation_update', $reservation->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 style="color:white">Transaction id: #{{ $reservation->bookingTransation->id }}</h2>
                                </div>
                            </div>

                            <div class="row">
                                <!-- left part start -->
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Name </label>
                                        <p>{{$reservation->name}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Email </label>
                                        <p style="text-transform: lowercase;">
                                            {{$reservation->email}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Phone </label>
                                        <p>{{$reservation->phone}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Reservation Date </label>
                                        <p>{{$reservation->booking_date}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Menu Item</label>
                                        <p>{{$reservation->category->name}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Menu Item Price</label>
                                        <p>{{$reservation->category_price}} BDT</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <p>{{$reservation->address}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Message</label>
                                        <p>{{$reservation->message}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Adult</label>
                                        <p>{{$reservation->adult}} </p>
                                    </div>

                                    <div class="form-group">
                                        <label>Child if any ( Below 12 years )</label>
                                        <p>{{$reservation->child_under_132_cm}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Child if any ( Below 5 years )</label>
                                        <p>{{$reservation->child_under_120_cm}}</p>
                                    </div>



                                </div>
                                <!-- left part end -->

                                <!-- middle part start -->
                                <div class="col-md-4 col-12">

                                    <div class="form-group">
                                        <label>Code Number </label>
                                        <p>{{$reservation->random}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Grand Total</label>
                                        <p>{{$reservation->bookingTransation->amount}} BDT
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label>Grand Total After Discount</label>
                                        <p><span
                                                id="bogo_discount_price">{{ $reservation->bookingTransation->discounted_amount ? $reservation->bookingTransation->discounted_amount : 'You have no discount in' }}</span>
                                            BDT</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Discount From</label>
                                        <p class="badge badge-success">
                                            {{ $reservation->discount_type ? ( $reservation->discount_type == 'Brac' ? 'Brac Bank' : $reservation->discount_type ) : 'N/A'  }} @if( $reservation->discount_percent ) ( {{ $reservation->discount_percent }}% ) @endif
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label>Payment Method </label>
                                        <p class="badge badge-success">
                                            @if( $reservation->bookingTransation->paid_by == 'Cash' )
                                            On Spot Payment
                                            @else
                                            
                                            Online Payment  
                                            @endif
                                        </p>
                                    </div>

                                    <div class="form-group">
                                        <label>Validate Bogo Card For (EBL and Brac Bank)</label>
                                        <input type="text" value="" class="form-control validate_card"
                                            placeholder="Card Number">
                                        <button type="button" data-method="GET" style="margin-top: 15px"
                                            class="validate_bogo">Validate</button>
                                    </div>

                                </div>
                                <!-- middle part end -->

                                <!-- right part start -->
                                <div class="col-md-4 col-12">


                                    <div class="form-group">
                                        <label>Payment status *</label>
                                        @if( $reservation->bookingTransation->is_payment_done == 1 )
                                            <p class="alert alert-success">Paid @if($reservation->payment_type) ({{ $reservation->payment_type }}) @endif 
                                            
                                            </p>
                                        @else
                                        <p class="alert alert-danger">
                                            This person did not pay. Please validate him carefully. For more check merchant panel transaction
                                        </p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Guest Arrived *</label>
                                        <select name='arrived' class="form-control">
                                            <option value="0" {{ ( $reservation->arrived == 0) ? 'selected' : '' }}>
                                                Not Arrived</option>
                                            <option value="1" {{ ( $reservation->arrived == 1) ? 'selected' : '' }}>
                                                Arrived</option>

                                        </select>
                                    </div>
                                    @if( $reservation->payment_method == 0 )
                                    <div class="form-group">
                                        <label>please Select Payment Type *</label>
                                        <select name='payment_type' class="form-control">
                                            <option value="" required>Please select payment type</option>
                                            <option value="Cash"
                                                {{ ( $reservation->payment_type == 'Cash') ? 'selected' : '' }}>
                                                Cash</option>
                                            <option value="Card"
                                                {{ ( $reservation->payment_type == 'Card') ? 'selected' : '' }}>
                                                Card</option>

                                        </select>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        @if( $reservation->arrived == true &&
                                        $reservation->bookingTransation->is_payment_done == true && $reservation->payment_type == 'Card' || $reservation->payment_type == 'Cash' )
                                        <div class="btn-group">
                                            <a href="{{ route('entryPass', $reservation->id) }}" target="____blank"
                                                class="btn btn-success btn-sm">Generate Cash Memo</a>
                                        </div>
                                        @endif
                                    </div>

                                </div>
                                <!-- right part end -->
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- manage row end -->

            <div class="row">
                <div class="col-md-12 col-12">
                    <!-- delete start -->
                    <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#delete{{ $reservation->id }}">
                        Cancel Reservation
                    </button>
                    <div class="modal fade" id="delete{{ $reservation->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">reservation Cancel
                                    </h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('online.reservationDelete', $reservation->id) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success">yes</button>
                                    </form>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- delete end -->
                </div>
            </div>

        </section>
        <!-- dashbaord statistics seciton end -->

    </div>
</div>
<!-- main content end -->
@endsection