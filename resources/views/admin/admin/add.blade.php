@extends('layouts.master')
@section('title','Formulaire - Marchand')
@section('page','Admin')
@section('page-inner','Ajouter un marchand')
@section('content')
<div class="page-content">
    {!! Toastr::message() !!}
    <div class="container-fluid">
        <!-- start page title -->
        @include('layouts.page-title')
        <!-- end page title -->
        <div class="row">
            <div class="col-xxl-6">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Create Admin</h4>
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="form-grid-showcode" class="form-label text-muted">Show Code</label>
                                <input class="form-check-input code-switcher" type="checkbox" id="form-grid-showcode">
                            </div>
                        </div>
                    </div><!-- end card header -->
        
                    <div class="card-body">
                        {{-- <p class="text-muted">More complex forms can be built using our grid classes. Use these for form layouts that require multiple columns, varied widths, and additional alignment options. <span class="fw-medium">Requires the <code>$enable-grid-classes</code> Sass variable to be enabled</span> (on by default).</p> --}}
                        <div class="live-preview">
                            <form action="{{route('admin.merchant.add')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="nameInput" class="form-label text-muted">Name</label>
                                            <input name="name" type="text" class="form-control" placeholder="Enter admin name" id="nameInput">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label text-muted">Email</label>
                                            <input name="email" type="email" class="form-control" placeholder="Enter admin email" id="emailInput">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label text-muted">Phone</label>
                                            <input name="phone" type="tel" class="form-control" placeholder="Enter admin phone" id="phonenumberInput">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="firstNameinput" class="form-label text-muted">First Name</label>
                                            <input name="firstname" type="text" class="form-control" placeholder="Enter account firstname" id="firstNameinput">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="lastNameinput" class="form-label text-muted">Last Name</label>
                                            <input name="lastname" type="text" class="form-control" placeholder="Enter account lastname" id="lastNameinput">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="recruterInput" class="form-label text-muted">Recruter</label>
                                            <input name="recruter" type="text" class="form-control" placeholder="Enter recruter" id="recruterInput">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="comissionInput" class="form-label text-muted">Comission</label>
                                            <input name="comission" type="text" class="form-control" placeholder="Enter comission" id="recruterInput">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="merchant_codeInput" class="form-label text-muted">Merchant_Code</label>
                                            <input name="merchant_code" type="text" class="form-control" placeholder="Enter admin_code" id="recruterInput">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <div class="d-none code-view">
                            <pre class="language-markup" style="height: 375px;">
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end col -->
    </div>
    <!-- container-fluid -->
</div>
@endsection
