@extends('layouts.dosen.main')

@section('content')
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <center>
                    <h4> Form Pertemuan Dosen</h4>
                </center>
                <div class="form-group">
                    1. Hapus Data Pertemuan <br>
                    @can('temu_baak.delete') 
                    <form action="/pertemuan/tran" method="POST">
                        @csrf
                        <button class="btn btn-secondary btn-lg" type="submit">
                            <i class="icon-delete"></i> Kosongkan Pertemuan </button>  
                    </form>
                    @endcan
                </div>
                2. Input Nomer Jadwal Kuliah Saat ini <br>
                <form action="/input-nojklh" method="POST">
                    @csrf
                    <div class="row gutters">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>No Jadwal Kuliah</label>
                                <input type="text" name="no_j_klh" class="form-control time" placeholder="No Jadwal Kuliah" value="{{$pertemuan->smt}}">
                                <code>Contoh : 1221</code>
                            </div>
                            <div class="form-group mb">
                                <button type="submit" class="btn btn-info">Save</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="form-group">
                3. Klik Tombol dibawah (*Izinkan Pop-up pada Browser) <br>
                    @php
                    for ($i= 1; $i <= $pertemuan->lastPage; $i++) {
                        if ( $bagi = $i % 10 == 0 ) {
                            echo "
                            <a href='".url("/send-jadwal/".Crypt::encryptString($i)) ."' type='button' class='btn btn-info'>Klik $i</a>
                            ";
                        }
                    }
                    if (substr($pertemuan->lastPage,1)!='0') {
                        echo "
                            <a href='".url("/send-jadwal/".Crypt::encryptString($pertemuan->lastPage)) ."' type='button' class='btn btn-info'>Klik $pertemuan->lastPage</a>
                            ";
                        }
                    @endphp
                </div>
                <div class="form-group">
                4. Proses Terakhir Klik Tombol Sinkronnya <br>

                @can('temu_baak.singkron')
                        <form action="/pertemuan/singkron" method="POST">
                            @csrf
                            <button class="btn btn-info btn-lg" type="submit">
                                <i class="icon-loader"></i> Singkron Jadwal </button>   
                       
                        </form>
                        @endcan 
                </div>
                </div>
            </div>
            
        </div>
    </div>
                    

                <div class="table-container">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card-body">
                            <form action="/pertemuan1" method="post" enctype="multipart/form-data">
                                @csrf
                    
                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif
                    
                                @if (session('error'))
                                    <div class="alert alert-success">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @can('temu_baak.upload') 
                                <div class="form-group">
                                    <label for="">File (.xls, .xlsx) <a href="{{ Storage::url('public/formatfile/pertemuan1.xlsx') }}"
                                        class="btn btn-info btn-sm">
                                        Unduh Format File<a></label>
                                    <p class="text-danger">{{ $errors->first('file') }}</p>
    
                                    <input type="file" class="btn btn-primary" name="file">
                               
                                    <button class="btn btn-info btn-lg">
                                        <i class="icon-upload"></i> Upload </button>
                                </div>
                                @endcan 
                            </form>
                            <div class="table-responsive">
    
                            </div>
                        </div>
                    </div>
                        <div class="alert-notify-body">
                            <div class="alert-notify-title">
                                <h4>Data Pertemuan</h4>
                            </div>
                            <br>
                            <h5>
                                *Catatan: Pencarian bisa hanya kode matakuliah saja
                            </h5>
                            <p>
                                <form action="/cari-rekap-teori" method="GET">
                                    <table class="table custom-table">
                                        <tr>
                                            <td>Kode Dosen</td>
                                            <td><input type="text" name="kd_dosen" placeholder="Masukkan Kode Dosen" class="nilai form-control"></td>
                                        </tr>
                                        <tr>
                                            <td>Kode Mtk</td>
                                            <td>
                                                <input type="text" name="kd_mtk" placeholder="Masukkan Kode mtk" class="nilai form-control">
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="2" style="text-align: right;">
                                                <button type="submit" class="btn btn-info">Cari Data </button><br>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <div class="card-body">
                               
                                <div class="table-responsive">
                                    <table class="table custom-table">
                                        <thead>
                                            <tr>
                                         
                                                <th scope="col">no</th>
                                                <th scope="col">Akronim</th>
                                                <th scope="col">KELAS</th>
                                                <th scope="col">SKS</th>
                                                <th scope="col">MTK</th>
                                                
                                                <th scope="col">NO RUANG</th>
                                                <th scope="col">sts_ajar</th>
                                                <th scope="col">HARI</th>
                                                <th scope="col">kd_gabung</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($temu as $no => $role)
                                            <tr>
                                           
                                                <td>{{ ++$no }}</td>
                                                <td>{{ $role->kd_dosen }}</td>
                                                <td>{{ $role->kd_lokal }}</td>
                                                <td>{{ $role->sksajar }}</td>
                                                <td>{{ $role->kd_mtk }}</b></td>
                                                <td>{{ $role->no_ruang }}</td>
                                                <td>{{ $role->jam_t }}</td>
                                                <td>{{ $role->hari_t }}</td>
                                                <td>{{ $role->kd_gabung }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div style="text-align: center">
                                        {{$temu->links("vendor.pagination.bootstrap-4")}}
                                    </div>
                                    
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <p>a</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           
 
    @endsection
    