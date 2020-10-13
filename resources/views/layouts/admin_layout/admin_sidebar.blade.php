<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="{{url('theme-assets/images/backgrounds/02.jpg')}}">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto"><a class="navbar-brand" href="{{url('admin/dashboard')}}"><img class="brand-logo" alt="WBCADC admin logo" src="{{url('theme-assets/images/logo/bblog.png')}}"/>
          <h3 class="brand-text">Admin Panel</h3></a></li>
      <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
    </ul>
  </div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        @if(Session::get('page')=="dashboard")
            <?php $active="active";?>
        @else
            <?php $active="";?>
        @endif
    <li class="{{$active}}"><a href="{{url('admin/dashboard')}}"><i class="ft-home"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
      </li>
        @if(Session::get('page')=="settings")
            <?php $active="active";?>
        @else
            <?php $active="";?>
        @endif
      <li class="nav-item {{$active}}"><a href="{{url('admin/settings')}}"><i class="la la-unlock"></i><span class="menu-title" data-i18n="">Password Update</span></a>
      </li>
        @if(Session::get('page')=="update-admin-details")
            <?php $active="active";?>
        @else
            <?php $active="";?>
        @endif
        <li class="nav-item {{$active}}"><a href="{{url('admin/update-admin-details')}}"><i class="la la-user"></i><span class="menu-title" data-i18n="">Profile Update</span></a>
      </li>
        @if(Session::get('page')=="sections")
            <?php $active="active";?>
        @else
            <?php $active="";?>
        @endif
      <li class=" nav-item {{$active}}"><a href="{{url('admin/sections')}}"><i class="la la-cart-plus"></i><span class="menu-title" data-i18n="">Sections</span></a>
      </li>
        @if(Session::get('page')=="categories")
            <?php $active="active";?>
        @else
            <?php $active="";?>
        @endif
      <li class=" nav-item {{$active}}"><a href="{{url('admin/categories')}}"><i class="la la-cart-arrow-down"></i><span class="menu-title" data-i18n="">Categories</span></a>
      </li>
        @if(Session::get('page')=="products")
            <?php $active="active";?>
        @else
            <?php $active="";?>
        @endif
      <li class=" nav-item {{$active}}"><a href="{{url('admin/products')}}"><i class="ft-layers"></i><span class="menu-title" data-i18n="">Products</span></a>
      </li>
        @if(Session::get('page')=="banners")
            <?php $active="active";?>
        @else
            <?php $active="";?>
        @endif
      <li class=" nav-item {{$active}}"><a href="{{url('admin/banners')}}"><i class="la la-sheqel"></i><span class="menu-title" data-i18n="">Banners</span></a>
      </li>
        @if(Session::get('page')=="brands")
            <?php $active="active";?>
        @else
            <?php $active="";?>
        @endif
      <li class=" nav-item {{$active}}"><a href="{{url('admin/brands')}}"><i class="la la-files-o"></i><span class="menu-title" data-i18n="">Brands</span></a>
      </li>
        @if(Session::get('page')=="view-orders")
            <?php $active="active";?>
        @else
            <?php $active="";?>
        @endif
      <li class=" nav-item {{$active}}"><a href="{{url('admin/view-orders')}}"><i class="la la-shopping-cart"></i><span class="menu-title" data-i18n="">Orders</span></a>
      </li>
        @if(Session::get('page')=="coupons")
            <?php $active="active";?>
        @else
            <?php $active="";?>
        @endif
      <li class=" nav-item {{$active}}"><a href="{{url('admin/coupons')}}"><i class="ft-layout"></i><span class="menu-title" data-i18n="">Coupons</span></a>
      </li>
        @if(Session::get('page')=="view-user")
            <?php $active="active";?>
        @else
            <?php $active="";?>
        @endif
      <li class=" nav-item {{$active}}"><a href="{{url('admin/view-user')}}"><i class="la la-users"></i><span class="menu-title" data-i18n="">Users</span></a>
      </li>
        @if(Session::get('page')=="view-cms-page")
            <?php $active="active";?>
        @else
            <?php $active="";?>
        @endif
    <li class=" nav-item {{$active}}"><a href="{{url('admin/view-cms-page')}}"><i class="la la-users"></i><span class="menu-title" data-i18n="">CMS Pages</span></a>
      </li>
    </ul>
  </div>

  <div class="navigation-background"></div>
</div>
