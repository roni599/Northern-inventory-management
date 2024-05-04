@extends('User.layout.master')
@section('content')

          
<div class="col-lg-8 mb-4 order-0">

<div class="col-lg-12 mb-4 order-0">
  <div class="card">
    <div class="d-flex align-items-end row">
      <div class="col-sm-7">
        <div class="card-body">
          <h5 class="card-title text-primary">Congratulations, {{ $user->full_name }}! 🎉</h5>
          <p class="mb-4">
            Welcome to
            your profile.
          </p>

          <a href="{{ route('user.view_profile') }}" class="btn btn-sm btn-outline-primary">View profile</a>
        </div>
      </div>
      <div class="col-sm-5 text-center text-sm-left">
        <div class="card-body pb-0 px-0 px-md-4">
        <div class="left">
        <!-- <iframe scrolling="no" frameborder="no" clocktype="html5" style="overflow:hidden;border:0;margin:0;padding:0;width:227px;height:75px;"src="https://www.clocklink.com/html5embed.php?clock=008&timezone=GMT0600&color=blue&size=227&Title=&Message=&Target=&From=2024,1,1,0,0,0&Color=blue"></iframe> -->

      </div>

        </div>
      </div>
    </div>
  </div>
</div>

  <div class="card p-4">
    <div class="right-box">
      <div class="left">
        <img src="/User/assets/img/p6.jpeg" alt="" >
      </div>

      <div class="right">
        <div class="custom-options custom-color1">
          <div class="icons">
            <i class='bx bx-box' ></i>
          </div>
          <!-- <h4>Place Order</h4> -->
          <a href="/user/place_order" class="btn btn-light">Order Item</a>
        </div>
        <div class="custom-options custom-color2 mt-4">
          <div class="icons">
            <i class='bx bxs-box'></i>
          </div>
          <a href="{{ route('user.order_list') }}" class="btn btn-light">Order History</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endSection