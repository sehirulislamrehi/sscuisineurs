@extends('backend.template.layout')

@section('body-content')
<!-- main content start -->
<div class="main-content">
    <div class="container-fluid">

        <!-- page indicator start -->
        <section class="page-indicator">
            <div class="row">
                <div class="col-md-5">
                    <ul>
                        <li>
                            <i class="fas fa-bars"></i>
                        </li>
                        <li>
                            All Reservation
                        </li>
                    </ul>
                </div>

                <div class="col-md-7 text-right">
                    <ul>
                        <li>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#custom">
                                Download Custom Choosing
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="custom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Download custom choosing</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('report_picker.custom') }}" method="post">
                                                @csrf

                                                <div class="form-group">
                                                    <label>Date From</label>
                                                    <input type="date" id="start_date" class="form-control" name="from" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Date To</label>
                                                    <input type="date" id="end_date" class="form-control" name="to" required>
                                                </div>
                                                <script>
                                                    var today = new Date();
                                                    var dd = String(today.getDate()).padStart(2, '0');
                                                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                                                    var yyyy = today.getFullYear();

                                                    today = yyyy + "-" + mm + "-" + dd;
                                                    document.getElementById('end_date').setAttribute("max", today)
                                                    document.getElementById('start_date').setAttribute("max", today)


                                                    document.getElementById('end_date').onchange = (e) => {
                                                        document.getElementById('start_date').setAttribute("max", e.target.value)

                                                    }

                                                    document.getElementById('start_date').onchange = (e) => {
                                                        document.getElementById('end_date').setAttribute("min", e.target.value)

                                                    }
                                                </script>
                                                <div class="form-group">
                                                    <label>Payment Type</label>
                                                    <select name="payment_type" class="form-control" required>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Card">Card</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Discount From</label>
                                                    <select name="discount_type" class="form-control" required>
                                                        <option value="AmEx">AmEx</option>
                                                        <option value="EBL">EBL</option>
                                                        <option value="Brac">Brac Bank</option>
                                                        <option value="GPStar">GPStar</option>
                                                        <option value="Authority">Authority</option>
                                                        <option value="MTB">MTB</option>
                                                        <option value="">No Discount</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Payment Mehtod</label>
                                                    <select name="payment_method" class="form-control" required>
                                                        <option value="Cash">Onspot payment</option>
                                                        <option value="Online Payment">Online payment</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dateToDate">
                                Download Date to Date
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="dateToDate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Download Date To Date</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('report_picker') }}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Date From</label>
                                                    <input type="date" id="start_date" class="form-control" name="from" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Date To</label>
                                                    <input type="date" id="end_date" class="form-control" name="to" required>
                                                </div>
                                                <script>
                                                    var today = new Date();
                                                    var dd = String(today.getDate()).padStart(2, '0');
                                                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                                                    var yyyy = today.getFullYear();

                                                    today = yyyy + "-" + mm + "-" + dd;
                                                    document.getElementById('end_date').setAttribute("max", today)
                                                    document.getElementById('start_date').setAttribute("max", today)


                                                    document.getElementById('end_date').onchange = (e) => {
                                                        document.getElementById('start_date').setAttribute("max", e.target.value)

                                                    }

                                                    document.getElementById('start_date').onchange = (e) => {
                                                        document.getElementById('end_date').setAttribute("min", e.target.value)

                                                    }
                                                </script>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="btn btn-success" href="{{route('download_today')}}">Download Todays history</a>
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
                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered ajax-datatable" id="datatable">
                        <thead>
                            <tr>
                                <th>R.date</th>
                                <th>Name</th>
                                <th>Grand Total</th>
                                <th>Grand Total After Discount</th>
                                <th>Phone</th>
                                <th>Code</th>
                                <th>Payment Status</th>
                                <th>Arrival</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
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

<link href="{{ asset('backend/css/yajra/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/css/yajra/datatable.bootstrap.min.css') }}" rel="stylesheet">
<script src="{{ asset('backend/js/yajra/jquery1.9.1.js') }}"></script>
<script src="{{ asset('backend/js/yajra/jquery-validate.js') }}"></script>
<script src="{{ asset('backend/js/yajra/jquery-datatable.min.js') }}"></script>
<script src="{{ asset('backend/js/yajra/bootstrap4.min.js') }}"></script>

<script type="text/javascript">
    $(function() {
        $('.ajax-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('reservation.all.data') }}",
            columns: [
                {data: 'booking_date',name: 'booking_date'},
                {data: 'name',name: 'name'},
                {data: 'grand_total',name: 'grand_total'},
                {data: 'discount',name: 'discount'},
                {data: 'phone',name: 'phone'},
                {data: 'random',name: 'random'},
                {data: 'payment_status',name: 'payment_status'},
                {data: 'arrival',name: 'arrival'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                },
            ]
        });
    });
</script>