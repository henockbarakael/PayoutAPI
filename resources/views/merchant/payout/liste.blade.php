@extends('layouts.master')
@section('title','Liste - Marchand')
@section('page','Bulk Payment')
@section('page-inner','Transaction list')
@section('content')
<style type="text/css">
</style>
{!! Toastr::message() !!}
<div class="page-content">
    <div class="container-fluid">
        @include('sweetalert::alert')
        <!-- start page title -->
        @include('layouts.page-title')
        <!-- end page title -->

        <section id="loading">
            <div id="loading-content"></div>
        </section>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                            <form id="fupForm" enctype="multipart/form-data" method="POST">

                                <div class="row g-3 mb-3">
                                    <span class="text-danger" id="image-input-error"></span>
                                    <div class="col-xxl-2 col-lg-5">
                                        <input required  class="form-control @error('file') is-invalid @enderror" type="file" name="customFile" id="customFile">
                                        {{-- @error('customFile') --}}
                                        <span id="error-file" class="invalid-feedback" role="alert">
                                            <strong></strong>
                                        </span>
                                        {{-- @enderror --}}
                                    </div>
                                    <div class="col-xxl-2 col-lg-2">
                                        <label for="no_transaction" class="form-label mt-2">Total Transactions</label>
                                    </div>
                                    <div class="col-xxl-2 col-lg-3">
                                        <input required type="text" class="form-control @error('no_transaction') is-invalid @enderror" name="no_transaction" id="no_transaction" placeholder="">
                                        {{-- @error('no_transaction') --}}
                                        <span id="error-trx" class="invalid-feedback trans" role="alert">
                                            <strong></strong>
                                        </span>
                                        {{-- @enderror --}}
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-1 col-lg-2">
                                        <button type="submit" id="file-upload" class="btn btn-primary w-100">Submit</button>
                                    </div>

                                    <div style="display:none;" class="live-preview" id="myprogress">
                                        <div class="progress animated-progress custom-progress progress-label">
                                            <div class="progress-bar bg-success" role="progressbar"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="label_progress"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        
                        <!--end row-->
                    </div>
                </div>
                <div class="card" id="customerList">
                    <div class="card-header border-bottom-dashed">

                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Transacton List</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                                    <button class="btn btn-danger btn-border btn-sm delete-all">Delete All</button>
                                    <button style="display: none" type="button" id="pay-all" class="btn btn-secondary btn-border btn-sm pay-all" data-url="">Pay All</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session()->has('failures'))

                            <table class="display table table-danger table-bordered myshadow" id="fixed-header" style="width:100%">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th>Row</th>
                                        <th>Attribute</th>
                                        <th>Errors</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach (session()->get('failures') as $validation)
                                    <tr>
                                        <td>{{ $validation->row() }}</td>
                                        <td>{{ $validation->attribute() }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($validation->errors() as $e)
                                                    <li>{{ $e }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            {{ $validation->values()[$validation->attribute()] }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @endif
                        <table class="display table table-bordered myshadow table_reload" id="fixed-header" style="width:100%">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th hidden scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_all" checked>
                                        </div>
                                    </th>
                                    <th class="text-center">#</th>
                                    <th class="text-left">Customer Numbers</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Currency</th>
                                    <th class="text-left">Status</th>
                                    <th class="text-left">Created at</th>
                                </tr>
                            </thead>
                            <tbody class="tbody-table">
                                @if($payouts->count())
                                @foreach ($payouts as $key => $item)
                                
                                <tr id="tr_{{$item->id}}">
                                    <th scope="row" hidden>
                                        <div class="form-check">
                                            <input checked class="form-check-input checkbox" type="checkbox" data-id="{{$item->id}}">
                                        </div>
                                    </th>
                                    <td class="text-center">{{ $item->id }}</td>
                                    <td class="text-left">{{ $item->credit_account }}</td>
                                    <td class="text-center">{{ $item->amount }}</td>
                                    <td class="text-center">{{ $item->currency }}</td>
                                    @if ($item->status == "Pending" )
                                        <td class="text-left"><span class="badge rounded-pill badge-soft-warning">{{$item->status}}</span></td>
                                    @else
                                        <td class="text-left"><span class="badge rounded-pill badge-soft-success">{{$item->status}}</span></td>
                                    @endif
                                    <td class="text-left">{{ $item->created_at }}</td>
                                </tr>
                                @endforeach
                                @endif
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
    <!-- JAVASCRIPT -->
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
    // $('.loaders').show();
        var $loading = $('.loaders').hide();
        $(document).ajaxStart(function() {
            $loading.show();
        });
        $(document).ajaxStop(function() {
            $loading.hide();
        });
          
    </script>
    <script>

        $(document).ready( function() {
            // console.log(document.querySelectorAll('.tbody-table').rows.length);
            // const isEmpty = document.querySelectorAll('.tbody-table').rows.length;
            // if (isEmpty == 0) {
            //     $("#pay-all").hide();
            // }
            // else{
            //     $("#pay-all").show();
            // }

            var table = $('#fixed-header').DataTable();

            if ( ! table.data().any() ) {
                $("#pay-all").hide();
            }
            else{
                $("#pay-all").show();
            }
            var label_progress = $('.label_progress');

            $('form').ajaxForm({
                beforeSend:function(){
                        var percentage = '0';
                        $("#myprogress").show();
                        label_progress.html(percentage+'%');
                    },   

                    uploadProgress: function (event, position, total, percentComplete) {
                        var percentage = percentComplete;
                        label_progress.html(percentage+'%');
                        $('.progress .progress-bar').css("width", percentage+'%', function() { 
                          return $(this).attr("aria-valuenow", percentage) + "%";
                        })
                    },
                    success: function(response){
                        if (response.success==true) {
                            $('#fupForm')[0].reset();
                            $("#pay-all").show();
                            // alert(response.message);
                            toastr.success(response.message, 'Success Alert', {
                                timeOut: 1800,
                                fadeOut: 1800,
                                onHidden: function () {
                                // window.location.reload();
                                $('#fixed-header').load(document.URL +  ' #fixed-header');
                                }
                            });
                            // location.reload();
                        }
                        else{
                            $('#fupForm')[0].reset();
                            $("#pay-all").hide();
                            // alert(response.message);
                            toastr.error(response.message, 'Error Alert', {
                                timeOut: 1800,
                                fadeOut: 1800,
                                onHidden: function () {
                                window.location.reload();
                                }
                            });
                            // location.reload();
                        }
                    
                    },
                    resetForm: true,
                    complete: function (xhr) {
                        console.log('File has uploaded');
                        // $("#myprogress").hide();
                    },
                    
            });
            
            // $('#fupForm').submit(function(e) {

            //     e.preventDefault();
            //     var data = new FormData($(this)[0]);
            //     $.ajax({
            //         url:"{{ route('merchant.import') }}",
            //         method:"POST",
            //         data: new FormData(this),
            //         contentType: false,
            //         cache: false,
            //         processData: false,
            //         success: function(response){
            //             if (response.success==true) {
            //                 $('#fupForm')[0].reset();
            //                 $("#pay-all").show();
            //                 // alert(response.message);
            //                 toastr.success(response.message, 'Success Alert', {
            //                     timeOut: 1800,
            //                     fadeOut: 1800,
            //                     onHidden: function () {
            //                     // window.location.reload();
            //                     }
            //                 });
            //                 // location.reload();
            //             }
            //             else{
            //                 $('#fupForm')[0].reset();
            //                 $("#pay-all").hide();
            //                 // alert(response.message);
            //                 toastr.error(response.message, 'Error Alert', {
            //                     timeOut: 1800,
            //                     fadeOut: 1800,
            //                     onHidden: function () {
            //                     window.location.reload();
            //                     }
            //                 });
            //                 // location.reload();
            //             }
                    
            //         },
            //         resetForm: true
            //     });
            // });
            $('.delete-all').on('click', function(e) {
                var idsArr = [];  
                $(".checkbox:checked").each(function() {  
                    idsArr.push($(this).attr('data-id'));
                });  
                var strIds = idsArr.join(","); 
                console.log(strIds);
                Swal.fire({
                    title: 'Are you sure?',
                    text:'It will permanently deleted !',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete all!',
                    denyButtonText: `Don't delete`,
                    }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('merchant.payout.delete.multiple') }}",
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids='+strIds,
                            success: function (data) {
                                if (data['status']==true) {
                                    $(".checkbox:checked").each(function() {  
                                        $(this).parents("tr").remove();
                                    });
                                    toastr.success(data['message'], 'Success Alert', {
                                        timeOut: 1800,
                                        fadeOut: 1800,
                                        onHidden: function () {
                                            window.location.reload();
                                        }
                                    });
                                } 
                                else {
                                    // alert('Whoops Something went wrong!!');
                                    Swal.fire('Whoops Something went wrong!!', '', 'info')
                                }
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });
                        // Swal.fire('Delete all!', '', 'success')
                    } else if (result.isDenied) {
                        Swal.fire('Denied!', '', 'info')
                    }
                })
                 
            });

            $('#pay-all').on('click', function(e) {
                var idsArr = [];  
                $(".checkbox:checked").each(function() {  
                    idsArr.push($(this).attr('data-id'));
                });  
                var strIds = idsArr.join(","); 
                console.log(strIds);
                Swal.fire({
                    title: 'Do you want Continue ?',
                    text:'You will now proceed with the bulk payment.',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: `No`,
                    }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('merchant.paiement.multiple') }}",
                            type: 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids='+strIds,
                            success: function (data) {
                                if (data['status']==true) {
                                    $(".checkbox:checked").each(function() {  
                                        $(this).parents("tr").remove();
                                    });
                                    toastr.success(data['message'], 'Success Alert', {
                                        timeOut: 1800,
                                        fadeOut: 1800,
                                        onHidden: function () {
                                            window.location.reload();
                                        }
                                    });
                                } 
                                else {
                                    // alert('Whoops Something went wrong!!');
                                    Swal.fire('Whoops Something went wrong!!', '', 'info')
                                }
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });
                        // Swal.fire('Delete all!', '', 'success')
                    } else if (result.isDenied) {
                        Swal.fire('Denied!', '', 'info')
                    }
                })
                 
            });
            $.ajaxSetup({
                headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    @endsection
@endsection