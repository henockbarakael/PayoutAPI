@extends('layouts.master')
@section('title','Admin Dashboard')
@section('page','Dashboard')
@section('page-inner','Dashboard')
@section('content')
{!! Toastr::message() !!}
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('layouts.page-title')
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="card card-animate" style="background-color: #DB1430;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                {{-- <p class="fw-medium text-white-50 mb-0">Avg. Visit Duration</p> --}}
                                <h2 class="mt-4 ff-secondary fw-semibold text-white">
                                    <span >CDF {{$airtel_cdf}}</span>
                                </h2>
                                <p class="mb-0 text-white-50"><span class="badge badge-soft-light mb-0">
                                        <i class="ri-arrow-down-line align-middle"></i> AIRTEL BALANCE
                                </p>
                            </div>

                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="card card-animate" style="background-color: #DB1430;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                {{-- <p class="fw-medium text-white-50 mb-0">Avg. Visit Duration</p> --}}
                                <h2 class="mt-4 ff-secondary fw-semibold text-white">
                                    <span >USD {{$airtel_usd}}</span>
                                </h2>
                                <p class="mb-0 text-white-50"><span class="badge badge-soft-light mb-0">
                                        <i class="ri-arrow-down-line align-middle"></i> AIRTEL BALANCE
                                </p>
                            </div>

                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="card card-animate" style="background-color: #119e3e;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                {{-- <p class="fw-medium text-white-50 mb-0">Avg. Visit Duration</p> --}}
                                <h2 class="mt-4 ff-secondary fw-semibold text-white">
                                    <span >CDF {{$vodacom_cdf}}</span>
                                </h2>
                                <p class="mb-0 text-white-50"><span class="badge badge-soft-light mb-0">
                                        <i class="ri-arrow-down-line align-middle"></i> VODACOM BALANCE
                                </p>
                            </div>

                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="card card-animate" style="background-color: #119e3e;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                {{-- <p class="fw-medium text-white-50 mb-0">Avg. Visit Duration</p> --}}
                                <h2 class="mt-4 ff-secondary fw-semibold text-white">
                                    <span >USD {{$vodacom_usd}}</span>
                                </h2>
                                <p class="mb-0 text-white-50"><span class="badge badge-soft-light mb-0">
                                        <i class="ri-arrow-down-line align-middle"></i> VODACOM BALANCE
                                </p>
                            </div>

                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="card card-animate" style="background-color: rgb(255, 133, 27);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                {{-- <p class="fw-medium text-white-50 mb-0">Avg. Visit Duration</p> --}}
                                <h2 class="mt-4 ff-secondary fw-semibold text-white">
                                    <span >CDF {{$orange_cdf}}</span>
                                </h2>
                                <p class="mb-0 text-white-50"><span class="badge badge-soft-light mb-0">
                                        <i class="ri-arrow-down-line align-middle"></i> ORANGE BALANCE
                                </p>
                            </div>

                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="card card-animate" style="background-color: rgb(255, 133, 27);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                {{-- <p class="fw-medium text-white-50 mb-0">Avg. Visit Duration</p> --}}
                                <h2 class="mt-4 ff-secondary fw-semibold text-white">
                                    <span >USD {{$orange_usd}}</span>
                                </h2>
                                <p class="mb-0 text-white-50"><span class="badge badge-soft-light mb-0">
                                        <i class="ri-arrow-down-line align-middle"></i> ORANGE BALANCE
                                </p>
                            </div>

                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div>
@section('script')
<!-- JAVASCRIPT -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
{{-- <script src="{{ asset('assets/js/plugins.js') }}"></script> --}}
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{ asset('assets/libs/list.js/list.min.js')}}"></script>
<script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js')}}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('assets/js/pages/datatables.init.js')}}"></script>
@endsection
@endsection
