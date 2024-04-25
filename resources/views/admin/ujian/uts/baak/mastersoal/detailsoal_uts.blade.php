@extends('layouts.dosen.ujian.main')

@section('content')
	<div class="main-container">
  	<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">
<!-- Content wrapper start -->
				<div class="content-wrapper">
					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
							<div class="card">
								<div class="card-body p-0">
									<div class="invoice-container">
										
                                            <div class="invoice-body">
                                            <!-- Row start -->
                                            <div class="row gutters">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="table-responsive">                       
                                                <p>
                                                <h4>Review Soal Pilihan Ganda</h4>
                                                <hr>
                                                </p>
                                                <p>
                                                    <h5>{!! $detailsoal->soal !!}</h5>
                                                  </p>
                                                     <p>
                                                   @if ($detailsoal->file!=null)
                                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
											
                                                  <img src="{{ Storage::url('public/soal/'.$detailsoal->file) }}" class="img-fluid rounded" />
										                            </div>
                                                  @else
                                  
                                                  {{-- <img src="{{ Storage::url('public/icon/profile.png') }}" class="img-thumbnail" height="150" width="200"> --}}
                                                  @endif
                                                    
                                                     </p>

                                                <p><input type="radio" name="pilihan" id="pil_a">
                                                    <label for="pil_a">
                                                      <?php $pila = str_replace("<p>", "", $detailsoal->pila); $pila = str_replace("</p>", "", $pila); echo $pila; ?>
                                                    </label>
                                                  </p>
                                                  <p><input type="radio" name="pilihan" id="pil_b">
                                                    <label for="pil_b">
                                                      <?php $pilb = str_replace("<p>", "", $detailsoal->pilb); $pilb = str_replace("</p>", "", $pilb); echo $pilb; ?>
                                                    </label>
                                                  </p>
                                                  <p><input type="radio" name="pilihan" id="pil_c">
                                                    <label for="pil_c">
                                                      <?php $pilc = str_replace("<p>", "", $detailsoal->pilc); $pilc = str_replace("</p>", "", $pilc); echo $pilc; ?>
                                                    </label>
                                                  </p>
                                                  <p><input type="radio" name="pilihan" id="pil_d">
                                                    <label for="pil_d">
                                                      <?php $pild = str_replace("<p>", "", $detailsoal->pild); $pild = str_replace("</p>", "", $pild); echo $pild; ?>
                                                    </label>
                                                  </p>
                                                  <p><input type="radio" name="pilihan" id="pil_e">
                                                    <label for="pil_e">
                                                      <?php $pile = str_replace("<p>", "", $detailsoal->pile); $pile = str_replace("</p>", "", $pile); echo $pile; ?>
                                                    </label>
                                                  </p>
                                                  <?php
                                                    if ($detailsoal->status == 'Y') {
                                                      $status_soal = '<span class="badge badge-pill badge-light">Tampil<span>';
                                                    }else{
                                                      $status_soal = '<span class="badge badge-pill badge-secondary">Tidak tampil</span>';
                                                    }
                                                  ?>
                                                  <p>Status soal {!! $status_soal !!}</p>
                                                  <hr>
                                                 
                                                  @php
                                                  $detail=Crypt::encryptString($detailsoal->id);                                    
                                                  @endphp
								
									                              {{--  <a href="/baak/edit-detail/soal/{{$detail}}" class="btn btn-success">Edit</a>  --}}

                                                </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <div class="row gutters">	
                                <div class="box-body">
                                <div class="alert-notify info">
                                    <div class="alert-notify-body">
                                    <span class="type">Info Penting</span>
                                   
                                    <div class="alert-notify-text"> <i>Di halaman ini Anda dapat melihat tampilan soal yang akan dikerjakan oleh Mahasiswa.
                                    </i> <p> <br>
                                        Silahkan koreksi jika soal yang tampil disamping kurang sesuai dengan yang diharapkan, Anda dapat melakukan perubahan terhadap soal tersebut.</div>
                                        
                                        <br>
                                        <hr>
                                        <table border=0>
                                          <tr>
                                            <td>Perakit Soal </td>
                                            <td>: <b>{{ $detailsoal->id_user }}</b></td>
                                          </tr>
                                          
                                          <tr>
                                            <td>Disetujui oleh </td>
                                            <td>: <b>{{ $detailsoal->petugas }}</b></td>
                                          </tr>
                                          <tr>
                                            <td>Tgl pembuatan soal </td>
                                            <td>: <b>{{ $detailsoal->created_at }}</b></td>
                                          </tr>
                                        </table>
                                    </div>
                                </div>
                                </div>
                            </div>
							</div>
						</div>
					</div>
					<!-- Row end -->


				</div>
				</div>
				</div>
				<!-- Content wrapper end -->
@endsection
