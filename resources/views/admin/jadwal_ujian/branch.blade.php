@extends('layouts.dosen.main')

@section('content')
<div class="card-body">

    
          
                    <div class="table-container">
                        
                        <div class="t-header">
                        
                       
                          
                        @can('addakun.create') 
                        <p></p>
                                 Data Kampus   
                        @endcan 

                        </div>
                        <div class="table-responsive">
                            <table id="copy-print-csv" class="table custom-table">

                                <thead>
                                    <tr>
                                     
                                   
                                      <th>Kode Kampus</th>
                                      <th>Nama Kampus</th>
                                      <th>Kode Cabang</th>
                                      <th>Alamat Kampus</th>
                                      <th>Aksi</th>
                                      
                                   
                                    </tr>
                                </thead>
                               
                                <tbody>
                                    @foreach ($kampus as $kampus )
                                  <tr>
                                   
                                    <td>{{ $kampus->kd_kampus }}</td>
                                    <td>{{ $kampus->nm_kampus }}</td>
                                    <td>{{ $kampus->kd_cabang }}</td>
                                    <td>{{ $kampus->alm_kampus }}</td>
                                    <td>
                                        @php    
                                        $id=Crypt::encryptString($kampus->kd_kampus);                                    
                                        @endphp

                                        @can('addakun.edit') 
                                    <a href="/show/exam-schedule/{{$id}}" class="btn btn-info">
                                    <i class="icon-file"></i> jadwal Ujian</a>
                                       @endcan 
                                    </td>
                                    
                                    

                                </tr>
                                @endforeach
                                </tbody>
                               
                        </table>
                        </div>
                    </div>
                </div>
                  
 
    @endsection
 
