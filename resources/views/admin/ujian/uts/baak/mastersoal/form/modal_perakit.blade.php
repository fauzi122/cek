	<div class="modal fade" id="basicModal2" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="basicModalLabel">Edit Perakit Soal</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
                         <form action="/baak/upload-soalpg-ujian" method="post" enctype="multipart/form-data">
                            @csrf
												  

                                         <div class="form-group">
                                          <label for="">kode dosen</label>
                                    <input type="text" hidden  name="kd_mtk" value="{{ $soal->kd_mtk }}">
                                    <input type="text" hidden  name="jenis" value="{{ $soal->paket }}">
                                      <br>
                                    <input type="text" hidden  name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">
                           
                                <p class="text-danger">{{ $errors->first('id_user') }}</p>
                                <input type="text" class="btn btn-primary" name="id_user">                           
                              <button class="btn btn-info btn-lg">
                                    <i class="icon-upload"></i> Upload </button>
                                   
                            </div>
                        </form>

                            	<hr>
                           <label><h5>*Catatan :</h5> 
                           <br>
                          <h6> 1.inputkan kode dosen, untuk mengganti perakit.  

                           <br>
                           2.Soal akan <span class='badge badge-pill badge-light'>TAMPIL</span> pada halaman perakit yang baru</label> .
                          <br>
                           {{-- 3.tidak dapat menyertakan  <span class='badge badge-pill badge-info'>Audio/Gambar</span> saat upload excel. </h6>  --}}
												</div>
									
                    
											</div>
										</div>
									</div>
                          <!-- Modal -->
                          <div class="modal fade" id="basicModal1" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="basicModalLabel">Import Excel Soal Ujian Essay</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                  
                                </div>
                                <div class="modal-body">
                                 <form action="/baak/upload-soalessay-ujian" method="post" enctype="multipart/form-data">
                                    @csrf
                                  <label for="">File (.xls, .xlsx) <a href="{{ Storage::url('public/formatfile/soalessay.xlsx') }}"
                                                class="btn btn-info btn-sm">
                                                Unduh Format File<a></label>
        
                                                 <div class="form-group">
                                        
                                            <input type="number" hidden name="kd_mtk" value="{{ $soal->kd_mtk }}">
                                            <input type="text" hidden name="jenis" value="{{ $soal->paket }}">
                                              <br>
                                           
                                   
                                        <p class="text-danger">{{ $errors->first('file') }}</p>
                                        <input type="file" class="btn btn-primary" name="file">                           
                                      <button class="btn btn-info btn-lg">
                                            <i class="icon-upload"></i> Upload </button>
                                           
                                    </div>
                                </form>
        
                                      <hr>
                                   <label><h5>*Catatan :</h5> 
                                   <br>
                                  <h6> 1.inputkan kode dosen, untuk mengganti perakit.  
        
                                   <br>
                                   2.Soal yang di upload statusnya <span class='badge badge-pill badge-light'>TAMPIL</span></label> .
                                  <br>
                                   3.tidak dapat menyertakan  <span class='badge badge-pill badge-info'>Audio/Gambar</span> saat upload excel. </h6> 
                                </div>
                          
                            
                              </div>
                            </div>
                          </div>