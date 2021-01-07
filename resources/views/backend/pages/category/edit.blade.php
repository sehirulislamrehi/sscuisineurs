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
                            Menu View
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row" style="margin-top: 15px">
                <div class="col-md-12">
                    <img src="{{ asset('images/menu/'. $category->image) }}" width="150px" alt="">
                </div>
                <div class="col-md-12" style="margin-top: 15px">
                    <h2>Menu Name : {{ $category->name }}</h2>
                </div>
                <div class="col-md-12">
                    <h2>Menu Price : {{ $category->price }} BDT</h2>
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

            <form action="{{ route('categoryUpdate', $category->id) }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{$category->name}}">
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input type="number" class="form-control" value="{{ $category->price }}" name="price">
                </div>

                <div class="form-group">
                    <label>Menu Thumbnail Image ( Image size may not be Greater than 100
                        KB )</label> <br>
                    <img src="{{ asset('images/menu/'.$category->image) }}" id="image_preview_container" width="100px"
                        class="default-thhumbnail" width="100px" alt="">
                    <input type="file" class="form-control-file" name="image" id="image">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>

            <div class="form-group">
                <h2 style="margin-bottom: 15px">Menu Opening Day List</h2>
                <table class="table table-striped myTable">

                    <thead>
                        <tr>
                            <td>Id</td>
                            <td>Day</td>
                            <td>action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $category->day as $key => $day )
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ $day->day }}
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#delete_day{{ $day->id }}">
                                    Delete
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="delete_day{{ $day->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Are you sure want to
                                                    delete this day ?</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <form
                                                    action="{{ route('delete.day.category',[$day->id, $category->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Yes</button>
                                                </form>

                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-group d-none">
                <h2 style="margin-bottom: 15px">Menu Food List</h2>
                <a href="{{ route('category.food.view', $category->id) }}" class="btn btn-success"
                    style="margin-bottom: 15px" target="__blank">Add Food</a>
                <table class="table table-striped myTable">

                    <thead>
                        <tr>
                            <td>Id</td>
                            <td>Food Name</td>
                            <td>action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $category->menu as $key => $food )
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ $food->name }}
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#delete_food{{ $food->id }}">
                                    Delete
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="delete_food{{ $food->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Are you sure want to
                                                    delete this food ?</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <form
                                                    action="{{ route('delete.food.category',[$food->id, $category->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Yes</button>
                                                </form>

                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>



            <div class="form-group">
                <h2 style="margin-bottom: 15px">Menu Food Image</h2>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit"
                    style="margin-bottom: 15px">
                    Add Food Image
                </button>

                <!-- Modal -->
                <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">logo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('category.food.images.add',$category->id) }}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Image ( Image size may not be Greater than 100 KB )</label> <br>
                                        <img src="{{ asset('backend/images/thumbnail.jpg') }}" id="image_preview_container" class="default-thhumbnail" width="100px" alt=""> 
                                                <input type="file" class="form-control-file" name="image" id="image">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Add</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped myTable">
                    <thead>
                        <tr>
                            <td>Id</td>
                            <td>Food Image</td>
                            <td>action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $category->categoryimage as $key => $food )
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a data-fancybox="gallery" href="{{ asset('images/food/'. $food->image) }}">
                                    <img src="{{ asset('images/food/'. $food->image) }}" width="32px" alt="">
                                </a>
                            </td>
                            <td>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#editFoodImage{{ $food->id }}">
                                    Edit
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="editFoodImage{{ $food->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Image</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('category.food.images.update',[$food->id, $category->id]) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Image ( Image size may not be Greater than 100 KB )</label>  <br> <br>
                                                        <img src="{{ asset('images/food/'. $food->image) }}"width="100px" alt="">  <br> <br>
                                                        <input type="file" class="form-control-file" name="image" id="image">
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#delete_food{{ $food->id }}">
                                    Delete
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="delete_food{{ $food->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Are you sure want to
                                                    delete this food image?</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <form
                                                    action="{{ route('category.food.images.delete',[$food->id, $category->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Yes</button>
                                                </form>

                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>




        </section>
        <!-- dashbaord statistics seciton end -->

    </div>
</div>
<!-- main content end -->
@endsection