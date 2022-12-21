@extends('layouts.master')
@section('title','Liste - Marchand')
@section('page','PAYOUT REPORT')
@section('page-inner','Payout Logs')
@section('content')
{!! Toastr::message() !!}
<div class="page-content">
    <div class="container-fluid">
        @include('sweetalert::alert')
        <!-- start page title -->
        @include('layouts.page-title')
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="customerList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">PAYOUT LOGS</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="display table table-bordered" id="buttons-datatables" style="width:100%">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th class="text-left">#</th>
                                    <th class="text-left">Destination account</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Currency</th>
                                    <th class="text-left">Channel</th>
                                    <th class="text-left">Telco Ref.</th>
                                    <th class="text-left">Switch Ref.</th>
                                    <th class="text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $key => $item)
                                <tr>
                                    <td class="text-left">{{ $item->id}}</td>
                                    <td class="text-left">{{ $item->destination_account}}</td>
                                    <td class="text-center">{{ $item->amount }}</td>
                                    <td class="text-center">{{ $item->currency }}</td>
                                    <td class="text-center">{{ $item->debit_channel }}</td>
                                    <td class="text-left">{{ $item->financial_institution_transaction_id }}</td>
                                    <td class="text-left">{{ $item->trans_id }}</td>
                                    <td class="text-left">{{ $item->status }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>        
                    </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
    </div>
</div>
    @section('script')
    @endsection
@endsection