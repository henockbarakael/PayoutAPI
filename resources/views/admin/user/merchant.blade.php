@extends('layouts.master')
@section('title','Merchant List')
@section('page','Merchant')
@section('page-inner','Merchant List')
@section('content')
@include('sweetalert::alert')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('layouts.page-title')
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted">Use <code>&lt;select&gt;</code> attribute with numerous options to show value with choice's option.</p>
                        <div class="live-preview">
                            <div class="row">
                                <div class="col-lg-12">
                                    <select class="form-select mb-3" aria-label="Default select example">
                                        <option selected disabled>Institution </option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->institution_name }}">{{ $user->institution_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <input autocomplete="off" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname"  value="" required>
                                    @error('firstname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ __('Password is required') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <input autocomplete="off" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname"  value="" required>
                                    @error('lastname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ __('Password is required') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
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
<script src="{{ asset('assets/js/pages/modal.init.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {

        // var old_password = $('#old_password');
        // old_password.prop('type', 'text');
        // old_password.removeAttr('autocomplete');

        // var password = $('#password');
        // password.prop('type', 'text');
        // password.removeAttr('autocomplete');

        var today = new Date();
        var n = today.getDate().toString()+(today.getMonth()+1)+today.getFullYear();
        $('#merchant_list').DataTable({
            scrollX: true,
            dom:"Bfrtip",
            order: [[0, 'desc']],
            buttons: [
                    {
                        extend: 'csv',
                        filename: 'Merchant_List.' + n
                    },
                    {
                        extend: 'excel',
                        filename: 'Merchant_List.' + n
                    },
                    {
                        extend: 'pdf',
                        filename: 'Merchant_List.' + n
                    }
                ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
    });
</script>
<script>
    $(document).on('click','.userUpdate',function()
    {
        var _this = $(this).parents('tr');
        $('#e_id').val(_this.find('.id').text());
        $('#e_old_password').val(_this.find('.old_password').text());     
    });
</script>
@endsection
@endsection