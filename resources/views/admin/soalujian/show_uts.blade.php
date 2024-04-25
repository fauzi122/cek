@extends('layouts.dosen.main')

@section('content')
<!-- Content wrapper start -->
<div class="content-wrapper">
    <!-- Row start -->
    <div class="row gutters">

                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="card-header badge-info">
                  <h4 class="m-b-0 text-white">Perakit Soal {{ Auth::user()->name }} - {{ Auth::user()->kode }}</h4>

        </h4>
    </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="container">
                        <div>
                          <br>
                            @if (session('success'))
                            <div class="alert alert-info">
                                {{ session('success') }}
                            </div>
                            @endif
            
                            @if (session('error'))
                            <div class="alert alert-info">
                                {{ session('error') }}
                            </div>
                            @endif
                            @php
                            $id=Crypt::encryptString($soal->kd_mtk.','.$soal->paket.','.Auth::user()->kode);
                            $kirim =Crypt::encryptString ($soal->kd_mtk.','.$soal->paket.','.Auth::user()->kode);                                    
                            @endphp
                            <br>
                            <!-- Modal pilihan ganda -->
                            @include('admin.soalujian.form.modalpg')
                        </div>
                        <div class="invoice-body">
                            <!-- Row start -->
                           
                            <div class="row gutters">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                      {{-- pilihan ganda --}}
                                      @if($soal->jenis_mtk=='PG ONLINE')
                                        @include('admin.soalujian.form.table_pg') 
                                      @endif

                                      {{-- pilihan essay --}}
                                      @if($soal->jenis_mtk=='ESSAY ONLINE')
                                      @include('admin.soalujian.form.table_essay') 
                                      @endif

                                    </div>
                                </div>
                            </div>
                           
                            <!-- Row end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->
        @include('admin.soalujian.info')
    </div>
    <!-- Content wrapper end -->
</div>
@endsection
