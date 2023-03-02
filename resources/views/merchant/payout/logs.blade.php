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
                        <table class="table nowrap align-middle" id="payout" style="width:100%">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th class="text-left">Customer</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-left">Action</th>
                                    <th class="text-left">Transaction_ID</th>
                                    <th class="text-left">Reference FP</th>
                                    <th class="text-left">Telco. Ref</th>
                                    <th class="text-left">Status</th>
                                    <th class="text-left">Created_at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $key => $item)
                                <tr>
                                    <td class="text-left">{{ $item->customer_number}}</td>
                                    <td class="text-left">{{ $item->amount." ".$item->currency }}</td>
                                    <td class="text-left">{{ $item->action }}</td>
                                    <td class="text-left">{{ $item->reference }}</td>
                                    <td class="text-left">{{ $item->transaction_id }}</td>
                                    <td class="text-left">{{ $item->telco_reference }}</td>
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
    <script type="text/javascript">
        $(document).ready(function () {
            var today = new Date();
            var n = today.getDate().toString()+(today.getMonth()+1)+today.getFullYear();
            $('#payout').DataTable({
                scrollX: true,
                dom:"Bfrtip",
                order: [[0, 'desc']],
                buttons: [
                        {
                            extend: 'csv',
                            filename: 'Payout_report_' + n
                        },
                        {
                            extend: 'excel',
                            filename: 'Payout_report_' + n
                        },
                        {
                            extend: 'pdf',
                            filename: 'Payout_report_' + n
                        }
                    ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
            });
        });
    </script>
    @endsection
@endsection