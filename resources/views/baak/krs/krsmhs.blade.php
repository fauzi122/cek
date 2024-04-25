@extends('layouts.dosen.main')

@section('content')
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <h5>Stap 1 Menentukan semester sekaligus mengosongkan data</h5>
                <form action="/input-semester" method="POST">
                    @csrf
                    <div class="row gutters">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Semester</label>
                                <input type="text" name="semester" class="form-control time" placeholder="Semester" value="{{$penilaian->smt}}">
                                <code>Contoh : '1','2','3','5','7','8','9'</code>
                            </div>
                            <button type="submit" class="btn btn-info">Simpan</button>             
                </form>
                        </div>
                    </div>
                    <hr>
                    <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <h5>Step 2 : Klik tombol dibawah untuk mengambil data krs dari sisfo ke mybest</h5>
                        <div class="form-group">
                            @php
     for ($i= 1; $i <= $penilaian->lastPage; $i++) { 
			if ( $bagi = $i % 10 == 0 ) {
                echo "
                <a href='".url("/send-semester/".Crypt::encryptString($i)) ."' type='button' class='btn btn-info'>Klik $i</a>
                "; 
			}
		}
        if (substr($penilaian->lastPage,1)!='0') {
            echo "
                <a href='".url("/send-semester/".Crypt::encryptString($penilaian->lastPage)) ."' type='button' class='btn btn-info'>Klik $penilaian->lastPage</a>
                ";
            }
 @endphp
                        </div>
                    </div>
                    </div>
                    <hr>
                    <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <h5>Step 3 : Klik tombol dibawah untuk mengambil data mhs dari sisfo ke mybest</h5>
                        <div class="form-group">
                            <a href="{{url("/hapus-mhs")}}" type='button' class='btn btn-info'> Hapus Mahasiswa</a>
@php
for ($i= 1; $i <= $penilaian->lastPage; $i++) { 
       if ( $bagi = $i % 10 == 0 ) {
           echo "
           <a href='".url("/send-mhs/".Crypt::encryptString($i)) ."' type='button' class='btn btn-info'>Klik $i</a>
           "; 
       }
   }
   if (substr($penilaian->lastPage,1)!='0') {
       echo "
           <a href='".url("/send-mhs/".Crypt::encryptString($penilaian->lastPage)) ."' type='button' class='btn btn-info'>Klik $penilaian->lastPage</a>
           ";
       }
@endphp
                    
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <h5>Step 4 : Klik tombol sinkron untuk merubah kd_mtk agama</h5>
                        <div class="form-group">
                    <form action="/krs/agama-kristen/singkron" method="POST">
                            @csrf
                            <button class="btn btn-info btn-lg" type="submit">
                                <i class="icon-loader"></i> Singkron Data </button>   
                       
                        </form>
            </div>
        </div>
    </div>
                      

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="table-container"> 
                    <div class="t-header">
                        <a href="" class="" style="padding-top: 10px;"><i class="icon-user-check"></i>  Data KRS Mahasiswa</a>
                        <p><h3>catatan : Data Jadwal Yang di tampilkan di Sisi Mahasiswa Berdasarkan KRS yang 
                            <p>Tertera di Bawah ini </h3>
                    </div>
                
                    <div class="card-body">
                        <form action="/krs/mhs" method="GET">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    
                                    <input type="text" class="form-control" name="q"
                                           placeholder="cari berdasarkan nim mahasiswa">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                <tr>
                                   
                                    <th scope="col" style="width: 15%">NIM</th>
                                    <th scope="col">NO KRS</th>
                                    <th scope="col">KD MTK</th>
                                    <th scope="col">KEL PRAKTEK</th>
                                   
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($krsmhs as $no => $dosen)
                                    <tr>
                                        
                                        <td>{{ $dosen->nim }}</td>
                                        <td>{{ $dosen->no_krs }}</td>
                                        <td>{{ $dosen->kd_mtk }}</td>
                                        <td>{{ $dosen->kel_praktek }}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div style="text-align: center">
                                {{$krsmhs->links("vendor.pagination.bootstrap-4")}}
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection

    @push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
      $('.time').mask("'0','0','0','0','0','0','0','0','0'");
     });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
@endpush


