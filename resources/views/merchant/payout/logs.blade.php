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
                                    <th class="text-left">Amount</th>
                                    <th class="text-left">Action</th>
                                    <th class="text-left">Merchant Reference</th>
                                    <th class="text-left">Freshpay Reference</th>
                                    <th class="text-left">Telcom Reference</th>
                                    <th class="text-left">Status</th>
                                    <th class="text-left">Description</th>
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
                                    <td class="text-left">{{ $item->status_description }}</td>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/plugins.js') }}"></script> --}}
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="{{ asset('assets/libs/list.js/list.min.js')}}"></script>
    <script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js')}}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ asset('assets/js/pages/datatables.init.js')}}"></script>
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
                            filename: 'Payment.History.' + n
                        },
                        {
                            extend: 'excel',
                            filename: 'Payment.History.' + n
                        },
                        {
                            extend: 'pdf',
                            filename: 'Payment.History.' + n
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