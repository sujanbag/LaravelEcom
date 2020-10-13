@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-wrapper-before"></div>
    <div class="content-header row">
      <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">{{$title}}</h3>
      </div>
      <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
          <div class="breadcrumb-wrapper mr-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a>
              </li>
              <li class="breadcrumb-item active">{{$title}}
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
            <form name="brandForm" id="brandForm" 
            @if(empty($brand['id'])) action="{{ url('admin/add-edit-brand')}}" 
            @else action="{{url('admin/add-edit-brand/'.$brand['id'])}}" @endif 
            method="post" enctype="multipart/form-data">@csrf
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
                        <label for="brand_name">Brand Name</label>
                        <input type="text" name="brand_name" class="form-control" id="brand_name" placeholder="Enter Brand Name" @if(!empty($brand['name'])) 
                        value="{{$brand['name']}}" @else value="{{old('brand_name')}}" @endif>
                    </div>
    
    
                    <!-- /.form-group -->
                  </div>
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