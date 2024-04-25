@extends('layouts.dosen.main')

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class="t-header">
                        @can('roles.create') 
                        <a href="{{ url('/role/create') }}" class="" style="padding-top: 10px;"><i class="icon-plus"></i> Add New Role</a>
                        @endcan
                        List of Roles
                    </div>
                    <div class="table-responsive">
                        <table id="copy-print-csv" class="table custom-table">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center; width: 6%">No.</th>
                                    <th scope="col" style="width: 15%">Nama Role</th>
                                    <th scope="col">Permissions</th>
                                    <th scope="col">Ujian Permissions</th>
                                    <th scope="col" style="text-align: center; width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $no => $role)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach($role->getPermissionNames() as $permission)
                                        @if(!Str::contains($permission, '_ujian'))
                                        <button class="btn btn-sm btn-info mb-1 mt-1 mr-1">{{ $permission }}</button>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($role->getPermissionNames() as $permission)
                                        @if(Str::contains($permission, '_ujian'))
                                        <button class="btn btn-sm btn-warning mb-1 mt-1 mr-1">{{ $permission }}</button>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @can('roles.edit') 
                                        <a href="/role/edit/{{ $role->id }}" class="btn btn-sm btn-primary">
                                            <i class="icon-pencil"></i>
                                        </a>
                                        @endcan 
                                        @can('roles.delete') 
                                        <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $role->id }}">
                                            <i class="icon-trash"></i>
                                        </button>
                                        @endcan
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
</div>
@endsection
