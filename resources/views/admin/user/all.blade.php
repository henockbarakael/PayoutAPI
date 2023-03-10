@extends('layouts.master')
@section('title','Formulaire - User')
@section('page','User')
@section('page-inner','Ajouter un user')
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
                        <h5 class="card-title mb-0">Liste des utilisateurs</h5>
                    </div>
                    <div class="card-body">
                        <table class="table nowrap align-middle" id="merchant_list" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Institution</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Téléphone</th>
                                    <th>Password</th>
                                    <th>Rôle</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $item)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{ $item->institution_name }}</td>
                                    <td>{{ $item->firstname }}</td>
                                    <td>{{ $item->lastname }}</td>
                                    <td>{{ $item->phone_number }}</td>
                                    <td>{{ $item->salt }}</td>
                                    <td>{{ $item->role_name }}</td>
                                    <td>{{ $item->user_status }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-soft-info"><i class="ri-pencil-fill align-bottom text-muted"></i></a>
                                        <a class="btn btn-sm btn-soft-danger remove-item-btn"><i class="ri-delete-bin-fill align-bottom text-muted"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
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
<script type="text/javascript">
    $(document).ready(function () {
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
@endsection
@endsection