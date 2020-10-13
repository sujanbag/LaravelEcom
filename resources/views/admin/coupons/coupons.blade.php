@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">Coupones Tables</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a>
                </li>
                <li class="breadcrumb-item active">Coupones Tables
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
                <h4 class="card-title">Coupones table</h4>
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
                  <a href="{{url('admin/add-coupon')}}" style="margin-bottom:30px;max-width:150px;float:right;display:inline-block;" class="btn btn-block btn-success">Add Brand</a>
                </div>
                
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <thead>
                      <tr>
                        <th>Coupon ID</th>
                        <th>Coupon Code</th>
                        <th>Amount</th>
                        <th>Amount Type</th>
                        <th>Expiry Date</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($coupons as $coupon)
                      <tr>
                        <th scope="row">{{ $coupon->id }}</th>
                        <td>{{ $coupon->coupon_code }}</td>
                        <td>{{ $coupon->amount}} @if($coupon->amount_type == "Percentage") % @else INR @endif</td>
                        <td>{{ $coupon->amount_type }}</td>
                        <td>{{ $coupon->expiry_date }}</td>
                        <td>{{ $coupon->created_at}}</td>

                        <td>
                          <a title="Edit Coupon" href="{{url('admin/add-coupon/'.$coupon->id)}}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                            &nbsp;&nbsp;
                            <a title="Delete Coupon" href="javascript:void(0)" class="confirmDelete" record="coupon" recordid="{{$coupon->id}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            &nbsp;&nbsp;
                            @if($coupon->status==1)
                                <a class="updateCouponStatus" id="coupon-{{ $coupon->id }}" coupon_id="{{ $coupon->id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                            @else
                                <a class="updateCouponStatus" id="coupon-{{ $coupon->id }}" coupon_id="{{ $coupon->id }}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                            @endif
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