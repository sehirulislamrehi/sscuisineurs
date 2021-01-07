<!DOCTYPE html>
<html lang="en">

    <head>
        @include('backend.include.header')
        @include('backend.include.css')
    </head>

    <body>
        @include('backend.include.topbar')
        @include('backend.include.leftsidebar')      
        @yield('body-content')
        @include('backend.include.script')
        {!! Toastr::message() !!}

        <div class="modal fade" id="myModal" role="dialog" aria-labelledby="modal-default-header">
            <div class="modal-dialog" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>
            <div class="modal-content">

            </div>
            </div>
        </div>

    </body>

</html>