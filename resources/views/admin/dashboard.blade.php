@extends('admin.layout.final')
@section('title')
    Dashboard
@endsection
@section('pageTitle')
    Dashboard
@endsection
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Dashboard</h3>
          </div>
          <div class="col-sm-6"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6 dashboard_box">
                <div class="small-box bg-info ">
                  <div class="inner">
                    <h3>{{($totalUser)?$totalUser:'0'}}</h3>
                    <p>Total Users</p><span style="visibility: hidden;">Text</span>
                  </div>
                  <div class="icon">
                        <i class="fa fa-users" aria-hidden="true"></i>
                  </div>
                </div>
            </div>
            <div class="col-lg-3 col-6 dashboard_box">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>0</h3>
                    <p>Viewed Profile</p><span style="visibility: hidden;">Text</span>
                  </div>
                  <div class="icon">
                       <i class="fa fa-eye" aria-hidden="true"></i>
                  </div>
                </div>
            </div>
            <div class="col-lg-3 col-6 dashboard_box">
                <div class="small-box bg-secondary">
                  <div class="inner">
                    <h3>{{($lastMonthUser)?$lastMonthUser:'0'}}</h3>
                    <p><b>New Users</b></p><span>(Last Month)</span>
                  </div>
                  <div class="icon">
                       <i class="ion ion-person-add"></i>
                  </div>
                </div>
            </div>
             <div class="col-lg-3 col-6 dashboard_box">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{($currentMonthUser)?$currentMonthUser:'0'}}</h3>
                    <p><b>New Users</b></p><span>(Current Month)</span>
                  </div>
                  <div class="icon">
                       <i class="ion ion-person-add"></i>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>
    
</section>
@endsection
