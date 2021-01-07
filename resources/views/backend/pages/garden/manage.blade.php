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
                            Garden Gourmet At A Glance
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
                        Add
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLabel">Garden Bournet At A Glance</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('garden.add') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Image ( Image size may not be Greater  than 100 KB )</label> <br>
                                                <img src="{{ asset('backend/images/thumbnail.jpg') }}" id="image_preview_container" class="default-thhumbnail" width="100px" alt=""> 
                                                <input type="file" class="form-control-file" name="image" id="image">                                 
                                            </div>                                      
                                        </div>    

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label> Title</label>
                                                <input type="text" class="form-control" name="title" >                                 
                                            </div>                                      
                                        </div>  

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label> Description</label>
                                                
                                                <textarea name="description" class="form-control" rows="5"></textarea>                           
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
                                <td>Image</td>
                                <td>Title</td>
                                <td>Description</td>
                                <td>action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($gardens as $garden)
                            <tr>
                                <th>{{ $i }}</th>
                                <td>
                                    @if( $garden->image != NULL )
                                    <img src="{{ asset('images/garden/'.$garden->image) }}" class="img-fluid" width="50px" alt="">
                                    @else
                                    <p class="badge badge-danger">No image uploaded</p>
                                    @endif
                                </td>

                                <td>
                                   {{$garden->title}}
                                </td>
                                <td>
                                    {{Str::limit($garden->description, 50)}}
                                </td>
                                <td>
                                
                                <!-- edit start -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit{{ $garden->id }}">
                                    edit
                                </button>
                                <div class="modal fade" id="edit{{ $garden->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLabel">garden</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('garden.update', $garden->id) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label> Image ( Image size may not be Greater  than 100 kb )</label> <br> <br>
                                                                <img src="{{ asset('images/garden/'. $garden->image) }}"  width="100px" alt="">  <br> <br>
                                                                <input type="file" class="form-control-file" name="image">                                 
                                                            </div>                                      
                                                        </div>  
                                                        
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label> Title</label>
                                                            <input type="text" class="form-control" name="title" value="{{$garden->title}}">               
                                                            </div>                  
                                                        </div>     
                                                        
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label> Description</label>
                                                            <textarea name="description" rows="5" class="form-control">{{$garden->description}}</textarea>                               
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
                                 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete{{ $garden->id }}">
                                    Delete
                                </button>
                                <div class="modal fade" id="delete{{ $garden->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLabel">Garden Bournet At A Glance delete</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('garden.delete', $garden->id) }}" method="post">
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