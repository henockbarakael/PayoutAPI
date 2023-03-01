@extends('layouts.master')
@section('title','Fiche de remboursement')
@section('page','REMBOURSEMENTS')
@section('page-inner','Fichier de remboursements')
@section('content')
<style type="text/css">
    .loading {
        z-index: 20;
        position: absolute;
        top: 0;
        left:-5px;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.4);
    }
    .loading-content {
        position: absolute;
        border: 16px solid #f3f3f3;
        border-top: 16px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        top: 40%;
        left:50%;
        animation: spin 2s linear infinite;
        }
          
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
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

        {{-- <div class="alert alert-danger" role="alert">
            This is <strong>Datatable</strong> page in wihch we have used <b>jQuery</b> with cnd link!
        </div> --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                            <form  action="{{route('admin.remboursement.import')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if (count($errors) > 0)
                                <div class="row g-3">
                                    <div class="col-xxl-2 col-lg-8 col-md-offset-1">
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                                        @foreach($errors->all() as $error)
                                        {{ $error }} <br>
                                        @endforeach      
                                    </div>
                                    </div>
                                </div>
                                @endif

                                {{-- @if (session('status'))
                                    <div class="row">
                                    <div class="col-xxl-2 col-lg-8 col-md-offset-1">
                                        <div class="alert alert-success alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h5>{!! session('status') !!}</h5>   
                                        </div>
                                    </div>
                                    </div>
                                @endif --}}

                                @if (session()->has('failures'))

                                    <table class="table table-danger">
                                        <tr>
                                            <th>Row</th>
                                            <th>Attribute</th>
                                            <th>Errors</th>
                                            <th>Value</th>
                                        </tr>

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
                                    </table>

                                @endif
  
                                <div class="row g-3">
                                    <div class="col-xxl-2 col-lg-8">
                                        <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" id="formFile">
                                        @error('file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-1 col-lg-4">
                                        <button type="submit" class="btn btn-primary w-100"><i class="bx bxs-file-css"></i> Importer le fichier</button>
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
                                    <h5 class="card-title mb-0">TICKETS LIST</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                                    <button class="btn btn-danger btn-border btn-sm delete-all">Delete All</button>
                                    <button type="button" class="btn btn-secondary btn-border btn-sm pay-all" data-url="">Pay All</button>
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
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_all">
                                        </div>
                                    </th>
                                    <th class="text-center">#</th>
                                    <th class="text-left">Customer Number</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Currency</th>
                                    <th class="text-center">Référence</th>
                                    <th class="text-left">File Uploaded On</th>
                                    <th class="text-left">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @if($remboursements->count())
                                @foreach ($remboursements as $key => $item)
                                <tr id="tr_{{$item->id}}">
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input checkbox" type="checkbox" data-id="{{$item->id}}">
                                        </div>
                                    </th>
                                    <td class="text-left">{{ $item->id }}</td>
                                    <td class="text-left">{{$item->customer_details}}</td>
                                    <td class="text-left">{{$item->amount}}</td>
                                    <td class="text-left">{{$item->currency}}</td>
                                    <td class="text-left">{{$item->paydrc_reference}}</td>
                                    <td class="text-left">{{ $item->created_at }}</td>
                                    <td class="text-left"><span class="badge rounded-pill badge-soft-success">Unpaid</span></td>
                                    <td class="text-center">
                                        {!! Form::open(['method' => 'POST','route' => ['admin.remboursement', $item->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Payer', ['class' => 'btn btn-secondary btn-border btn-sm','data-toggle'=>'confirmation','data-placement'=>'left']) !!}
                                        {!! Form::close() !!}

                                        {!! Form::open(['method' => 'DELETE','route' => ['admin.remboursement.delete', $item->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-border btn-sm','data-toggle'=>'confirmation','data-placement'=>'left']) !!}
                                        {!! Form::close() !!}
                                    </td>
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
    <script type="text/javascript">
  
        /*------------------------------------------
        --------------------------------------------
        Add Loading When fire Ajax Request
        --------------------------------------------
        --------------------------------------------*/
        $(document).ajaxStart(function() {
            $('#loading').addClass('loading');
            $('#loading-content').addClass('loading-content');
        });
      
        /*------------------------------------------
        --------------------------------------------
        Remove Loading When fire Ajax Request
        --------------------------------------------
        --------------------------------------------*/
        $(document).ajaxStop(function() {
            $('#loading').removeClass('loading');
            $('#loading-content').removeClass('loading-content');
        });
          
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#check_all').on('click', function(e) {
                if($(this).is(':checked',true)) {
                    $(".checkbox").prop('checked', true);  
                } 
                else {  
                    $(".checkbox").prop('checked',false);  
                }  
            });
            $('.checkbox').on('click',function(){
                if($('.checkbox:checked').length == $('.checkbox').length){
                    $('#check_all').prop('checked',true);
                }
                else{
                    $('#check_all').prop('checked',false);
                }
            });
            /* Début Multiple Paiement */
            $('.pay-all').on('click', function(e) {
                var idsArr = [];  
                $(".checkbox:checked").each(function() {  
                    idsArr.push($(this).attr('data-id'));
                });  
                if(idsArr.length <=0)  
                {  
                    alert("Please select atleast one transaction to credit.");  
                }  
                // Start Multiple Paiement
                else {  

                    var strIds = idsArr.join(","); 
                    var redirect = "remboursement-history-report";
                    $.ajax({
                        url: "{{ route('admin.remboursement.multiple') }}",
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+strIds,
                        success: function (data) {
                            if (data['status']==true) {
                                toastr.success(data['message'], 'Success Alert', {
                                        timeOut: 1200
                                });
                                window.location.href = redirect;
                            } 
                            else {
                                toastr.error(data['message'], 'Error Alert', {
                                    timeOut: 1200
                                });
                                // location.reload();
                                $('.table_reload').load(document.URL +  ' .table');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
                } 
                // End Multiple paiement 
            });
            /* Fin Multiple Paiement */
          
            $('.delete-all').on('click', function(e) {
                var idsArr = [];  
                $(".checkbox:checked").each(function() {  
                    idsArr.push($(this).attr('data-id'));
                });  
                if(idsArr.length <=0)  {  
                    alert("Please select atleast one record to delete.");  
                }  
                else {  
                    if(confirm("Are you sure, you want to delete the selected transactions?")){  
                        var strIds = idsArr.join(","); 
                        $.ajax({
                            url: "{{ route('admin.remboursement.delete.multiple') }}",
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids='+strIds,
                            success: function (data) {
                                if (data['status']==true) {
                                    $(".checkbox:checked").each(function() {  
                                        $(this).parents("tr").remove();
                                    });
                                    toastr.success(data['message'], 'Success Alert', {
                                        timeOut: 600
                                    });
                                    // location.reload();
                                    $('.table_reload').load(document.URL +  ' .table');
                                } 
                                else {
                                    alert('Whoops Something went wrong!!');
                                }
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });
                    }  
                }  
            });
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                onConfirm: function (event, element) {
                    element.closest('form').submit();
                }
            });   
        });
    </script>
    <script type="text/javascript">
        if (window.history.replaceState) {
            window.history.replaceState(null,null,window.location.href);
        }
    </script>
    @endsection
@endsection