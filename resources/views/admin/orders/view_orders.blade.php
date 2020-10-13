@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">Orders Tables</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a>
                </li>
                <li class="breadcrumb-item active">Orders Tables
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
            @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
                {{Session::get('success_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Orders</h4>
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
                {{-- <div class="card-body">
                  <a href="{{url('admin/add-edit-category')}}" style="margin-bottom:30px;max-width:150px;float:right;display:inline-block;" class="btn btn-block btn-success">Add Category</a>
                </div> --}}
                
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Order Date</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Ordered Products</th>
                        <th>Order Amount</th>
                        <th>Order Status</th>
                        <th>Payment Method</th>
                        <th>Actions</th> 
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($orders as $order)
                      <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->user_email }}</td>
                        <td>@foreach($order->orders as $pro) {{$pro->product_code}} ({{$pro->product_qty}}) <br>@endforeach</td>
                        <td>{{$order->grand_total}}</td>
                        <td>{{$order->order_status}}</td> </td>
                        <td>{{$order->payment_method}}</td>
                        <td> 
                          <a href="{{url('admin/view-order/'.$order->id)}}" class="btn btn-success btn-mini">View Order Details</a><br><br> 
                          <a href="{{url('admin/view-order-invoice/'.$order->id)}}" class="btn btn-success btn-mini">View Order Invoice</a>
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