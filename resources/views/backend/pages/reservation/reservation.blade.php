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
                                   Make a reservation
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
               </ul>
          </div>
          @endif

          @if( session()->has('code') )
          <div class="alert alert-success">
               Your code is {{ session()->get('code') }}
          </div>
          @endif

               <!-- manage row start -->
               <form action="{{ route('reservation.make') }}" method="post">
                    @csrf
                    <div class="row">

                         <div class="col-md-6">
                              <div class="form-group">
                                   <label style="text-align:left;display: block;">Booking Date</label>
                                   <input type="date" name="booking_date" id="start_date" placeholder="Date" class="form-control" max="2021-03-31" />
                              </div>
                              <div class="form-group">
                                   <label style="text-align:left;display: block;">Select Time</label>
                                   <select id="menu_id" name="menu_id" class="form-control">
                                        <option>Please Select Your Time</option>
                                        @foreach( App\Models\category::all() as $category )
                                        <option value="{{ $category->id }}" id="menu_price" data-price="{{ $category->price }}">
                                             {{ $category->name }} ( {{ $category->price }} BDT )
                                        </option>
                                        @endforeach
                                   </select>
                              </div>
                              <div class="form-group">
                                   <label style="text-align:left;display: block;">Number of Adult</label>
                                   <input type="number" min="1" id="adult" name="adult" placeholder="Example- 1/2" oninput="updatePrice()" class="form-control" />
                              </div>
                              <div class="form-group">
                                   <label style="text-align:left;display: block;">Child if any ( Below 12 years )</label>
                                   <input type="number" id="child_132" min="0" value="0" name="child_under_132_cm" placeholder="Example- 0/1" oninput="updatePrice()" class="form-control" />
                              </div>
                              <div class="form-group">
                                   <label style="text-align:left;display: block;">Child if any ( Below 5 years )</label>
                                   <input type="number" min="0" value="0" name="child_under_120_cm" id="child_132" placeholder="Example- 0/1" class="form-control" />
                              </div>
                              <div class="form-group">

                              </div>
                         </div>

                         <div class="col-md-6">
                              <div class="form-group">
                                   <label style="text-align:left;display: block;">Name</label>
                                   <input type="text" name="name" placeholder="Name" class="form-control" />
                              </div>
                              <div class="form-group">
                                   <label style="text-align:left;display: block;">Phone</label>
                                   <input type="text" name="phone" placeholder="01*********" class="form-control" />
                              </div>
                              <div class="form-group">
                                   <label style="text-align:left;display: block;">Email ( Please use a valid email address
                                        )</label>
                                   <input type="email" name="email" class="form-control" placeholder="Email" />
                              </div>
                              <div class="form-group">
                                   <label style="text-align:left;display: block;">City</label>
                                   <input type="text" name="city" placeholder="City" class="form-control" />
                              </div>
                              <div class="form-group">
                                   <label style="text-align:left;display: block;">Country</label>
                                   <select name="country" class="form-control">
                                        <option value="Bangladesh">Bangladesh</option>
                                   </select>
                              </div>
                         </div>
                         <div class="col-md-12">
                              <label style="text-align:left;display: block;">Address</label>
                              <textarea class="form-control" placeholder="Address" name="address" rows="3"></textarea>
                         </div>

                         <div class="col-md-12">
                              <label style="text-align:left;display: block;">Message</label>
                              <textarea class="form-control" placeholder="Message" name="message" rows="3"></textarea>
                         </div>

                         <div class="col-md-12" style="margin-top: 30px">
                              <p>payment method</p>
                              <div class="form-check">
                                   <div>
                                        <input class="form-check-input" type="radio" checked name="payment_method" id="on_spot_payment" value="0">
                                        <label class="form-check-label" for="on_spot_payment">
                                             On Spot Payment
                                        </label>
                                   </div>
                              </div>
                         </div>

                         <div class="col-md-12" style="margin-top: 30px;">
                              <button type="submit">Make Reservation</button>
                         </div>

                    </div>
               </form>
               <!-- manage row end -->

          </section>
          <!-- dashbaord statistics seciton end -->

     </div>
</div>
<!-- main content end -->
@endsection