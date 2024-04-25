@extends('layouts.dosen.main')

@section('content')

        <div class="card-body">
                    <div class="table-container">
                        <div class="t-header">
                            @can('temu_baak.index') 
                            <a href="{{url('/ip-ruang/create') }}" class="ti-pencil" title="add new"> 
                            <i class="icon-plus"></i> </a>
                            @endcan 
                            List IP Ruang Kelas

                        </div>
                        <div class="table-responsive">
                            <table id="myTable1" class="table custom-table">
                                <thead>
                                    <tr>
                                      
                                      <th>no ruang</th>
                                      <th>kapasitas</th>
                                      <th>network id</th>
                                      <th>ip_address</th>
                                      <th>ip_address_2</th>
                                      <th>NIP</th>
                                      <th>kondisi</th>
                                      <th>tgl</th>
                                      <th>aksi</th>
                                      
                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ipruang as $no => $ipruang)
                                      @php
                                        $id=Crypt::encryptString($ipruang->no_ruang);                                    
                                        @endphp
                                    <tr>
                                     
                                      <td>{{ $ipruang->no_ruang }}</td>
                                      <td>{{ $ipruang->kapasitas }}</td>
                                      <td>{{ $ipruang->network_id }}</td>
                                      <td>{{ $ipruang->ip_address }}</td>
                                      <td>{{ $ipruang->ip_address_2 }}</td>
                                      <td>{{ $ipruang->updater }}</td>
                                      <td>{{ $ipruang->kondisi }}</td>
                                      <td>{{ $ipruang->updated_at }}</td>
                                      <td>
                                      @can('ip_ruang.edit')
                                       <a href="/edit/ip-ruang/{{ $id }}" class="btn btn-sm btn-success">
                                        edit</a>
                                      </td>
                                       @endcan
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
                    <li>Abaikan kelas e-learning contoh ruangan EX,EL,EN</li>
                    <li>Isikan Ip Address yang sesuai dengan ruang kelas</li>
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
   