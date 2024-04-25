@extends('layouts.dosen.main')
@section('content')
<div class="main-container">
  <div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
  <div class="flash-error" data-flasherror="{{ session('error') }}"></div>
  <!-- Row start -->
  <div class="row gutte">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  
	<div class="row gutters">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
			<div class="alert-notify info">
				<div class="alert-notify-body">
					<span class="type">Info</span>
					<div class="alert-notify-title">Cara Penggunaan<img src="{{ asset('assets/img/notification-info.svg') }}" alt=""></div>
					<div class="alert-notify-text">
					   <li>
							<ul>langkah Pertama  Silahkan masukan/simpan nomor sistem MyBest <b>0813-2251-0921</b> kedalam smartphone anda dengan nama "MyBest Elearning Asistant".
						</ul>
						</li> 
					
						<li>
							<ul>kemudian masukan nomor sistem mybest kedalam grup WA, dengan penamaan grup WA wajib sesuai yang diberikan sistem pada tabel dibawah. -> <b>{{ $pecah[0].'-'.$pecah[1] }}</b></ul>
						</li>
						
						<li>
							<ul>klik tombol <b>SINKRON</b> pada tabel dibawah jika grup WA telah dibuat dan nomor sistem mybest sudah dimasukan kedalamnya. (group akan mengirimkan pesan otomatis, menandakan WA sudah terkoneksi).
						</ul>
							 <li>
							<ul>masukan daftar WA mahasiswa kelas yang diajarkan ke dalam grup ini, agar setiap tugas/materi/video yang diupdate pada laman Mybest langsung dapat diketahui melalui WA mahasiswa.
						</ul>
						</li><br>
						Catatan :<br>
						*  Nomor sistem mybest akan ditampilkan diawal perkuliahan.<br> 
						** Respon Notif WA akan terkirim ke mahasiswa jika dosen melakukan pengisian Tugas, Update Materi/Video, fitur lainnya.
					</div>
				</div>
			</div>
		</div>
	</div>
      <div class="table-container " >
       <div class="" > 
        <h4> 
		 Sinkronisasi Group Whatsapp <code>BETA</code>
          <!-- <a href="#"><button class="btn btn-primary btn-lg"  ><i class="icon-pencil"> </i> Create Or Update</button></a> -->
          
      </h4>
      <hr>
      </div>
      
        <div class="table-responsive">
          <table id="copy-print-csv" class="table custom-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Mtk</th>
                <th>Kelas</th>
                <th>NIP</th>
                <th>Nama Grup</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody> 
            <tr>
                <td>1</td>
                <td>{{ $pecah[1] }}</td>
                <td>{{ $pecah[0] }}</td>
                <td>{{ $pecah[2] }}</td>
                <td>{{ $pecah[0].'-'.$pecah[1] }}</td>
                <td>
				@php
					$id=base64_encode($pecah[0].','.$pecah[1].','.$pecah[2]);                                    
				@endphp
                 <center>
				@if($wa < 1)
					 <form action="/sinkron-wa"  method="POST">
					 @csrf
					 <input type="hidden" name="kd_mtk" value={{$pecah[1]}}>
					 <input type="hidden" name="kd_lokal" value={{$pecah[0]}}>
					 <input type="hidden" name="nip" value={{$pecah[2]}}>
					 <input type="hidden" name="nm_group" value={{$pecah[0].'-'.$pecah[1]}}>
					<button type="submit" class="btn btn-xs btn-info"><i class="icon-cycle"></i> Sinkron</button>
					</form>
                      <!-- <button onClick="Delete(this.id)" class="btn btn-xs btn-secondary" id="">
                        <i class="icon-trash"></i> Hapus
                      </button> -->
                    </center>
				@else
				<a href="#" class="btn btn-xs btn-success"><i class="icon-cycle"></i> Sudah Sinkron</a>
				@endif
                
			</td>
		</tr>

            </tbody>
          </table>
	
        </div>
      </div>


    </div>
  </div>
  <!-- Row end -->


</div>

@endsection
<!-- @push('scripts')

<script>

	//ajax delete
	function Delete(id)
	{
		var id = id;
		var token = $("meta[name='csrf-token']").attr("content");
  
		 Swal.fire({
			title: 'Yakin akan dihapus?',
			text: "Data yang telah dihapus tidak bisa dikembalikan.",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then(function(result) {
			// console.log(Swal.DismissReason);
			if (result.dismiss) {
  
				return true;
  
			} else {
			
				//ajax delete
				jQuery.ajax({
					url: "{{ url('/destroy-wa') }}"+'/'+id,
					data: 	{
						"id": id,
						"_token": token
					},
					type: 'DELETE',
					success: function (response) {
						if (response.status == "success") {
							Swal.fire({
								title: 'BERHASIL!',
								text: 'DATA BERHASIL DIHAPUS!',
								type: 'success',
								timer: 1000,
								showConfirmButton: false,
								showCancelButton: false,
								buttons: false,
							}).then(function() {
								location.reload();
							});
						}else{
								Swal.fire({
								title: 'GAGAL!',
								text: 'DATA GAGAL DIHAPUS!',
								type: 'error',
								timer: 1000,
								showConfirmButton: false,
								showCancelButton: false,
								buttons: false,
							}).then(function() {
								location.reload();
							});
						}
					}
				});
			}
		})
	}
  </script>  
	@endpush -->