
@extends('layouts.dosen.main')

@section('content')

<div class="main-container">
    <div class="table-container"> 
        <div class="t-header">
            <a href="" class="" style="padding-top: 10px;"><i class="icon-file"></i>  Jadwal Mengajar Dosen</a>
        </div>
  <div class="card-body">
   
    <br>
    <h5>
        *Catatan: Salah satu boleh dikosongkan
    </h5>
    <p>
        <form action="/cari-lecturer/schedule" method="GET">
            <table class="table custom-table">
                <tr>
                    <td>Kode Dosen</td>
                    <td><input type="text" name="kd_dosen" placeholder="Masukkan Kode Dosen" class="nilai form-control"></td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>
                        <input type="text" name="kd_lokal" placeholder="Masukkan Kelas" class="nilai form-control">
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" style="text-align: right;">
                        <button type="submit" class="btn btn-info">Cari Data Jadwal </button><br>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table custom-table">
            <thead>
            <tr>
                
                <th scope="col" style="width: 15%">NIP</th>
                <th scope="col">AKRONIM</th>
                <th scope="col">KELAS</th>
                <th scope="col">HARI</th>
                <th scope="col">JAM</th>
                <th scope="col">RUANG</th>
              
                <th scope="col"  colspan="2">NAMA MTK</th>
               
                <th scope="col">SKS</th>
                <th scope="col">KD GABUNG</th>
                <th scope="col">KEL PRAKTEK</th>
                @can('jadwal_edit.adm') 
                <th scope="col">Aksi</th>
                @endcan
            </tr>
            </thead>
            <tbody>
                @foreach ($jadwal as $no => $role)
                <tr>
                    
                    <td>{{ $role->nip }}</td>
                    <td>{{ $role->kd_dosen }}</td>
                    <td>{{ $role->kd_lokal }}</td>
                    <td>{{ $role->hari_t }}</td>
                    <td>{{ $role->jam_t }}</td>
                    <td>{{ $role->no_ruang }}</td>
                    <td>{{ $role->nm_mtk }} </td>
                    <td><b>{{ $role->kd_mtk }}</b> </td>
                    <td>{{ $role->sksajar }} </td>
                    <td>{{ $role->kd_gabung }} </td>
                    <td>{{ $role->kel_praktek }} </td>
                        
                @php
                    $idComponents = [
                        $role->nip,
                        $role->kd_dosen,
                        $role->kd_lokal,
                        $role->kel_praktek,
                        $role->hari_t,
                        $role->jam_t,
                        $role->no_ruang,
                        $role->kd_mtk,
                        $role->sks,
                        $role->mulai,
                        $role->selesai,
                        $role->selesai_interval,
                        $role->kd_gabung
                    ];

                    $idString = implode(',', $idComponents);
                    $id = Crypt::encryptString($idString);
                @endphp


                    @can('jadwal_edit.adm') 
                    <td>  <a href="/lecturer/schedule/edit/{{ $id }}" class=" btn btn-sm btn-info"> Edit</a> </td>
                    @endcan
                       
                    
                   
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="text-align: center">
            {{$jadwal->links("vendor.pagination.bootstrap-4")}}
        </div>
        
    </div>
</div>

@endsection

    