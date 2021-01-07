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
                            <i class="fas fa-home"></i>
                        </li>
                        <li>
                            dashboard
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- page indicator end -->
    
        <!--
            Role 0 = user
            Role 1 = admin
            Role 2 = call center
            Role 3 = hr
        -->

        <!-- dashbaord statistics seciton start -->
        <section class="statistics">
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-12">
                    <h2>You have {{ $unread_message->count() }} new messages</h2>
                </div>
            </div>
            <div class="row">
                
                @if( Auth::user()->role !=  2 )
                <!--- stat card start -->
                <div class="col-md-3">
                    <a href="#">
                        <div class="stat-card">
                            <i class="fas fa-history"></i>
                            <h3>Total Menu</h3>
                            <p>{{ $total_menu->count() }}</p>
                        </div>
                    </a>                
                </div>
                <!--- stat card end -->
                <!--- stat card start -->
                <div class="col-md-3">
                    <a href="#">
                        <div class="stat-card">
                            <i class="fas fa-utensils"></i>
                            <h3>Total Food</h3>
                            <p>{{ $all_food->count() }}</p>
                        </div>
                    </a>                
                </div>
                <!--- stat card end -->
                @endif
                <!--- stat card start -->
                @if( Auth::user()->role == 1 || Auth::user()->role == 3 )
                <div class="col-md-3">
                    <a href="#">
                        <div class="stat-card">
                            <i class="fas fa-money-bill"></i>
                            <h3>Total Amount Sale</h3>
                            <p>{{ $total_amount_sale }} BDT</p>
                        </div>
                    </a>                
                </div>
                @endif
                <!--- stat card end -->

                <!--- stat card start -->
                @if( Auth::user()->role == 1 || Auth::user()->role == 3 )
                <div class="col-md-3">
                    <a href="{{route('download_today')}}">
                        <div class="stat-card">
                            <i class="fas fa-money-bill"></i>
                            <h3>Today's Sale</h3>
                            <p>{{ $total_today_sale }} BDT</p>
                        </div>
                    </a>                
                </div>
                @endif
                <!--- stat card end -->

                <!--- stat card start -->
                @if( Auth::user()->role == 1 || Auth::user()->role == 3 )
                <div class="col-md-3">
                    <a href="#">
                        <div class="stat-card">
                            <i class="fas fa-money-bill"></i>
                            <h3>Last One month Sale</h3>
                            <p>{{ $total_one_month }} BDT</p>
                        </div>
                    </a>                
                </div>
                @endif
                <!--- stat card end -->

                <!--- stat card start -->
                @if( Auth::user()->role == 1 || Auth::user()->role == 3 )
                <div class="col-md-3">
                    <a href="#">
                        <div class="stat-card">
                            <i class="fas fa-money-bill"></i>
                            <h3>Last One Year Sale</h3>
                            <p>{{ $total_one_year }} BDT</p>
                        </div>
                    </a>                
                </div>
                @endif
                <!--- stat card end -->

                <!--- stat card start -->
                @if( Auth::user()->role !=  2 || Auth::user()->role == 3)
                <div class="col-md-3">
                    <a href="#">
                        <div class="stat-card">
                            <i class="fas fa-money-bill"></i>
                            <h3>Total Reservation</h3>
                            <p>{{ $total_reservation->count() }}</p>
                        </div>
                    </a>                
                </div>
                <!--- stat card end -->

                <!--- stat card start -->
                <div class="col-md-3">
                    <a href="#">
                        <div class="stat-card">
                            <i class="fas fa-money-bill"></i>
                            <h3>Total Payment Done</h3>
                            <p>{{ $total_sale->count() }}</p>
                        </div>
                    </a>                
                </div>
                <!--- stat card end -->
                @endif
                
                <!--- stat card start -->
                @if( Auth::user()->role == 0 || Auth::user()->role == 1 || Auth::user()->role == 3 )
                <div class="col-md-3">
                    <a href="{{ route('date.person.count') }}">
                        <div class="stat-card">
                            <i class="fas fa-money-bill"></i>
                            <h3>Date Wise Person Count</h3>
                        </div>
                    </a>                
                </div>
                @endif
                <!--- stat card end -->


            </div>
        </section>
        <!-- dashbaord statistics seciton end -->

    </div>
</div>
<!-- main content end -->
@endsection