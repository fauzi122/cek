@extends('layouts.dosen.main')

@section('content')


<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="table-container"> 
                    <div class="t-header">
                        <a href="" class="" style="padding-top: 10px;"><i class="icon-user1"></i>  Data Mahasiswa</a>

                        <a href="/data/kelas" class="btn btn-sm btn-primary"> <i class="icon-refresh"></i> Kembali</a>
                    </div>
                
                    <div class="card-body">
                       
                        <table  class="table custom-table">
                            <tr>
                                <td>NIP</td>
                               
                                <td><b>{{ $showdosen->nip }}</b></td>

                            </tr>
                            <tr>
                                <td>Akronim</td>
                               
                                <td><b>{{ $showdosen->kd_dosen }}</b></td>

                            </tr>
                            <tr>
                                <td>Matakuliah</td>
                               
                                <td><b>{{ $showdosen->nm_mtk }} - {{ $showdosen->kd_mtk }}</b></td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                               
                                <td><b>{{ $showdosen->kd_lokal }}<b></td>
                            </tr>
                        </table>
                        <div class="table-responsive">
                            
                             <table id="copy-print-csv" class="table custom-table">
                                <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                    <th scope="col" style="width: 15%">NIM</th>
                                    <th scope="col">NAME</th>
                                    <th scope="col">KELAS</th>
                                   
                                    <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($showkls as $no => $kelas)
                                    <tr>
                                        <th scope="row" style="text-align: center">{{ ++$no}}</th>
                                        <td>{{ $kelas->nim_mhs }}</td>
                                        <td>{{ $kelas->nm_mhs }}</td>
                                        <td>{{ $kelas->kd_lokal_mhs }}</td>
                                        
                                        @php    
                                        $id=Crypt::encryptString($kelas->nim_mhs.','.$kelas->mtk_penilaian.','.$kelas->kd_lokal_mhs);                                    
                                        @endphp
                                        <td class="text-center">
                                             {{--  @can('userdosen_adm.edit')   --}}
                                            <a href="/show/kelas/mhs/{{ $id }}" class="btn btn-sm btn-info">
                                                <i class="icon-check" title="edit"></i>
                                                Show Detail
                                            </a>
                                             {{--  @endcan   --}}
                                            
                                          
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
  
    @endsection