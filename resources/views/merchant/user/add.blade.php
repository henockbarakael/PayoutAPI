@extends('layouts.master')
@section('title','Formulaire - User')
@section('page','User')
@section('page-inner','Ajouter un user')
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
                        <h4 class="card-title mb-0 flex-grow-1">Create User</h4>
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
                            <form action="{{route('merchant.user.add')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstNameinput" class="form-label">First Name</label>
                                            <input name="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" placeholder="Enter account firstname" id="firstNameinput">
                                            @error('firstname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="lastNameinput" class="form-label">Last Name</label>
                                            <input name="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" placeholder="Enter account lastname" id="lastNameinput">
                                            @error('lastname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-6">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select mb-3 @error('role_name') is-invalid @enderror" aria-label="Default select example" name="role_name">
                                            <option selected disabled>Choisir un rôle </option>
                                            @foreach ($role as $name)
                                                <option value="{{ $name->role_type }}">{{ $name->role_type }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-6">
                                        <label for="role" class="form-label">Status</label>
                                        <select class="form-select mb-3 @error('status') is-invalid @enderror" aria-label="Default select example" name="status">
                                            <option selected disabled>Choisir un status </option>
                                            @foreach ($status_user as $name)
                                                <option value="{{ $name->type_name}}">{{ $name->type_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
