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
                            About Us
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
                        add new About
                    </button> --}}

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">About</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('aboutStore') }}" method="post" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" required name="title">
                                        </div>

                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control ckeditor" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>About Image ( Image size may not be Greater  than 100 KB )</label> <br>
                                            <img src="{{ asset('backend/images/thumbnail.jpg') }}" id="image_preview_container" class="default-thhumbnail" width="100px" alt="">
                                            <input type="file" class="form-control-file" required name="image" id="image">
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
                                <td>Description</td>
                                <td>Title</td>

                                <td>action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @foreach($abouts as $about)
                            <tr>
                                <th>{{ $i }}</th>
                                <td>
                                    {!!Str::limit($about->description,50)!!}
                                </td>

                                <td>
                                    {{Str::limit($about->title,20)}}
                                </td>
                                <td>

                                    <!-- edit start -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit{{ $about->id }}">
                                        edit
                                    </button>
                                    <div class="modal fade" id="edit{{ $about->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">about</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('aboutUpdate', $about->id) }}" method="post" enctype="multipart/form-data">
                                                        @csrf

                                                        <div class="form-group">
                                                            <label>about Title</label>
                                                            <input type="text" class="form-control" name="title" id="image" value="{{$about->title}}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>about description</label>

                                                            <textarea name="description" class="form-control ckeditor" rows="5">{{$about->description}}</textarea>

                                                        </div>
                                                        <div class="form-group">
                                                            <label>About Image ( Image size may not be Greater  than 100 KB )</label> <br>
                                                            <img src="{{ asset('images/about/'.$about->image) }}" id="image_preview_container" class="default-thhumbnail" width="100px" alt="">
                                                            <input type="file" class="form-control-file" name="image" id="image">
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
                                    {{-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete{{ $about->id }}">
                                        delete
                                    </button> --}}
                                    <div class="modal fade" id="delete{{ $about->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">about delete</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('aboutDelete', $about->id) }}" method="post">
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