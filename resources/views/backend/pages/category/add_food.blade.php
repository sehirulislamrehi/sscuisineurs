@extends('backend.template.layout')

<style>
    .container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 50%;
        height: 20px;
        width: 20px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container input:checked~.checkmark {
        background-color: #f0c180;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container input:checked~.checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>

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
                            add food item
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
                </ul>
            </div>
            @endif


            <!-- manage row start -->
            <form action="{{ route('category.food.add', $category->id) }}" method="post">
                @csrf
                <div class="row" style="margin-top: 50px">
                    <div class="col-md-12" style="margin: 15px 0;border-bottom: 1px solid white">
                        <h2>All Food List</h2>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped food_table">
                            <thead>
                                <tr>
                                    <td>Select Item</td>
                                    <td>Food Name</td>
                                    <td>Added or Not?</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($foods as $food)
                                <tr>
                                    <td>
                                        <label class="container">
                                            <input type="checkbox" name="foods[]" value="{{ $food->id }}">
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    <td>
                                        {{ $food->name }}
                                    </td>
                                    <td>
                                        @foreach( $category->menu as $category_food )
                                        @if( $category_food->id == $food->id )
                                        <p class="badge badge-success">
                                            Added
                                        </p>
                                        @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="row" style="margin-top: 15px">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-success">Add Food To The Menu</button>
                    </div>
                </div>
            </form>

        </section>
        <!-- dashbaord statistics seciton end -->

    </div>
</div>
<!-- main content end -->
@endsection