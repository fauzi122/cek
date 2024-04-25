@extends('layouts.dosen.main')

@section('content')
<div class="card-body">

    
          
                    <div class="table-container">
                        
                        <div class="t-header">
                          
                                 Form Perubahan Pengawas Ujian 
                                 {{-- <a href="" class="btn btn-sm btn-primary"> <i class="icon-refresh"></i> Kembali</a> --}}
                        </div>
                        <div class="table-responsive">
                            <table id="copy-print-csv" class="table custom-table">
                        
                                <thead>
                                    <tr>
                                        <th>Dosen</th>
                                        <th>Kelas</th>
                                        <th>MTK</th>
                                        <th>Hari</th>
                                        <th>Waktu</th>
                                        <th>Keterangan</th>
                                        <th>Dosen Pengganti</th>
                                        <th>Aksi</th>
                                      </tr>
                        
                                </thead>
                               
                                <tbody>
                                    <tr>
                                        <td>{{ $editsch->nip }}- <b>{{ $editsch->kd_dosen }}</b></td>
                                        <td>{{ $editsch->kd_lokal }}</td>
                                        <td>{{ $editsch->nm_mtk }}- <b>{{ $editsch->kd_mtk }}</b></td>
                                        <td>{{ $editsch->hari_t }}</td>
                                        <td>{{ $editsch->jam_t }}</td>
                                        <td>
                                            <textarea name="alasan" value="{{ old('alasan') }}" 
                                            placeholder="isi alasan tidak mengawas"
                                            class="form-control @error('alasan') is-invalid @enderror"></textarea>
                                            @error('alasan')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                        
                                            </td>
                                        <td>
                                            <input type="text" name="kd_dosen" value="{{ old('kd_dosen') }}" 
                                            placeholder="Masukkan kode dosen"
                                            class="form-control @error('kd_dosen') is-invalid @enderror"
                                            oninput="this.value = this.value.toUpperCase()" maxlength="3">
                        
                                            @error('kd_dosen')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                        
                                            </td>
                                        <td>   <button class="btn btn-info mr-1 btn-submit" type="submit">
                                            <i class="icon-save"></i>
                                Update Data</button></td>
                                    </tr>
                                </tbody>
                        </div>
                        </div>
                    </div>
                </div>
                  
 
    @endsection
 
