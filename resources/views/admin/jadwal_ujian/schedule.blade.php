@extends('layouts.dosen.main')

@section('content')
<div class="card-body">

    
          
                    <div class="table-container">
                        
                        <div class="t-header">
                        
                       
                          
                        @can('addakun.create') 
                        <p></p>
                       
                           
                                 Data Jadwal Ujian 
                       
                      
                        @endcan  

                        </div>
                        <div class="table-responsive">
                            <table id="copy-print-csv" class="table custom-table">

                                <thead>
                                    <tr>
                                     
                                   
                                      <th>NIP</th>
                                      <th>Akronim</th>
                                      <th>Kelas</th>
                                      <th>Hari</th>
                                      <th>Ruang</th>
                                      <th>MTK</th>
                                      <th>Waktu</th>
                                      <th>Aksi</th>
                                      
                                   
                                    </tr>
                                </thead>
                               
                                <tbody>
                                    @foreach ($schedule as $sch )
                                  <tr>
                                   
                                    <td>{{ $sch->nip }}</td>
                                    <td>{{ $sch->kd_dosen }}</td>
                                    <td>{{ $sch->kd_lokal }}</td>
                                    <td><b> {{$sch->hari_t }}</b></td>
                                    <td>{{ $sch->no_ruang }}</td>
                                    <td>{{ $sch->nm_mtk }} - <b>{{ $sch->kd_mtk }}</b></td>
                                    <td>{{ $sch->jam_t }}</td>
                                    <td>
                                        @php  
                                        $id=Crypt::encryptString($sch->kd_dosen.','.$sch->kd_lokal.','.$sch->kd_mtk);                                    
                                        @endphp

                                        {{-- @can('addakun.edit')  --}}
                                    <a href="/show/exam-schedule/{{$id}}" class="btn btn-info">
                                    <i class="icon-pencil"></i>ubah jadwal</a>

                                    <a href="/edit/exam-schedule/{{$id}}" class="btn btn-primary">
                                        <i class="icon-pencil"></i>ubah pengawas</a>
                                       {{-- @endcan  --}}
                                    </td>
                                    
                                    

                                </tr>
                                @endforeach
                                </tbody>
                               
                        </table>
                        </div>
                    </div>
                </div>
                  
 
    @endsection
 
