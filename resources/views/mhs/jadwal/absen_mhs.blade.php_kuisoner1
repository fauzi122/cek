
@extends('layouts.mhs.main')
@section('content')

<div class="row gutters">
    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-4">
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-account_circle"></i>
            </div>
            <div class="stats-detail">
                <h5>{{$exp[2]}}</h5>
                <p>Dosen</p>
            </div>
        </div>
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-home2"></i>
            </div>
            <div class="stats-detail">
                <h5>{{$exp[7]}}</h5>
                <p>Ruang</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-documents"></i>
            </div>
            <div class="stats-detail">
                <h5>{{$exp[1]}}</h5>
                <p>Matakuliah</p>
            </div>
        </div>
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-layers"></i>
            </div>
            <div class="stats-detail">
                <h5>{{$exp[4]}}</h5>
                <p>Kelas</p>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4">
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-watch_later"></i>
            </div>
            <div class="stats-detail">
                <h5>{{substr($exp[6],0,5)}}</h5>
                <p>Jam Masuk</p>
            </div>
        </div>
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-date_range"></i>
            </div>
            <div class="stats-detail">
                <h5>{{$exp[5]}}</h5>
                <p>Hari</p>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4">
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-clock1"></i>
            </div>
            <div class="stats-detail">
                <h5>{{substr($exp[6],6,11)}}</h5>
                <p>Jam Keluar</p>
                
            </div>
        </div>
        <div class="info-tiles">
            <div class="info-icon">
                <i class="icon-dribbble-with-circle"></i>
            </div>
            <div class="stats-detail">
                <h5>{{$exp[0]}}</h5>
                <p>Kode MTK</p>
                
            </div>
        </div>
    </div>
   
    {{-- @if ($komentar < 1) --}}
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="info-tiles">
            {{-- {{$absen->first()->pertemuan}} --}}
                           
            @if ($absen->count() > 0)
            {{-- Cek apakah ada data absen --}}
            @if ($durasi > 0)
                {{-- Cek apakah durasi masih berlangsung --}}
                @if ($kuisionerExists)
                    {{-- Cek apakah mahasiswa sudah mengisi kuesioner --}}
                    @if ($absen_mhs > 0)
                        {{-- Cek apakah mahasiswa sudah melakukan absensi --}}
                        @if ($komentar < 1)
                            {{-- Cek apakah mahasiswa sudah memberikan komentar --}}
                            @php
                                $cryp_pertemuan = Crypt::encryptString($absen->first()->pertemuan.',1,'.$absen->first()->nip);
                            @endphp
                            <form action="/komentar-mhs" method="post">
                                @csrf
                                <center>
                                    <textarea class="form-control @error('komentar') is-invalid @enderror" rows="3" name="komentar" placeholder="Berikan Komentar Anda Terhadap Pengajar Dosen">{{ old('komentar') }}</textarea>
                            @error('komentar')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="radio1" name="nilai" class="custom-control-input" value="1" checked="checked"><label class="custom-control-label" for="radio1">Pengajaran Sesuai</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="radio2" name="nilai" class="custom-control-input" value="0"><label class="custom-control-label" for="radio2">Pengajaran Tidak Sesuai</label>
                            </div>
                            {{-- <input type="radio" name="nilai" value="1" checked="checked"><label for="hadir1">Pengajaran Sesuai</label><br>
                            <input type="radio" name="nilai" value="0"><label for="hadir1">Pengajaran Tidak Sesuai</label><br> --}}
                           
                            <input type="hidden" name="pertemuan" value="{{$cryp_pertemuan}}">
                            {{--  <input type="hidden" name="status" value="1">
                            <input type="hidden" name="nip" value="{{$absen->first()->nip}}">  --}}
                            <input type="hidden" name="id" value="{{$id}}">
                            <button type="submit" class="btn btn-primary btn-rounded left mt-4"><i class="icon-send1"></i> Kirim</button>
                        </center>
                                </center>
                            </form>
                        @endif
                    @else
                        {{-- Jika mahasiswa belum melakukan absensi, tampilkan form absensi --}}
                        @php
                            $cryp_pertemuan = Crypt::encryptString($absen->first()->pertemuan.',1,'.$absen->first()->nip);
                        @endphp
                        <form action="/mhs-absen" method="post">
                            @csrf
                            <center>
                                <input type="hidden" name="pertemuan" value="{{$cryp_pertemuan}}">
                                <input type="hidden" name="id" value="{{$id}}">
                                <button type="submit" class="btn btn-primary btn-rounded left">Absen Masuk</button>
                            </center>
                        </form>
                    @endif
                @else
                    {{-- Jika kuesioner belum diisi, tampilkan link untuk mengisi kuesioner --}}
                    <p>Anda harus mengisi kuisioner terlebih dahulu.sebelum melakukan absen</p>
                    <br>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalLarge">
                        isi kuisioner
                      </button>
                @endif
            @else
                {{-- Jika durasi sudah habis, tampilkan tombol sudah selesai --}}
                <center><button type="submit" class="btn btn-warning btn-rounded left mt-4">Sudah Selesai</button></center>
            @endif
        @else
            {{-- Jika tidak ada data absen, tampilkan tombol belum mulai --}}
            <center><button type="button" class="btn btn-danger btn-rounded left mt-4">Belum Mulai</button></center>
        @endif
        
        </div>
    </div>
       
