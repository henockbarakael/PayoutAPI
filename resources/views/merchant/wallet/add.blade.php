@extends('layouts.master')
@section('title','Wallet Topup')
@section('page','Wallet')
@section('page-inner','Wallet Top-up')
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
                        <h4 class="card-title mb-0 flex-grow-1">Wallet Top-Up</h4>
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
                            <form action="{{route('merchant.wallet.topup')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="wallet_code" class="form-label">Wallet_code</label>
                                        <select class="form-select mb-3 @error('wallet_code') is-invalid @enderror" aria-label="Default select example" name="wallet_code">
                                            <option selected disabled>Select wallet </option>
                                            @foreach ($wallet as $name)
                                                <option value="{{ $name->wallet_code }}">{{ $name->wallet_code }}</option>
                                            @endforeach
                                        </select>
                                        @error('wallet_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="amountinput" class="form-label">Amount</label>
                                            <input name="amount" type="text" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter account amount" id="amountinput">
                                            @error('amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="method" class="form-label">Method</label>
                                        <select class="form-select mb-3 @error('method') is-invalid @enderror" aria-label="Default select example" name="method">
                                            <option selected disabled>Choose a method </option>
                                            <option value="credit">Credit</option>
                                            <option value="debit">Debit </option>
                                        </select>
                                        @error('method')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Top-Up</button>
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
