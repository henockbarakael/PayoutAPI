@extends('layouts.master')
@section('title','Airtime | Achat Crédit')
@section('page','Airtime')
@section('page-inner','Achat Crédit')
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
                        <h4 class="card-title mb-0 flex-grow-1">Achat Crédit</h4>
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
                            <form action="{{route('merchant.transaction.add')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="amountinput" class="form-label">Amount</label>
                                            <input name="amount" type="text" class="form-control @error('amount') is-invalid @enderror" placeholder="Insert amount" id="amountinput">
                                            @error('amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="action" class="form-label">Action</label>
                                        <select class="form-select mb-3 @error('action') is-invalid @enderror" aria-label="Default select example" name="action">
                                            <option selected disabled>Choose an action </option>
                                            <option value="payout">Payout</option>
                                            <option value="deposit">Deposit </option>
                                        </select>
                                        @error('action')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="currencyinput" class="form-label">Currency</label>
                                            <input disabled name="currency" type="text" class="form-control @error('currency') is-invalid @enderror" value="USD" id="currencyinput">
                                            @error('currency')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="referenceinput" class="form-label">Reference</label>
                                            <input name="reference" type="text" class="form-control @error('reference') is-invalid @enderror" placeholder="Enter merchant reference" id="referenceinput">
                                            @error('reference')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="credit_channel" class="form-label">Network</label>
                                        <select class="form-select mb-3 @error('credit_channel') is-invalid @enderror" aria-label="Default select example" name="credit_channel">
                                            <option selected disabled>Choose a network </option>
                                            <option value="vodacom">Vodacom </option>
                                            <option value="airtel">Airtel </option>
                                            <option value="orange">Orange </option>
                                        </select>
                                        @error('credit_channel')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="merchant_codeinput" class="form-label">Merchant_Code</label>
                                            <input name="merchant_code" type="text" class="form-control @error('merchant_code') is-invalid @enderror" placeholder="Enter merchant code" id="merchant_codeinput">
                                            @error('merchant_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="callback_urlinput" class="form-label">Callback URL</label>
                                            <input name="callback_url" type="text" class="form-control @error('callback_url') is-invalid @enderror" placeholder="Enter callback url" id="callback_urlinput">
                                            @error('callback_url')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="secrete_key" class="form-label">Secrete Key</label>
                                            <input name="secrete_key" type="text" class="form-control @error('secrete_key') is-invalid @enderror" placeholder="Insert secrete_key" id="secrete_keyinput">
                                            @error('secrete_key')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
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
