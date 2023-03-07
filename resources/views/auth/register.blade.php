@extends('layouts.app')

@section('content')
{!! Toastr::message() !!}
<section class="fxt-template-animation fxt-template-layout11">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-6 col-lg-7 col-sm-12 col-12 fxt-bg-color">
                <div class="fxt-content">
                    <div class="fxt-header">
                        <a href="login-11.html" class="fxt-logo"><img src="{{ asset('login/img/freshpay.png') }}" alt="Logo"></a>
                        <p>Login into your account</p>
                    </div>
                    <div class="fxt-form">
                        <form method="POST" action="{{route('register')}}">
                            @csrf
                            <div class="form-group">
                                <div class="fxt-transformY-50 fxt-transition-delay-1">
                                    <input type="text" id="merchant_code" class="form-control @error('merchant_code') is-invalid @enderror" value="{{ old('merchant_code') }}" name="merchant_code" placeholder="Merchant Code" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fxt-transformY-50 fxt-transition-delay-1">
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
                            </div>
                            <div class="form-group">
                                <div class="fxt-transformY-50 fxt-transition-delay-4">
                                    <button type="submit" class="fxt-btn-fill">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
