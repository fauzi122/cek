@extends('layouts.dosen.main')

@section('content')
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="alert-notify info">
                    <div class="alert-notify-body">
                        <span class="type">Info</span>
                        <div class="alert-notify-title">
                            <h4>Data User Mahasiswa</h4>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <div class="row gutters">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table custom-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-center" style="width: 6%">NO.</th>
                                                        <th scope="col" style="width: 15%">NIP</th>
                                                        <th scope="col">NAME</th>
                                                        <th scope="col">KODE</th>
                                                        <th scope="col">EMAIL</th>
                                                        <th scope="col" class="text-center" style="width: 20%">AKSI</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($users as $no => $dosen)
                                                    <tr>
                                                        <th scope="row" class="text-center">{{ ++$no }}</th>
                                                        <td>{{ $dosen->username }}</td>
                                                        <td>{{ $dosen->name }}</td>
                                                        <td>{{$dosen->kode }}</td>
                                                        <td>{{ $dosen->email }}</td>
                                                        <td class="text-center">
                                                            @can('userdosen_adm.edit') 
                                                            <a href="/std/edit/baak/{{ $dosen->id }}" class="btn btn-sm btn-info" title="Edit">
                                                                <i class="icon-pencil"></i>
                                                            </a>
                                                            <input data-id="{{ $dosen->id }}" data-nama="{{ $dosen->name }}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Sample" data-off="InSample" {{ $dosen->two_password==true ? 'checked' : '' }}> 
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
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $(function() { 
        $('.toggle-class').change(function() { 
            var status = $(this).prop('checked') ? 1 : 0;
            var id_user = $(this).data('id');  
            var name = $(this).data('nama'); 
            $.ajax({ 
                type: "POST", 
                dataType: "json", 
                url: '/std/users/baak', 
                data: {'status': status, 'id_user': id_user, 'name': name},
                success: function(data){ 
                    console.log(data.success); 
                }
            }); 
        }); 
    }); 
</script>
@endpush
