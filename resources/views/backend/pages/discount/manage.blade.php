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
                            Discounts & Bogo
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
          
            <!-- add row start -->
            <div class="row add-row">
                <div class="col-md-12 text-right">
                    @if( Auth::user()->role == 1 )
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Add
                    </button>
                    @endif
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLabel">Event</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('discount.add') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                    
                                    <div class="row">   

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Code</label>
                                                <input type="text" class="form-control" name="code" >                                 
                                            </div>                                      
                                        </div>  

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <select name="type"  class="form-control">
                                                    <option value="GPStar">GpStar</option>
                                                    <option value="CityGem">CityGem</option>
                                                    <option value="AmEx"  >AmEx Card</option>
                                                    <option value="EBL" >EBL Card</option>
                                                    <option value="BracBank" >Brac Bank</option>
                                                    <option value="MTB" >MTB</option>
                                                </select>                         
                                            </div>                                      
                                        </div>  
                                                                      
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Add</button>                                    
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
            <div class="row">

                
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td> Code Number</td>
                                <td>Type</td>
                                @if( Auth::user()->role == 1 )
                                <td>action</td>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($all_discount as $key => $discount)
                            <tr>
                                <th>{{ $key + 1 }}</th>

                                <td>
                                   {{$discount->code}}
                                </td>

                                <td>
                                    <p class="badge badge-success">{{$discount->type}}</p>
                                 </td>
                
                                @if( Auth::user()->role == 1 )
                                <td>
                                
                                <!-- edit start -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit{{ $discount->id }}">
                                    edit
                                </button>
                                <div class="modal fade" id="edit{{ $discount->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLabel">event</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('discount.update', $discount->id) }}" method="post">
                                                    @csrf
                                                        
                                                        <div class="row">   
                    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Code</label>
                                                                    <input type="text" class="form-control" value="{{ $discount->code }}" name="code" >                                 
                                                                </div>                                      
                                                            </div>  
                    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Type</label>
                                                                    <select name="type"  class="form-control">
                                                                        <option value="GPStar"  
                                                                        @if( $discount->type == 'GPStar' ) selected @endif >GpStar</option>
                                                                        <option value="CityGem" @if( $discount->type == 'CityGem' ) selected @endif >CityGem</option>
                                                                        <option value="AmEx"
                                                                        @if( $discount->type == 'AmEx' ) 
                                                                        selected 
                                                                        @endif
                                                                        >AmEx Card</option>
                                                                        <option value="EBL" 
                                                                        @if( $discount->type == 'EBL' ) 
                                                                        selected 
                                                                        @endif
                                                                        >EBL Card</option>
                                                                        <option value="EBL" 
                                                                        @if( $discount->type == 'BracBank' ) 
                                                                        selected 
                                                                        @endif
                                                                        >Brac Bank</option>
                                                                        <option value="MTB" 
                                                                        @if( $discount->type == 'MTB' ) 
                                                                        selected 
                                                                        @endif
                                                                        >MTB</option>
                                                                    </select>                         
                                                                </div>                                      
                                                            </div>  
                                                                                          
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary">Update</button>                                    
                                                        </div>
                                                    </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- edit end -->

                                <!-- delete start -->
                                 <!-- delete start -->
                                 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete{{ $discount->id }}">
                                    Delete
                                </button>
                                <div class="modal fade" id="delete{{ $discount->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLabel">Are you sure want to delete this code ?</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('discount.delete', $discount->id) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">yes</button>
                                                </form>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- delete end -->

                                </td>
                                @endif
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