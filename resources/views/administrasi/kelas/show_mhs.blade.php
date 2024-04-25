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
                       
                        <div class="table-responsive">
                            
                             <table id="copy-print-csv" class="table custom-table">
                                <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                    <th scope="col" >NIM</th>
                                    
                                    <th scope="col">KELAS</th>
                                    <th scope="col">KODE MTK</th>
                                    <th scope="col">TGL HADIR</th>
                                    <th scope="col">JAM HADIR</th>
                                    <th scope="col">PERTEMUAN KE</th>
                                    <th scope="col">STATUS HADIR</th>
                                   
                                    
                                </tr>
                                </thead>
                                <tbody>
                                  @foreach ($showmhs as $no => $kelas)
                                 
                                  @php
                                if ($kelas->status_hadir == '1') {
                                $status_hadir_mhs = 'Hadir';
                                }else{
                                $status_hadir_mhs = 'Tidak Hadir';
                                } 
                                @endphp

                                    <tr>
                                        <th scope="row" style="text-align: center">{{ ++$no}}</th>
                                        <td>{{ $kelas->nim }}</td>
                                        <td>{{ $kelas->kd_lokal }}</td>
                                        <td>{{ $kelas->kd_mtk }}</td>
                                        <td>{{ $kelas->tgl_hadir }}</td>
                                        <td>{{ $kelas->jam_hadir }}</td>
                                        <td>{{ $kelas->pertemuan }}</td>
                                        <td>{{ $status_hadir_mhs }}</td>
                                        
                                      
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