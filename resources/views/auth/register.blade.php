@extends('layouts.app')

@section('content')
{!! Toastr::message() !!}
<div class="auth-page-content overflow-hidden pt-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden m-0">
                    <div class="row justify-content-center g-0">
                        <div class="col-lg-6">
                            <div class="p-lg-5 p-4 auth-one-bg h-100">
                                <div class="bg-overlay"></div>
                                <div class="position-relative h-100 d-flex flex-column">
                                    <div class="mb-4">
                                        <a href="{{route('login')}}" class="d-block">
                                            <img src="{{ asset('assets/images/1647301858_logo.png') }}" alt="" height="60">
                                        </a>
                                    </div>
                                    <div class="mt-auto">
                                        <div class="mb-3">
                                            <i class="ri-double-quotes-l display-4 text-success"></i>
                                        </div>

                                        <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators">
                                                <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                            </div>
                                            <div class="carousel-inner text-center text-white pb-5">
                                                <div class="carousel-item active">
                                                    <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>
                                                </div>
                                                <div class="carousel-item">
                                                    <p class="fs-15 fst-italic">" The theme is really great with an amazing customer support."</p>
                                                </div>
                                                <div class="carousel-item">
                                                    <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end carousel -->

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="p-lg-5 p-4">
                                <div>
                                    <h5 class="text-primary">Register Account</h5>
                                    <p class="text-muted">Get your Free Freshpay account now.</p>
                                </div>

                                <div class="mt-4">
                                    <form class="needs-validation" method="POST" action="{{route('register')}}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="merchant_code" class="form-label">Merchant Code <span class="text-danger">*</span></label>
                                            <input name="merchant_code" type="text" class="form-control @error('merchant_code') is-invalid @enderror" value="{{ old('merchant_code') }}" id="merchant_code" placeholder="Enter merchant_code address" required>
                                            @error('merchant_code')
                                            <div class="invalid-feedback">
                                                Please enter merchant code
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
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

                                        {{-- <div class="mb-3">
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input name="password" type="password" class="form-control pe-5 password-input @error('password') is-invalid @enderror" value="{{ old('password') }}" onpaste="return false" placeholder="Enter password" id="password-input" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                @error('password')
                                                <div class="invalid-feedback">
                                                    Please enter password
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                            <h5 class="fs-13">Password must contain:</h5>
                                            <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                            <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)</p>
                                            <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                            <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>
                                        </div> --}}

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign Up</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="mt-3 text-center">
                                    <p class="mb-0">Already have an account ? <a href="{{route('login')}}" class="fw-semibold text-primary text-decoration-underline"> Signin</a> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->

        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
@endsection
