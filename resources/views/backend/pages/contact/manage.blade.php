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
                            Contact
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

            <!-- flash message row start -->
            {{-- <div class="row">
                <div class="col-md-12">
                    @if( session()->has('create') )
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Congratulation!</strong> {{ session()->get('create') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif 
                    @if( session()->has('createFailed') )
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Congratulation!</strong> {{ session()->get('createFailed') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif 
                    @if( session()->has('update') )
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Congratulation!</strong> {{ session()->get('update') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif 
                    @if( session()->has('delete') )
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Congratulation!</strong> {{ session()->get('delete') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif                
                </div>
            </div> --}}
            <!-- flash message row end -->

            <!-- add row start -->
            <div class="row add-row">
                <div class="col-md-12 text-right">
                    <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">-->
                    <!--    Add new Contact-->
                    <!--</button>-->

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLabel">Contact</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('contactStore') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="text" class="form-control" name="phone">                            
                                            </div>                                      
                                        </div>    
                                                                      
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                
                                                <textarea name="address" class="form-control" rows="5" ></textarea>                                  
                                            </div>                                      
                                        </div>    
                                                                      
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email">                              
                                            </div>                                      
                                        </div>    
                                                                      
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Website</label>
                                                <input type="text" class="form-control" name="website">                                  
                                            </div>                                      
                                        </div>    
                                                                      
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Facebook Link</label>
                                                <input type="text" class="form-control" name="facebook">                                   
                                            </div>                                      
                                        </div>    
                                                                      
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Youtube Link</label>
                                                <input type="text" class="form-control" name="youtube">                                 
                                            </div>                                      
                                        </div>    
                                                                      
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Instagram</label>
                                                <input type="text" class="form-control" name="instagram">                                  
                                            </div>                                      
                                        </div>    
                                                                      
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Twitter</label>
                                                <input type="text" class="form-control" name="twitter">                                 
                                            </div>                                      
                                        </div>    
                                                                      
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About info</label>
                                                <textarea name="info" class="form-control" rows="5"></textarea>                                 
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
                                <td>Address</td>
                                <td>phone</td>
                                <td>email</td>
                                <td>website</td>
                                <td>About Info</td>
                               
                                <td>action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($contacts as $contact)
                            <tr>
                                <th>{{ $i }}</th>
                                <td> {!!$contact->address!!} </td>
                                <td> {!!$contact->phone!!} </td>
                                <td> {!!$contact->email!!} </td>
                                <td> {!!$contact->website!!} </td>
                                <td> {{Str::limit($contact->info,20)}} </td>
                                <td>
                                
                                <!-- edit start -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit{{ $contact->id }}">
                                    edit
                                </button>
                                <div class="modal fade" id="edit{{ $contact->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel">contact</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('contactUpdate', $contact->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                               
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Phone Number</label>
                                                        <input type="text" class="form-control" name="phone" value="{{ $contact->phone }}">                                
                                                    </div>                                      
                                                </div>    
                                                                              
                                            </div>
        
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <input type="text" class="form-control" name="address" value="{{ $contact->address }}"> 
                                                                                      
                                                    </div>                                      
                                                </div>    
                                                                              
                                            </div>
        
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Email</label>

                                                        <input type="email" class="form-control" name="email" value="{{ $contact->email }}">                               
                                                    </div>                                      
                                                </div>    
                                                                              
                                            </div>
        
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Website</label>
                                                        <input type="text" class="form-control" name="website" value="{{ $contact->website }}"> 
                                                                                        
                                                    </div>                                      
                                                </div>    
                                                                              
                                            </div>
        
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Facebook Link</label>
                                                        
                                                    <input type="text" class="form-control" name="facebook" value="{{$contact->facebook}}">                                 
                                                    </div>                                      
                                                </div>    
                                                                              
                                            </div>
        
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Youtube Link</label>
                                                        
                                                        <input type="text" class="form-control" name="youtube" value="{{$contact->youtube}}">                                 
                                                    </div>                                      
                                                </div>    
                                                                              
                                            </div>
        
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Instagram</label>
                                                        
                                                        <input type="text" class="form-control" name="instagram" value="{{$contact->instagram}}">                                 
                                                    </div>                                      
                                                </div>    
                                                                              
                                            </div>
        
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Twitter</label>
                                                        
                                                        <input type="text" class="form-control" name="twitter" value="{{$contact->twitter}}">                                 
                                                    </div>                                      
                                                </div>    
                                                                              
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Footer info</label>
                                                        <textarea name="info" rows="5" class="form-control">{{ $contact->info }}</textarea>         
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
                                <!--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete{{ $contact->id }}">-->
                                <!--    delete-->
                                <!--</button>-->
                                <div class="modal fade" id="delete{{ $contact->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel">contact delete</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('contactDelete', $contact->id) }}" method="post">
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