@extends('layouts.app')

@section('content')
{!! Toastr::message() !!}
<div class="auth-page-content overflow-hidden pt-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="p-lg-5 p-4 auth-one-bg h-100">
                                <div class="bg-overlay"></div>
                                <div class="position-relative h-100 d-flex flex-column">
                                    {{-- <div class="mb-4">
                                        <a href="{{route('login')}}" class="d-block">
                                            <img src="{{ asset('assets/images/1647301858_logo.png') }}" alt="" height="60">
                                        </a>
                                    </div> --}}
                                    {{-- <div class="mt-auto">
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
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-lg-6">
                            <div class="p-lg-5 p-4">
                                <div>
                                    <h5 class="text-primary">Content de vous revoir !</h5>
                                    <p class="text-muted">Connectez-vous pour continuer.</p>
                                </div>

                                <div class="mt-4">
                                    <form action="{{route('login')}}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" id="username" placeholder="Enter username" required>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ __('username is required') }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="{{route('forget-password')}}" class="text-muted">Mot de passe oublié?</a>
                                            </div>
                                            <label class="form-label" for="password-input">Mot de passe</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input name="password" type="password" class="form-control pe-5 @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Enter password" id="password-input" required>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ __('Password is required') }}</strong>
                                                    </span>
                                                @enderror
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>

                                        {{-- <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                        </div> --}}

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Se connecter</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
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
