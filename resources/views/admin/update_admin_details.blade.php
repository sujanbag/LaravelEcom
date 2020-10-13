@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-wrapper-before"></div>
    <div class="content-header row">
      <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">WBCADC Update Admin Details</h3>
      </div>
      <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
          <div class="breadcrumb-wrapper mr-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a>
              </li>
              <li class="breadcrumb-item active">Update Details
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content-body"><!-- Basic Inputs start -->
      
        <section class="basic-inputs">
          @if ($errors->any())
          <div class="alert alert-danger" style="margin-top:10px;">
              <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>

          @endif
          @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
                {{Session::get('success_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <form role="form" method="post" action="{{url('/admin/update-admin-details')}}" name="updateAdminDetails" enctype="multipart/form-data" id="updateAdminDetails">@csrf
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">{{$title}}</h3>
    
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
    
                        <div class="form-group">
                          <label for="exampleInputEmail1">Admin Email</label>
                          <input class="form-control" value="{{$adminDetails->email}}" readonly="">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Admin Type</label>
                          <input class="form-control" value="{{$adminDetails->type}}" readonly="">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Current Password</label>
                            <input type="password" class="form-control" name="current_pwd" id="current_pwd" placeholder="Enter Current Password" required="">
                            <span id="chkCurrentPwd"></span>
                            
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Name</label>
                            <input type="text" class="form-control" name="admin_name" value="{{Session::get('adminSession')}}" id="admin_name" placeholder="Enter Admin Name" required="">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Mobile</label>
                            <input type="text" class="form-control" name= "admin_mobile" value="{{$adminDetails->mobile}}" id="admin_mobile" placeholder="Enter admin mobile" required="">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Images</label>
                            <input type="file" class="form-control" name="admin_image" id="admin_image" accept="image/*" >
                            @if(!empty($adminDetails->image))
                            <a target="_blank" href="{{url('images/admin_images/admin_photos/'.$adminDetails->image)}}">View Image</a>
                            <input type="hidden" name="current_admin_image" value="{{$adminDetails->image}}">
                            @endif
                          </div>
    
                    </div>
    
                    <!-- /.col -->
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
          </form>
        </section>
        <!-- Basic Inputs end -->
     
   
      
    </div>
  </div>
</div>

@endsection