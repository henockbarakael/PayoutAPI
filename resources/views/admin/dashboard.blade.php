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
                    <div class="card-body d-flex">
                        <div class="flex-grow-1">
                            <h4>4751</h4>
                            <h6 class="text-muted fs-13 mb-0">ICOs Published</h6>
                        </div>
                        <div class="flex-shrink-0 avatar-sm">
                            <div class="avatar-title bg-soft-warning text-warning fs-22 rounded">
                                <i class="ri-upload-2-line"></i>
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
                            <h4>3423</h4>
                            <h6 class="text-muted fs-13 mb-0">Active ICOs</h6>
                        </div>
                        <div class="flex-shrink-0 avatar-sm">
                            <div class="avatar-title bg-soft-success text-success fs-22 rounded">
                                <i class="ri-remote-control-line"></i>
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
                            <h4>354</h4>
                            <h6 class="text-muted fs-13 mb-0">ICOs Trading</h6>
                        </div>
                        <div class="flex-shrink-0 avatar-sm">
                            <div class="avatar-title bg-soft-info text-info fs-22 rounded">
                                <i class="ri-flashlight-fill"></i>
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
                            <h4>2762</h4>
                            <h6 class="text-muted fs-13 mb-0">Funded ICOs</h6>
                        </div>
                        <div class="flex-shrink-0 avatar-sm">
                            <div class="avatar-title bg-soft-danger text-danger fs-22 rounded">
                                <i class="ri-hand-coin-line"></i>
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
