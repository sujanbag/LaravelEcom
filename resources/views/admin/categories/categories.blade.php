@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">Categories Tables</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a>
                </li>
                <li class="breadcrumb-item active">Categories Tables
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
                <h4 class="card-title">Bordered table</h4>
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
                  <a href="{{url('admin/add-edit-category')}}" style="margin-bottom:30px;max-width:150px;float:right;display:inline-block;" class="btn btn-block btn-success">Add Category</a>
                </div>
                
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Parent Category</th>
                        <th>Section</th>
                        <th>URL</th>
                        <th>Status</th> 
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($categories as $category)
                      @if(!isset($category->parentcategory->category_name))
                      <?php $parent_category="Root";?>
                      @else
                      <?php $parent_category=$category->parentcategory->category_name;?>
                      @endif
                      <tr>
                        <th scope="row">{{ $category->id }}</th>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ $parent_category }}</td>
                        <td>@if(!empty($category->section->name)) {{ $category->section->name }}@else No Section @endif</td>
                        <td>{{ $category->url }}</td>
                        <td> 
                            @if($category->status==1)
                                <a class="updateCategoryStatus" id="category-{{ $category->id }}" category_id="{{ $category->id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                            @else
                                <a class="updateCategoryStatus" id="category-{{ $category->id }}" section_id="{{ $category->id }}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                            @endif
                        </td>
                        <td>
                          <a href="{{url('admin/add-edit-category/'.$category->id)}}">Edit</a>
                          &nbsp;&nbsp;
                          <a href="javascript:void(0)" class="confirmDelete" record="category" recordid="{{$category->id}}"
                          <?php /*href="{{url('admin/delete-category/'.$category->id)}}"*/?>>Delete</a>
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