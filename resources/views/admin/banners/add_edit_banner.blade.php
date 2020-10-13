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
            <form name="bannerForm" id="BannerForm" 
            @if(empty($banner['id'])) action="{{ url('admin/add-edit-banner')}}" 
            @else action="{{url('admin/add-edit-banner/'.$banner['id'])}}" @endif 
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
                        <label for="image">Banner Image</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                          </div> 
                        </div>
                        @if(!empty($banner['image']))
                        <div>
                        <img style="width:130px; margin-top:5px;" src="{{asset('images/banner_images/'.$banner['image'])}}">
                        &nbsp;
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                         <label for="link">Banner Link</label>
                         <input type="text" name="link" class="form-control" id="link" placeholder="Enter Banner Link" @if(!empty($banner["link"])) 
                         value="{{$banner["link"]}}" @else value="{{old("link")}}" @endif>
                       </div>
                       <div class="form-group">
                            <label for="title">Banner Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter Banner LTitle" @if(!empty($banner["title"])) 
                            value="{{$banner["title"]}}" @else value="{{old("title")}}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="alt">Banner Alternative Text</label>
                            <input type="text" name="alt" class="form-control" id="alt" placeholder="Enter Banner LTitle" @if(!empty($banner["alt"])) 
                            value="{{$banner["alt"]}}" @else value="{{old("alt")}}" @endif>
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