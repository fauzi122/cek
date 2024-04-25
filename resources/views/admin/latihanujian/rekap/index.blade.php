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
                        <a href="" class="" style="padding-top: 10px;"><i class="icon-user1"></i>  Data Kelas </a>
                    </div>
                
                    <div class="card-body">
                       
                        <div class="table-responsive">
                            
                             <table id="copy-print-csv" class="table custom-table">
                                <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                   
                                    <th scope="col">MATAKULIAH - KODE</th>
                                    <th scope="col">KELAS</th>
                                    <th scope="col">KEL-PRAKTEK</th>
                                  
                                    <th scope="col" style="width: 20%;text-align: center">AKSI</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas as $no => $kelas)
                                    <tr>
                                        <th scope="row" style="text-align: center">{{ ++$no}}</th>
                                       
                                        <td>{{ $kelas->nm_mtk }} - <b>{{ $kelas->kd_mtk }}</b></td>
                                        <td>{{ $kelas->kd_lokal }}</td>
                                        <td>{{ $kelas->kel_praktek }}</td>
                                     
                                           
                                            @php    
                                        $id=Crypt::encryptString($kelas->kd_dosen.','.$kelas->kd_lokal.','.$kelas->kd_mtk);                                    
                                        @endphp

                                        <td class="text-center">
                                             {{--  @can('userdosen_adm.edit')   --}}
                                        
                                            <a href="/lihat/list-latihan-kls/{{ $id }}" class="btn btn-sm btn-danger">
                                                <i class="icon-check" title="lihat data rekap nilai all"></i>
                                                Rekap Nilai
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