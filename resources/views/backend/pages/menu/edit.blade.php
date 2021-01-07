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
                                   Edit Food Item
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


               <!-- manage row start -->
               <div class="row">
                    <div class="col-md-12 table-responsive">
                         <form action="{{ route('menuUpdate', $menu->id) }}" method="post" enctype="multipart/form-data">
                              @csrf

                              <div class="row">
                                   <div class="col-md-12">
                                        <div class="form-group">
                                             <label> Image ( Image size may not be Greater  than 100 KB )</label> <br> <br>
                                             <img src="{{ asset('images/menu/'. $menu->image) }}" width="100px" alt=""> <br> <br>
                                             <input type="file" class="form-control-file" name="image">
                                        </div>
                                   </div>

                                   <div class="col-md-12">
                                        <div class="form-group">
                                             <label>Name</label>
                                             <input type="text" class="form-control" name="name" value="{{$menu->name}}">
                                        </div>
                                   </div>

                                   <div class="col-md-12">
                                        <div class="form-group">
                                             <label>Description</label>
                                             <input type="text" class="form-control" name="description" value="{{$menu->description}}">
                                        </div>
                                   </div>

                                   <div class="col-md-12">
                                        <div class="form-group">
                                             <label>Status</label>
                                             <select name="status" class="form-control">
                                                  <option value="1" @if( $menu->status == 1 ) selected @endif >Active</option>
                                                  <option value="0" @if( $menu->status == 0 ) selected @endif >Inactive</option>
                                                  
                                             </select>
                                        </div>
                                   </div>

                              </div>

                              <div class="form-group">
                                   <button type="submit" class="btn btn-primary">Update</button>
                              </div>
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