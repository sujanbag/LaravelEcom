@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">CMS Pages Tables</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a>
                </li>
                <li class="breadcrumb-item active">CMS Pages Tables
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">
        <!-- Bordered table start -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">CMS Pages</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <a href="{{url('admin/add-cms-page')}}" style="margin-bottom:30px;max-width:150px;float:right;display:inline-block;" class="btn btn-block btn-success">Add Cms Page</a>
                </div>
                
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <thead>
                      <tr>
                        <th>Page ID</th>
                        <th>Title</th>
                        <th>URL</th>
                        <th>Status</th>
                        <th>Created on</th>
                        <th>Actions</th> 
                      </tr> 
                    </thead>
                    <tbody>
                      @foreach($cmsPages as $cms)
                      <tr>
                        <th scope="row">{{ $cms->id  }}</th>
                        <td>{{ $cms->title }}</td>
                        <td>{{ $cms->url }}</td>
                        <td> 
                            @if($cms->status==1)
                                <a class="updateCmsStatus" id="cms-{{ $cms->id }}" cms_id="{{ $cms->id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                            @else
                                <a class="updateCmsStatus" id="cms-{{ $cms->id }}" cms_id="{{ $cms->id }}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                            @endif
                         </td>
                         <td>{{ $cms->created_at }}</td>
                        <td>
                          
                            <a title="Edit Product" href="{{url('admin/add-cms-page/'.$cms->id)}}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                         
                            <a title="Delete Product" href="javascript:void(0)" class="confirmDelete" record="cms" recordid="{{$cms->id}}"
                            <?php /*href="{{url('admin/delete-category/'.$product->id)}}"*/?>><i class="fa fa-trash" aria-hidden="true"></i></a>
                        
                        </td> 
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- Bordered table end -->
      </div>
    </div>
 </div>
@endsection