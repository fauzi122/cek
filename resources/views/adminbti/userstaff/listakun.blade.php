@extends('layouts.dosen.main')

@section('content')
<div class="card-body">
    <div class="table-container">
        <div class="t-header">
            @can('addakun.create') 
                {{-- <a href="/lecturer-data/create" class="btn btn-info btn-lg">
                    <i class="icon-add"></i> Create User
                </a>    --}}
            @endcan 
            <a href="" class="" style="padding-top: 10px;">
                <i class="icon-user-check"></i> Data User Dosen
            </a>
        </div>
        
        <div class="card-body">
            <h5>
                *Catatan: Pencarian dapat di lakukan salah satu saja contoh *hanya NIP/Kode Dosen
            </h5>
        </div>
        
        <form action="/lecturer-search/users-mhs" method="GET">
            <table class="table custom-table">
                <tr>
                    <td>NIP</td>
                    <td>
                        <input type="number" name="username" placeholder="Masukkan NIP" class="nilai form-control">
                    </td>
                </tr>
                <tr>
                    <td>Kode Dosen</td>
                    <td>
                        <input type="text" name="kode" placeholder="Masukkan Kode Dosen" class="nilai form-control">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right;">
                        <button type="submit" class="btn btn-info">Cari Data User Dosen</button>
                    </td>
                </tr>
            </table>
        </form>
        
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th scope="col" style="text-align: center;width: 6%">NO.</th>
                        <th scope="col" style="width: 15%">NIP</th>
                        <th scope="col">NAME</th>
                        <th scope="col">KODE</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col" style="text-align: center;width: 15%">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usermhs as $no => $dosen)
                    <tr>
                        <th scope="row" style="text-align: center">{{ ++$no + ($usermhs->currentPage()-1) * $usermhs->perPage() }}</th>
                        <td>{{ $dosen->username }}</td>
                        <td>{{ $dosen->name }}</td>
                        <td>{{ $dosen->kode }}</td>
                        <td>{{ $dosen->email }}</td>
                        <td class="text-center">
                          @can('addakun.edit') 
                            <a href="/edit/lecturer-data/{{$dosen->id}}" class="btn btn-sm btn-info">
                                <i class="icon-pencil"></i> edit
                            </a>
                            <input data-id="{{$dosen->id}}" data-name="{{$dosen->name }}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Sample" data-off="InSample" {{ $dosen->two_password == true ? 'checked' : '' }}>
                          @endcan 
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align: center">
                {{$usermhs->links("vendor.pagination.bootstrap-4")}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() { 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.toggle-class').change(function() { 
            var status = $(this).prop('checked') ? 1 : 0;
            var user_id = $(this).data('id');  
            var name = $(this).data('name'); 
            $.ajax({ 
                type: "POST", 
                dataType: "json", 
                url: '/lecturer/data', 
                data: {status: status, id_user: user_id, name: name}, 
                success: function(data){ 
                    console.log(data.success) 
                } 
            }); 
        });
    }); 
</script>
@endpush
