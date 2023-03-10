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
                    <div class="card-header">
                        {{-- <h5 class="card-title mb-0">All Merchant</h5> --}}
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">All Merchant</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                                    <button class="btn btn-success btn-border btn-sm add-merchant" data-bs-toggle="modal" data-bs-target="#addMerchant">Add Merchant</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table nowrap align-middle" id="merchant_list" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th hidden>ID</th>
                                    <th>Institution</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Phone</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $item)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td hidden class="id">{{ $item->id }}</td>
                                    <td>{{ $item->institution_name }}</td>
                                    <td>{{ $item->firstname }}</td>
                                    <td>{{ $item->lastname }}</td>
                                    <td>{{ $item->phone_number }}</td>
                                    <td class="old_password">{{ $item->salt }}</td>
                                    <td>{{ $item->role_name }}</td>
                                    <td>{{ $item->user_status }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-soft-info userUpdate" data-bs-toggle="modal" data-bs-target="#editUser"><i class="ri-pencil-fill align-bottom text-muted"></i></a>
                                        <a class="btn btn-sm btn-soft-danger remove-item-btn userDelete" data-bs-toggle="modal" data-bs-target="#deleteUser"><i class="ri-delete-bin-fill align-bottom text-muted"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addMerchant" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 overflow-hidden">
                    <div class="modal-body p-5">
                        <h5 class="mb-3">New Merchant</h5>
                        <form method="POST" action="{{route('admin.add.merchant')}}">
                            @csrf
                            <input type="hidden" name="user_id" id="e_id" value="">
                            <div class="mb-2">
                                <input type="text" id="merchant_code" class="form-control @error('merchant_code') is-invalid @enderror" value="{{ old('merchant_code') }}" name="merchant_code" placeholder="Merchant code" required="required">
                                @error('merchant_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('Merchant code is required') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <input type="text" id="merchant_secrete" class="form-control @error('merchant_secrete') is-invalid @enderror" value="{{ old('merchant_secrete') }}" name="merchant_secrete" placeholder="Merchant secrete" required="required">
                                @error('merchant_secrete')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('Merchant secrete is required') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <input required  class="form-control @error('avatar') is-invalid @enderror" type="file" name="avatar" id="avatar">
                                @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('Avatar is required') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <input required  class="form-control @error('logo') is-invalid @enderror" type="file" name="logo" id="logo">
                                @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('Logo is required') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <div class="modal fade" id="editUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 overflow-hidden">
                    <div class="modal-body p-5">
                        <h5 class="mb-3">Change Password</h5>
                        <form method="POST" action="{{route('admin.update-password')}}">
                            @csrf
                            <input type="hidden" name="user_id" id="e_id" value="">
                            <div class="mb-2">
                                <input autocomplete="off" type="text" class="form-control @error('old_password') is-invalid @enderror" name="old_password" id="e_old_password" value="" required>
                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('Password is required') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input autocomplete="new_password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="Enter new password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('Password is required') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <div class="modal fade" id="deleteUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                        </lord-icon>

                        <div class="mt-4">
                            <h4 class="mb-3">You've made it!</h4>
                            <p class="text-muted mb-4"> The transfer was not successfully received by us. the email of the recipient wasn't correct.</p>
                            <div class="hstack gap-2 justify-content-center">
                                <a href="javascript:void(0);" class="btn btn-link shadow-none link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                <a href="javascript:void(0);" class="btn btn-success">Completed</a>
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