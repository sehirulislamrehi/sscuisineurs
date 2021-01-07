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
                            Online Payment
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
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <td>Tran Id</td>
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
                                    #{{$reservation->bookingTransation->id}}
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
                                    <p class="badge badge-success">Paid @if($reservation->payment_type) ({{ $reservation->payment_type }}) @endif
                                    
                                    </p>
                                    @else
                                    <p class="alert alert-danger">Not paid. Validate this person carefully!</p>
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
                                    <a href="{{ route('online.reservation.edit', $reservation->id ) }}" target="___blank" class="btn btn-primary">
                                        View
                                    </a>

                                    <!-- delete start -->
                                    @if( Auth::user()->role == 1 || Auth::user()->role == 3)
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