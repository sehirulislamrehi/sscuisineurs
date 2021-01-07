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
                            All Messages
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- page indicator end -->

        <!-- dashbaord statistics seciton start -->
        <section class="statistics">


            <!-- manage row start -->
            <div class="row">

                @if ($errors->any())
            <div class="alert alert-danger" style="background: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


                <div class="col-md-12 table-responsive">
                    <form action="{{ route('message.delete') }}" method="post">
                        @csrf
                        <table class="table table-striped" id="message_table">
                            <thead>
                                <tr>
                                    <td>Status</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Phone</td>
                                    <td>action</td>
                                    @if( Auth::user()->id == 1 || Auth::user()->role == 3 )
                                    <td>Delete</td>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($messages as $key => $message)
                                <tr>
                                    <th>
                                        @if( $message->is_replied == true )
                                        <p class="badge badge-success">Replied</p>
                                        @else
                                        <p class="badge badge-danger">New Message</p>
                                        
                                        @endif
                                    </th>
                                    <td> {{ $message->name }} </td>
                                    <td> {{ $message->email }} </td>
                                    <td> {{ $message->phone }} </td>
                                    
                                    <td>

                                        <!-- delete start -->
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#view{{ $message->id }}">
                                            View
                                        </button>
                                        <div class="modal fade" id="view{{ $message->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="exampleModalLabel">Full Message</h3>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <p>{{ $message->name }}</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <p style="text-transform: lowercase">{{ $message->email }}
                                                            </p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Phone</label>
                                                            <p>{{ $message->phone }}</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>message</label>
                                                            <p>{{ $message->message }}</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Sending Date</label>
                                                            <p>{{ \Carbon\Carbon::parse($message->created_at)->toDayDateTimeString() }}
                                                            </p>
                                                        </div>
                                                        @if( $message->is_replied == false )
                                                        <div class="form-group">
                                                            <p style="text-transform: unset">Reply This Message to {{ $message->email }}</p>
                                                            <form action="{{ route('message.reply', $message->id) }}" method="post" >
                                                            @csrf
                                                            	<input type="hidden" class="form-control" name="email" required value="{{ $message->email }}">
                                                                <div class="form-group" style="margin-top: 15px">
                                                                    <textarea name="message" class="form-control" rows="5"></textarea>
                                                                </div>
                                                                <div class="form-group" style="margin-top: 15px">
                                                                    <button type="submit" class="btn btn-success">Reply</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        @else
                                                            <p class="alert alert-success">You Already Reply This Message. Our Reply Is</p>
                                                            {!! $message->reply_message !!}
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- delete end -->

                                    </td>
                                    @if( Auth::user()->id == 1 || Auth::user()->role == 3 )
                                    <td>
                                        <input type="checkbox" name="delete_message[]" value="{{ $message->id }}">
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        @if( Auth::user()->id == 1 || Auth::user()->role == 3 )
                        <div class="form-group text-right" style="margin-top: 15px">
                            <button type="submit" class="btn btn-danger">Delete Selected Item</button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
            <!-- manage row end -->

        </section>
        <!-- dashbaord statistics seciton end -->

    </div>
</div>
<!-- main content end -->
@endsection



