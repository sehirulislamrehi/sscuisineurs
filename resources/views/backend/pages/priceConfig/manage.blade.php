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
                            Pricing
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- page indicator end -->

        <!-- add row start -->

        @if ($errors->any())
        <div class="alert alert-danger" style="background: red;">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- manage row start -->

        <form action="{{ route('configUpdate') }}" method="post">
            @csrf
            <div class="form-group">
                <label>Adult Price</label>
                <input type="number" min="0" class="form-control" name="price[]" value="{{$configs[0]->price}}">
            </div>
            <div class="form-group">
                <label>Child Under 120cm Price</label>
                <input type="number" min="0" class="form-control" name="price[]" value="{{$configs[1]->price}}">
            </div>
            <div class="form-group">
                <label>Child Under 132cm Price</label>
                <input type="number" min="0" class="form-control" name="price[]" value="{{$configs[2]->price}}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>

        <!-- manage row end -->

        </section>
        <!-- dashbaord statistics seciton end -->

    </div>
</div>
<!-- main content end -->
@endsection