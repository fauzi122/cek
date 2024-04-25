@extends('layouts.dosen.main')

@section('content')

        <div class="card-body">
                    <div class="table-container">
                        <div class="t-header">
                           
                           Log Aktifitas

                        </div>
                        <div class="table-responsive">
                            <table id="myTable1" class="table custom-table">
                                <thead>
                                    <tr>
                                      
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Kode</th>
                                        <th>Type</th>
                                        <th>IP</th>
                                        <th>Kegiatan</th>
                                        <th>URL Yang Di Akses</th>
                                        <th>Waktu</th>
                                      
                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)

                                        <tr>
                                            <td>{{  $loop->iteration }}</td>
                                            <td>
                                                {{ $log->username }}
                                               

                                            </td>                                            <td>
                                                {{ $log->kode }}
                                               

                                            </td>                                            <td>
                                                {{ $log->utype }}
                                               

                                            </td>
                                        </td>                                            <td>
                                            {{ $log->ip_address }}
                                           

                                        </td>
                                            <td>
                                                @if (strpos($log->action, 'DELETED') !== false)
                                                {{ str_replace('DELETED', 'Menghapus', $log->action) }}
                                            @elseif (strpos($log->action, 'CREATED') !== false)
                                                {{ str_replace('CREATED', 'Membuat', $log->action) }}
                                            @elseif (strpos($log->action, 'UPDATED') !== false)
                                                {{ str_replace('UPDATED', 'Merubah', $log->action) }}
                                            @endif
                                            

                                               {{ str_replace(['[DELETED]', '[UPDATED]','[CREATED]'], '', $log->description) }}


                                            <td>
                                               
                                                {{ $log->url }} 
                                            </td>
                                            <td>
                                                {{ $log->updated_at }}
                                            </td>
                                        </tr>
                                        @endforeach

                                </tbody>
                        </table>
                        </div>
                    </div>
                    <div style="padding:  14px; border: double #fff 15px; color: #fff; background: #b90000;">
                <p style="font-weight: bold;">
                   <h3> Informasi pengisian</h3></p>
                  
                <ul>
                    {{-- <li>Abaikan kelas e-learning contoh ruangan EX,EL,EN</li> --}}
                    {{-- <li>Isikan Ip Address yang sesuai dengan ruang kelas</li> --}}
                    {{--  <li>Perhatikan sisa waktu ujian, sistem akan mengumpulkan jawaban saat waktu sudah selesai</li>
                    <li>Waktu ujian akan dimulai saat tombol "<b>Mulai Mengerjakan Soal!</b>" di klik</li>
                    <li>Dilarang bekerjasama dengan teman</li>
                    <li>Jangan keluar dari mode fullscreen, setiap upaya keluar dari mode tersebut akan dihitung</li>  --}}
                </ul>
            </div>
                </div>

                @push('scripts')
                <script type="text/javascript">
                $('.tombol-hapus').on('click',function(e){
              e.preventDefault();
              const href=$(this).attr('href');
              Swal.fire({
                title: 'Apakah anda yakin',
                text: "Data akan dihapus",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Data!'
              }).then((result) => {
                if (result.value) {
                  document.location.href=href;
                  
                }
              })
              });
              $(document).ready(function () {
                   $('#myTable1').DataTable({
                    dom: 'Blfrtip',
                                lengthMenu: [
                                    [ 10, 50, 10000 ],
                                    [ '10', '50', 'Show All' ]
                                ],
                                buttons: [
                                    'copy', 'csv', 'excel', 'pdf', 'print'
                                ],
                  responsive: true
                    });
              
                 });
                  </script>
              @endpush
              
    @endsection
   