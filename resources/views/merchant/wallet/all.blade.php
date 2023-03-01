@extends('layouts.master')
@section('title','Liste - Wallet')
@section('page','Wallet')
@section('page-inner','Wallet List')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        @include('layouts.page-title')
        <!-- end page title -->

        {{-- <div class="alert alert-danger" role="alert">
            This is <strong>Datatable</strong> page in wihch we have used <b>jQuery</b> with cnd link!
        </div> --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="customerList">
                    <div class="card-body">
                        <div>
                            <table id="buttons-datatables" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        
                                        <th class="sort" data-sort="wallet_code">Wallet_code</th>
                                        <th class="text-center">Merchant_code</th>
                                        <th class="" hidden data-sort="wallet_code">Wallet_id</th>
                                        <th class="text-center">Account_id</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Currency</th>
                                        <th class="text-center">Date created</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wallet as $key => $item)
                                    <tr>
                                        {{-- <td>{{++$key}}</td> --}}
                                        <td class="wallet_code">{{ $item->wallet_code }}</td>
                                        <td class="merchant_code text-center">{{ $item->merchant_code }}</td>
                                        <td class="id" hidden><a href="javascript:void(0);" class="fw-medium link-primary">{{ $item->id }}</a></td>
                                        <td class="account_id text-center">{{ $item->account_id }}</td>
                                        <td class="amount text-center">{{ $item->amount }}</td>
                                        <td class="currency text-center">{{ $item->currency }}</td>
                                        <td class="created_at text-center"><span class="badge badge-soft-success text-uppercase">{{ $item->created_at }}</span></td>
                                        <td class="text-center"><a href="#" class="badge badge-soft-success">Top Up</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>                                
                        </div>
                        <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light p-3">
                                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                    </div>
                                    <form action="#">
                                        <div class="modal-body">
                                            <input type="hidden" id="id-field" />

                                            <div class="mb-3" id="modal-id" style="display: none;">
                                                <label for="id-field1" class="form-label">ID</label>
                                                <input type="text" id="id-field1" class="form-control" placeholder="ID" readonly />
                                            </div>

                                            <div class="mb-3">
                                                <label for="customername-field" class="form-label">Customer Name</label>
                                                <input type="text" id="customername-field" class="form-control" placeholder="Enter name" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="email-field" class="form-label">Email</label>
                                                <input type="email" id="email-field" class="form-control" placeholder="Enter email" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="phone-field" class="form-label">Phone</label>
                                                <input type="text" id="phone-field" class="form-control" placeholder="Enter phone no." required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="date-field" class="form-label">Joining Date</label>
                                                <input type="date" id="date-field" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" required placeholder="Select date" />
                                            </div>

                                            <div>
                                                <label for="status-field" class="form-label">Status</label>
                                                <select class="form-control" data-choices data-choices-search-false name="status-field" id="status-field">
                                                    <option value="">Status</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Block">Block</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success" id="add-btn">Add Customer</button>
                                                <button type="button" class="btn btn-success" id="edit-btn">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mt-2 text-center">
                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                <h4>Are you sure ?</h4>
                                                <p class="text-muted mx-4 mb-0">Are you sure you want to remove this record ?</p>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn w-sm btn-danger" id="delete-record">Yes, Delete It!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end modal -->
                    </div>
                </div>

            </div>
            <!--end col-->
        </div>
        {{-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <div class="mt-4">
                            <h4 class="mb-3">Merchant_secrete</h4>
                            <input type="text" class="form-control" readonly id="e_secrete" value="">
                            {{-- <p class="mb-4 text-mute">{{$item->merchant_secrete}}</p>
                            <div class="hstack gap-2 justify-content-center">
                                <a href="javascript:void(0);" class="btn btn-link shadow-none link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        
    </div>
    <!-- container-fluid -->
</div>
@section('script')
<script>
    $(function () {
      $("#").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
</script>
<script type="text/javascript">
    var _this = $(this).parents('tr');
    $('#e_id').val(_this.find('.id').text());
    $('#e_secrete').val(_this.find('.secrete').text());

            // var secrete = document.getElementById("secrete").value;
   
    // function myFunction() {
    // // text += index + ": " + item + "<br>"; 
    // document.getElementById("storage").value = secrete;
    // 
</script>
@endsection
@endsection