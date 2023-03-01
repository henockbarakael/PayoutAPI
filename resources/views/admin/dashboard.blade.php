@extends('layouts.master')
@section('title','Admin Dashboard')
@section('page','Home')
@section('page-inner','Dashboard')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('layouts.page-title')
        <!-- end page title -->

        <div class="row row-cols-xxl-5 row-cols-lg-4 row-cols-sm-2 row-cols-1">
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex bg-danger">
                        <div class="flex-grow-1">
                            <h4>{{$file_imported}}</h4>
                            <h6 class="text-muted fs-13 mb-0">Total transaction</h6>
                        </div>
                        <div class="flex-shrink-0 avatar-sm">
                            <div class="avatar-title bg-soft-warning text-warning fs-22 rounded">
                                <i class="ri-bar-chart-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex">
                        <div class="flex-grow-1">
                            <h4>{{$log_success}}</h4>
                            <h6 class="text-muted fs-13 mb-0">Success payments</h6>
                        </div>
                        <div class="flex-shrink-0 avatar-sm">
                            <div class="avatar-title bg-soft-success text-success fs-22 rounded">
                                <i class="ri-bar-chart-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex">
                        <div class="flex-grow-1">
                            <h4>{{$log_failed}}</h4>
                            <h6 class="text-muted fs-13 mb-0">Failed payments</h6>
                        </div>
                        <div class="flex-shrink-0 avatar-sm">
                            <div class="avatar-title bg-soft-info text-info fs-22 rounded">
                                <i class="ri-bar-chart-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex">
                        <div class="flex-grow-1">
                            <h4>{{$log_pending}}</h4>
                            <h6 class="text-muted fs-13 mb-0">Pending payments</h6>
                        </div>
                        <div class="flex-shrink-0 avatar-sm">
                            <div class="avatar-title bg-soft-danger text-danger fs-22 rounded">
                                <i class="ri-bar-chart-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
    </div>
    <!-- container-fluid -->
</div>
@endsection