{{-- @endif --}}
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4">
    <!-- Row start -->
    <div class="row gutters mt-3 mb-5">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
@if($sapaan ?? ''==true)
            <div class="jumbotron">
                <h1 class="display-4 text-primary">Sekapur Sirih</h1>
                <center>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        
                        <figure class="user-card">
                            <center>
                            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                                <figure class="effect-3">
                                    <img src="{{ Storage::url('public/'.$sapaan->profile_photo_path.'') }}" class="img-fluid" alt="Mybast" hight="200" width="150">
                                </figure>
                            </div>
                            <figcaption>
                            </center>
                                <h5>{{$sapaan->name}}</h5>
                                <ul class="list-group">
                                    <li class="list-group-item">{{$sapaan->email}}</li>
                                </ul>
                                <div class="justify-content-between">{{$sapaan->judul}}</div>
                            </figcaption>
                        </figure>
                    </div>
                </center>
                <p class="lead">{{$sapaan->deskripsi}}</p>
                <div class="mb-3"></div>
                
            </div>

        </div>
@endif
<!-- Button trigger modal -->

        <!-- Modal Lebar -->
        <div class="modal fade" id="exampleModalLarge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLargeLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"> <!-- Perhatikan kelas 'modal-lg' di sini -->
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLargeLabel">FORM PERSEPSI MAHASISWA MENGENAI DOSEN</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/store/kuisoner-mpd" enctype="multipart/form-data">
                        @csrf
                        <p><b>FORM PERSEPSI MAHASISWA MENGENAI DOSEN </b> (Diisi sebanyak Jumlah Dosen)</p>
                        <!-- /.col-->
                        <hr>
                        <div class="tab-content rounded-bottom">
                            <div><label class="form-label"><b> F1 PROFIL RESPONDEN </b></label> </div>
                            <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1004">
                                <div class="mb-8 row">
                                    <label class="col-sm-4 col-form-label" for="staticEmail"> <b> F1-1 </b> NIM</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="staticEmail" type="text" name="nim" readonly="" value="{{ Auth::user()->username }}">
                                    </div>
                                </div>
                                <div class="mb-8 row">
                                    <label class="col-sm-4 col-form-label" for="staticEmail"> <b> F1-2 </b> Nama</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="staticEmail" type="text" name="name" readonly="" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="mb-8 row">
                                    <label class="col-sm-4 col-form-label" for="staticEmail"> <b> F1-3 </b> Kelas</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="staticEmail" type="text" name="kelas" readonly="" value="{{ Auth::user()->kode }}">
                                    </div>
                                </div>
                                <div class="mb-8 row">
                                    <label class="col-sm-4 col-form-label" for="inputPassword"><b> F1-4 </b>Program Studi</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="staticEmail" type="text" name="prodi" readonly="" value="{{ $result->nm_jrs }}">
                                    </div>
                                </div>
                                <div class="mb-8 row">
                                    <label class="col-sm-4 col-form-label" for="inputPassword"><b> F1-5 </b>UPPS</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="staticEmail" type="text" name="upps" readonly="" value="{{ $result->upps }}">
                                    </div>
                                </div>
                                <div class="mb-8 row">
                                    <label class="col-sm-4 col-form-label" for="inputPassword"><b> F2-1 </b>Dosen</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="staticEmail" type="text" name="nip_dosen" readonly="" value="{{$exp[2]}}">
                                        <input class="form-control" id="staticEmail" type="text" name="mtk" readonly="" value="{{$exp[0]}}">
                                    </div>
                                </div>
                                
                                <div class="mb-8 row">
                                    <label class="col-sm-4 col-form-label" for="inputPassword"><b> F2-2 </b>Periode</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="staticEmail" type="text" name="periode" readonly="" value="Ganjil 2023/2024">
                                    </div>
                                </div>
                                <hr>
                            </div>
        
                            <label class="col-md-12 control-label">Jawablah dengan cara memilih salah satu jawaban yang tersedia, sesuai dengan persepsi anda terhadap dosen tersebut.</label>
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-none">
                                            <thead>
                                                <tr>
                                                    <th width='40%'>Pernyataan Mengenai Dosen</th>
                                                    <th width='20%' align='center'>Sangat Setuju<br></th>
                                                    <th width='10%' align='center'> Setuju<br></th>
                                                    <th width='15%' align='center'>Cukup Setuju<br></th>
                                                    <th width='15%' align='center'>Tidak Setuju<br></th>
                                                    <th width='20%' align='center'>Sangat Tidak Setuju<br></th>
                                                     
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="6"> <strong>(F3) Kemampuan Mengajar Dosen </strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Menguasai Materi yang Diajarkan (F3-1)</td>
                                                    <td><input type="radio" value='5' name='cf31' required></td>
                                                    <td><input type="radio" value='4' name='cf31'></td>
                                                    <td><input type="radio" value='3' name='cf31'></td>
                                                    <td><input type="radio" value='2' name='cf31'></td>
                                                    <td><input type="radio" value='1' name='cf31'></td>
                                                </tr>
                                                <tr>
                                                    <td>Menyampaikan Materi dengan Jelas (F3-2)</td>
                                                    <td><input type="radio" value='5' name='cf32' required></td>
                                                    <td><input type="radio" value='4' name='cf32'></td>
                                                    <td><input type="radio" value='3' name='cf32'></td>
                                                    <td><input type="radio" value='2' name='cf32'></td>
                                                    <td><input type="radio" value='1' name='cf32'></td>
                                                </tr>
                                                <tr>
                                                    <td>Materi yang diajarkan sesuai dengan RPS (F3-3)</td>
                                                    <td><input type="radio" value='5' name='cf33' required></td>
                                                    <td><input type="radio" value='4' name='cf33'></td>
                                                    <td><input type="radio" value='3' name='cf33'></td>
                                                    <td><input type="radio" value='2' name='cf33'></td>
                                                    <td><input type="radio" value='1' name='cf33'></td>
                                                </tr>
                                                <tr>
                                                    <td>Cara Mengajar tidak Membosankan (F3-4)</td>
                                                    <td><input type="radio" value='5' name='cf34' required></td>
                                                    <td><input type="radio" value='4' name='cf34'></td>
                                                    <td><input type="radio" value='3' name='cf34'></td>
                                                    <td><input type="radio" value='2' name='cf34'></td>
                                                    <td><input type="radio" value='1' name='cf34'></td>
                                                </tr>
        
                                                <tr>
                                                    <td colspan="6"><b>F4 Kemampuan Berkomunikasi Dosen dengan Mahasiswa</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Melakukan diskusi dengan mahasiswa (F4-1)</td>
                                                        <td><input type="radio" value='5' name='cf41' required></td>
                                                        <td><input type="radio" value='4' name='cf41'></td>
                                                        <td><input type="radio" value='3' name='cf41'></td>
                                                        <td><input type="radio" value='2' name='cf41'></td>
                                                        <td><input type="radio" value='1' name='cf41'></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mampu memotivasi mahasiswa (F4-2)</td>
                                                        <td><input type="radio" value='5' name='cf42' required></td>
                                                        <td><input type="radio" value='4' name='cf42'></td>
                                                        <td><input type="radio" value='3' name='cf42'></td>
                                                        <td><input type="radio" value='2' name='cf42'></td>
                                                        <td><input type="radio" value='1' name='cf42'></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Memberikan informasi akademik dengan tepat (F4-3)</td>
                                                        <td><input type="radio" value='5' name='cf43' required></td>
                                                        <td><input type="radio" value='4' name='cf43'></td>
                                                        <td><input type="radio" value='3' name='cf43'></td>
                                                        <td><input type="radio" value='2' name='cf43'></td>
                                                        <td><input type="radio" value='1' name='cf43'></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggap terhadap permasalahan akademik Mahasiswa (F4-4)</td>
                                                        <td><input type="radio" value='5' name='cf44' required></td>
                                                        <td><input type="radio" value='4' name='cf44'></td>
                                                        <td><input type="radio" value='3' name='cf44'></td>
                                                        <td><input type="radio" value='2' name='cf44'></td>
                                                        <td><input type="radio" value='1' name='cf44'></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6"><b>F5 Perilaku dan Sikap Dosen</td>
        
                                                        </tr>
                                                        <tr>
                                                            <td>Disiplin dalam waktu (memulai dan mengakhiri) perkuliahan (F5-1)</td>
                                                            <td><input type="radio" value='5' name='cf51' required></td>
                                                            <td><input type="radio" value='4' name='cf51'></td>
                                                            <td><input type="radio" value='3' name='cf51'></td>
                                                            <td><input type="radio" value='2' name='cf51'></td>
                                                            <td><input type="radio" value='1' name='cf51'></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mengenakan pakaian dengan rapi (F5-2)</td>
                                                            <td><input type="radio" value='5' name='cf52' required></td>
                                                            <td><input type="radio" value='4' name='cf52'></td>
                                                            <td><input type="radio" value='3' name='cf52'></td>
                                                            <td><input type="radio" value='2' name='cf52'></td>
                                                            <td><input type="radio" value='1' name='cf52'></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jarang mengosongkan perkuliahan (F5-3)</td>
                                                            <td><input type="radio" value='5' name='cf53' required></td>
                                                            <td><input type="radio" value='4' name='cf53'></td>
                                                            <td><input type="radio" value='3' name='cf53'></td>
                                                            <td><input type="radio" value='2' name='cf53'></td>
                                                            <td><input type="radio" value='1' name='cf53'></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Memberikan contoh sikap yang baik kepada Mahasiswa (F5-4)</td>
                                                            <td><input type="radio" value='5' name='cf54' required></td>
                                                            <td><input type="radio" value='4' name='cf54'></td>
                                                            <td><input type="radio" value='3' name='cf54'></td>
                                                            <td><input type="radio" value='2' name='cf54'></td>
                                                            <td><input type="radio" value='1' name='cf54'></td>
                                                        </tr>
        
                                                    </tbody>
                                                    
                                                </table>
                                                F6. Berikan Masukan Anda Untuk Program Studi Mengenai Matakuliah dan Dosen <br>
                                                <textarea name="cf6" rows="5" cols="40" class="form-control"></textarea> <br>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-info">Kirim</button>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
                </div>
                
              </div>
            </div>
          </div>
    </div>
    
    <!-- Row end -->
    <div class="table-container">
        <div class="t-header">Rekap Absen</div>
        <div class="table-responsive">
            {{-- <table id="copy-print-csv" class="table custom-table"> --}}
            <table id="myTable" class="table custom-table">
                <thead>
                    <tr>
                      <th>#</th>
                      <th>Status Absen</th>
                      <th>Tanggal</th>
                      <th>Matakuliah</th>
                      <th>Pertemuan</th>
                      <th>Rangkuman</th>
                      <th>Berita Acara</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
        </table>
        </div>
    </div>
   
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
       $('#myTable').DataTable({
        dom: 'Blfrtip',
                    lengthMenu: [
                        [ 10, 25, 50, 10000 ],
                        [ '10', '25', '50', 'Show All' ]
                    ],
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],    
            paging: true,
            processing: true,
            serverSide: true,
            ajax: '{{ url('/rekap-side/'.$id) }}',
            columns: [
                { name: 'nomer',render: function (data, type, row, meta) {
	                    return meta.row + meta.settings._iDisplayStart + 1;
	                } },
                    { data: 'status_hadir', name: 'status_hadir' },
                    { data: 'tgl_ajar_masuk', name: 'tgl_ajar_masuk' },
                    { data: 'nm_mtk', name: 'nm_mtk' },
                    { data: 'pertemuan', name: 'pertemuan' },
                    { data: 'berita_acara', name: 'berita_acara' },
                { data: 'rangkuman', name: 'rangkuman' }
            ]
        });
     });
    </script>
    @endpush

