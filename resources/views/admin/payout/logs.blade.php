@extends('layouts.master')
@section('title','Payout report')
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
                        {{-- <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%"> --}}
                        <table class="table nowrap align-middle" id="buttons-datatables" style="width:100%">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th class="text-left">#</th>
                                    <th class="text-left">Phone number</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Currency</th>
                                    <th class="text-left">Operator</th>
                                    <th class="text-left">Reference</th>
                                    <th class="text-left">Status</th>
                                    <th class="text-left">Created_at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $key => $item)
                                <tr>
                                    <td class="text-left">{{ $item->id}}</td>
                                    <td class="text-left">{{ $item->destination_account}}</td>
                                    <td class="text-left">{{ $item->amount }}</td>
                                    <td class="text-left">{{ $item->currency }}</td>
                                    <td class="text-left">{{ $item->debit_channel }}</td>
                                    <td class="text-left">{{ $item->trans_id }}</td>
                                    <td class="text-left">{{ $item->status }}</td>
                                    <td class="text-left">{{ $item->created_at }}</td>
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