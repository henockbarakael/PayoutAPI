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

        <div class="alert alert-danger" role="alert">
            This is <strong>Datatable</strong> page in wihch we have used <b>jQuery</b> with cnd link!
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Liste des utilisateurs</h5>
                    </div>
                    <div class="card-body">
                        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
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
@endsection