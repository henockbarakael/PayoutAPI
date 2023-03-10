@extends('layouts.master')
@section('title','Merchant List')
@section('page','Merchant')
@section('page-inner','Merchant List')
@section('content')
@include('sweetalert::alert')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('layouts.page-title')
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <p class="text-muted">Use <code>&lt;select&gt;</code> attribute with numerous options to show value with choice's option.</p> --}}
                        <div class="live-preview">
                            <div class="row">
                                <form action="{{route('admin.merchant.add.user')}}" method="POST">
                                    @csrf
                                    <div class="col-lg-12">
                                        <select name="institution_name" class="form-select mb-3" aria-label="Default select example">
                                            <option selected disabled>Institution </option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->institution_name }}">{{ $user->institution_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <input autocomplete="off" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname"  placeholder="Firstname" required>
                                        @error('firstname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ __('Firstname is required') }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <input autocomplete="off" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname"  placeholder="Lastname" required>
                                        @error('lastname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ __('Lastname is required') }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div>
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
{{-- <script src="{{ asset('assets/js/plugins.js') }}"></script> --}}
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/libs/list.js/list.min.js')}}"></script>
<script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js')}}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

@endsection
@endsection