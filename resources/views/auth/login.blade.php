@extends('layouts.app')
@section('title','FreshPay Bulk Payment | Login')
@section('content')
{!! Toastr::message() !!}
<section class="fxt-template-animation fxt-template-layout11">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-6 col-lg-7 col-sm-12 col-12 fxt-bg-color">
                <div class="fxt-content">
                    <div class="fxt-header">
                        <a href="{{route('login')}}" class="fxt-logo"><img src="{{ asset('login/img/freshpay.png') }}" alt="Logo"></a>
                        <p>Login into your account</p>
                    </div>
                    <div class="fxt-form">
                        <form action="{{route('login')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="fxt-transformY-50 fxt-transition-delay-1">
                                    <input type="text" id="firstname" class="form-control @error('firstname') is-invalid @enderror" value="{{ old('firstname') }}" name="firstname" placeholder="Username" required="required">
                                    @error('firstname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ __('firstname is required') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fxt-transformY-50 fxt-transition-delay-2">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" placeholder="********" required="required">
                                    <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ __('Password is required') }}</strong>
                                         </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fxt-transformY-50 fxt-transition-delay-4">
                                    <button type="submit" class="fxt-btn-fill">Log in</button>
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
