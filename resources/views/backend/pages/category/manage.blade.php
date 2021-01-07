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
                            Menu
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
                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        add new Menu
                    </button> --}}

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">Menu</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('categoryStore') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" name="name">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Price</label>
                                                    <input type="number" class="form-control" name="price">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Menu Image ( Image size may not be Greater than 100 KB
                                                        )</label> <br>
                                                    <img src="{{ asset('backend/images/thumbnail.jpg') }}"
                                                        id="image_preview_container" class="default-thhumbnail"
                                                        width="100px" alt="">
                                                    <input type="file" class="form-control-file" name="image"
                                                        id="image">
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
                                <td>Name</td>
                                <td>Price</td>
                                <td>action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @foreach($categories as $category)
                            <tr>
                                <th>{{ $i }}</th>

                                <td>
                                    <img src="{{ asset('images/menu/'. $category->image) }}" width="50px" alt="">
                                </td>

                                <td>
                                    {{$category->name}}
                                </td>

                                <td>
                                    {{$category->price}} BDT
                                </td>

                                <td>
                                    <!-- edit start -->
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary" target="__blank">View Menu</a>
                                    <!-- edit end -->

                                    {{-- <a href="{{ route('category.food.view', $category->id) }}" class="btn btn-success" target="__blank">Add Food</a> --}}

                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#day{{ $category->id }}">
                                        Day
                                    </button>
                                    <div class="modal fade" id="day{{ $category->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">Select Category Day</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('category.day', $category->id) }}" method="post">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Select Day for "{{ $category->name }}". </label>
                                                            <label>
                                                                [ Already Added Days :
                                                                @foreach ($category->day as $c_day)
                                                                {{ $c_day->day }},                                                                   
                                                                @endforeach ] 
                                                            </label>
                                                            <select name="days[]" class="form-control chosen" multiple  style="width: 100%">
                                                                @foreach (App\Models\Day::all() as $day)
                                                                <option value="{{ $day->id }}"
                                                                >{{ $day->day }}</option>                                                          
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-success">Add</button>
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

                                    <!-- delete start -->
                                    {{-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete{{ $category->id }}">
                                    delete
                                    </button> --}}
                                    <div class="modal fade" id="delete{{ $category->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">category delete</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('categoryDelete', $category->id) }}"
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

