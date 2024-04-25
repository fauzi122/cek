@extends('layouts.mhs.main')

@section('content')
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>
<div class="main-container">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header"><strong>PERSEPSI MAHASISWA MENGENAI DOSEN PERIODE
           
           </strong>
            </div>
            <div class="card-body">
                <div class="example">
                    <div class="tab-content rounded-bottom">
                        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                           
                            <form method="POST" action="/store/kuisoner-mpd" enctype="multipart/form-data">
                                @csrf
                                <p><b>FORM PERSEPSI MAHASISWA MENGENAI DOSEN </b> (Diisi sebanyak Jumlah Dosen)</p>
                                <!-- /.col-->
                                <div class="tab-content rounded-bottom">
                                    <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1004">
                                        <div class="row">
                                            <div class="col-8 col-lg-8">
                                                <div class="card">
                                                    <div class="card-body p-3 d-flex align-items-center">
                                                        <div>
                                                            <div class="fs-6 fw-semibold text-danger">
                                                                Cara Pengisian:<br>
                                                                1. Pilih Nama Dosen pengampu Matakuliah<br>
                                                                2. Isikan Kuesioner pada menu dibawahnya, lalu Simpan<br>
                                                                3. Lakukan Sebanyak Jumlah Matakuliah yang ditempuh semester ini.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.col-->
                                            <div class="col-4 col-lg-4">
                                                <div class="card">
                                                    <div class="card-body p-3 d-flex align-items-center flex-column">
                                                        <div class="fs-6 fw-semibold text-danger">Dosen Sudah Dinilai</div>
                                                        <br> <!-- Menambahkan baris baru di sini -->
                                                        <div align="center">
                                                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                                <input class="form-control" id="staticEmail" type="text" name="kelas" readonly="" value="{{ Auth::user()->kode }}">
                                            </div>
                                        </div>
                                        <div class="mb-8 row">
                                            <label class="col-sm-4 col-form-label" for="inputPassword"><b> F1-3 </b>Program Studi</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="staticEmail" type="text" name="prodi" readonly="" value="{{ $result->nm_jrs }}">
                                            </div>
                                        </div>
                                        <div class="mb-8 row">
                                            <label class="col-sm-4 col-form-label" for="inputPassword"><b> F1-4 </b>UPPS</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" id="staticEmail" type="text" name="upps" readonly="" value="{{ $result->upps }}">
                                            </div>
                                        </div>
                                        <div class="mb-8 row">
                                            <label class="col-sm-4 col-form-label"><b> F1-5 </b>Pilih Dosen</label>
                                            <div class="col-sm-6">
                                                

                                            </div>
                                        </div>
                                        <div class="mb-8 row">
                                            <label class="col-sm-4 col-form-label" for="inputPassword"><b> F1-6 </b>Periode</label>
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
                                                            <th width='20%' align='center'>Sangat Tidak Setuju<br></th>
                                                            <th width='15%' align='center'>Tidak Setuju<br></th>
                                                            <th width='15%' align='center'>Cukup Setuju<br></th>
                                                            <th width='10%' align='center'> Setuju<br></th>
                                                            <th width='20%' align='center'>Sangat Setuju<br></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="6"> <strong>(F3) Kemampuan Mengajar Dosen </strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Menguasai Materi yang Diajarkan (F31)</td>
                                                            <td><input type="radio" value='1' name='cf31' required></td>
                                                            <td><input type="radio" value='2' name='cf31'></td>
                                                            <td><input type="radio" value='3' name='cf31'></td>
                                                            <td><input type="radio" value='4' name='cf31'></td>
                                                            <td><input type="radio" value='5' name='cf31'></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Menyampaikan Materi dengan Jelas (F32)</td>
                                                            <td><input type="radio" value='1' name='cf32' required></td>
                                                            <td><input type="radio" value='2' name='cf32'></td>
                                                            <td><input type="radio" value='3' name='cf32'></td>
                                                            <td><input type="radio" value='4' name='cf32'></td>
                                                            <td><input type="radio" value='5' name='cf32'></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Materi yang diajarkan sesuai dengan RPS (F33)</td>
                                                            <td><input type="radio" value='1' name='cf33' required></td>
                                                            <td><input type="radio" value='2' name='cf33'></td>
                                                            <td><input type="radio" value='3' name='cf33'></td>
                                                            <td><input type="radio" value='4' name='cf33'></td>
                                                            <td><input type="radio" value='5' name='cf33'></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Cara Mengajar tidak Membosankan (F34)</td>
                                                            <td><input type="radio" value='1' name='cf34' required></td>
                                                            <td><input type="radio" value='2' name='cf34'></td>
                                                            <td><input type="radio" value='3' name='cf34'></td>
                                                            <td><input type="radio" value='4' name='cf34'></td>
                                                            <td><input type="radio" value='5' name='cf34'></td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="6"><b>F4 Kemampuan Berkomunikasi Dosen dengan Mahasiswa</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Melakukan diskusi dengan mahasiswa (F41)</td>
                                                                <td><input type="radio" value='1' name='cf41' required></td>
                                                                <td><input type="radio" value='2' name='cf41'></td>
                                                                <td><input type="radio" value='3' name='cf41'></td>
                                                                <td><input type="radio" value='4' name='cf41'></td>
                                                                <td><input type="radio" value='5' name='cf41'></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Mampu memotivasi mahasiswa (F42)</td>
                                                                <td><input type="radio" value='1' name='cf42' required></td>
                                                                <td><input type="radio" value='2' name='cf42'></td>
                                                                <td><input type="radio" value='3' name='cf42'></td>
                                                                <td><input type="radio" value='4' name='cf42'></td>
                                                                <td><input type="radio" value='5' name='cf42'></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Memberikan informasi akademik dengan tepat (F43)</td>
                                                                <td><input type="radio" value='1' name='cf43' required></td>
                                                                <td><input type="radio" value='2' name='cf43'></td>
                                                                <td><input type="radio" value='3' name='cf43'></td>
                                                                <td><input type="radio" value='4' name='cf43'></td>
                                                                <td><input type="radio" value='5' name='cf43'></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tanggap terhadap permasalahan akademik Mahasiswa (F44)</td>
                                                                <td><input type="radio" value='1' name='cf44' required></td>
                                                                <td><input type="radio" value='2' name='cf44'></td>
                                                                <td><input type="radio" value='3' name='cf44'></td>
                                                                <td><input type="radio" value='4' name='cf44'></td>
                                                                <td><input type="radio" value='5' name='cf44'></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6"><b>F5 Perilaku dan Sikap Dosen</td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Disiplin dalam waktu (memulai dan mengakhiri) perkuliahan (F51)</td>
                                                                    <td><input type="radio" value='1' name='cf51' required></td>
                                                                    <td><input type="radio" value='2' name='cf51'></td>
                                                                    <td><input type="radio" value='3' name='cf51'></td>
                                                                    <td><input type="radio" value='4' name='cf51'></td>
                                                                    <td><input type="radio" value='5' name='cf51'></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mengenakan pakaian dengan rapi (F52)</td>
                                                                    <td><input type="radio" value='1' name='cf52' required></td>
                                                                    <td><input type="radio" value='2' name='cf52'></td>
                                                                    <td><input type="radio" value='3' name='cf52'></td>
                                                                    <td><input type="radio" value='4' name='cf52'></td>
                                                                    <td><input type="radio" value='5' name='cf52'></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Jarang mengosongkan perkuliahan (F53)</td>
                                                                    <td><input type="radio" value='1' name='cf53' required></td>
                                                                    <td><input type="radio" value='2' name='cf53'></td>
                                                                    <td><input type="radio" value='3' name='cf53'></td>
                                                                    <td><input type="radio" value='4' name='cf53'></td>
                                                                    <td><input type="radio" value='5' name='cf53'></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Memberikan contoh sikap yang baik kepada Mahasiswa (F54)</td>
                                                                    <td><input type="radio" value='1' name='cf54' required></td>
                                                                    <td><input type="radio" value='2' name='cf54'></td>
                                                                    <td><input type="radio" value='3' name='cf54'></td>
                                                                    <td><input type="radio" value='4' name='cf54'></td>
                                                                    <td><input type="radio" value='5' name='cf54'></td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                        F6. Berikan Masukan Anda Untuk Program Studi Mengenai Matakuliah dan Dosen <br>
                                                        <textarea name="cf6" rows="5" cols="40" class="form-control"></textarea> <br>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-info">Kirim Tugas</button>
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
</div>
</div>

@endsection