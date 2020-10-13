@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">Products Tables</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a>
                </li>
                <li class="breadcrumb-item active">Products Tables
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
                <h4 class="card-title">Products table</h4>
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
                  <a href="{{url('admin/add-edit-product')}}" style="margin-bottom:30px;max-width:150px;float:right;display:inline-block;" class="btn btn-block btn-success">Add Product</a>
                </div>
                
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Product Code</th>
                        <th>Product Color</th>
                        <th>Product Image</th>
                        <th>Category</th>
                        <th>Section</th>
                        <th>Status</th>
                        <th>Actions</th> 
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($products as $product)
                      <tr>
                        <th scope="row">{{ $product->id  }}</th>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->product_code }}</td>
                        <td>{{ $product->product_color }}</td>
                        <td>
                          @if(!empty($product->main_image))
                          <img style="width:100px;" src="{{asset('images/product_images/small/'.$product->main_image)}}">
                          @else
                          <img style="width:100px;" src="{{asset('images/product_images/small/no_image.png')}}">
                          @endif
                        </td>
                        @if(!empty($product->category->category_name))
                        <td>{{$product->category->category_name }}</td>
                        @else
                        <td>No Category</td>
                        @endif
                        <td>{{$product->section->name}}</td>
                        <td> 
                            @if($product->status==1)
                                <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                            @else
                                <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                            @endif
                         </td>
                        <td>
                          
                          <a title="Add/Edit Attributes" href="{{url('admin/add-attributes/'.$product->id)}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                          
                          <a title="Add Images" href="{{url('admin/add-images/'.$product->id)}}"><i class="fas fa-plus-circle" aria-hidden="true"></i></a>
                          
                            <a title="Edit Product" href="{{url('admin/add-edit-product/'.$product->id)}}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                         
                            <a title="Delete Product" href="javascript:void(0)" class="confirmDelete" record="product" recordid="{{$product->id}}"
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