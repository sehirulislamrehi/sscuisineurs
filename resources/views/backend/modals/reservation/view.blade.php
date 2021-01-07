<div class="modal-content">
     <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">View Reservation Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
          </button>
     </div>
     <div class="modal-body">
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
                              {{ $reservation->bookingTransation->paid_by }}</p>
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
     </div>
     <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     </div>
</div>