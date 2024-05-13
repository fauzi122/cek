	<nav class="navbar navbar-expand-lg custom-navbar">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#WafiAdminNavbar" aria-controls="WafiAdminNavbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon">
				<i></i>
				<i></i>
				<i></i>
			</span>
		</button>
		<div class="collapse navbar-collapse" id="WafiAdminNavbar">
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle active-page" href="#" id="dashboardsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="icon-devices_other nav-icon"></i>
						Dashboard
					</a>
					<ul class="dropdown-menu" aria-labelledby="dashboardsDropdown">
						<li>
							<a class="dropdown-item" href="/dashboard-ujian">Dashboard Ujian</a>
						</li>
						<li>
							<a class="dropdown-item" href="/dashboard">Kembali Ke Dasboard</a>
						</li>


					</ul>
				</li>
				@can('master_data_ujian')
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="icon-package nav-icon"></i>
						Master Data
					</a>
					<ul class="dropdown-menu" aria-labelledby="appsDropdown">
						@can('mtk_ujian')
						<li>
							<a class="dropdown-item" href="/pilih-mtk-uji">Matakuliah Ujian</a>
						</li>
						@endcan

						@can('master_soal_ujian')
						<li>
							<a class="dropdown-item" href="/soal/master-baak">Master Soal </a>
						</li>
						@endcan

						@can('peserta_ujian')
						<li>
							<a class="dropdown-item" href="/peserta-ujian">Peserta Ujian</a>
						</li>
						@endcan

						@can('panitia_ujian')
						<li>
							<a class="dropdown-item" href="/panitia-uji">List Panitia </a>
						</li>
						@endcan
						@can('perakit_ujian')
						<li>
							<a class="dropdown-item" href="/perakit-soal">Perakit Soal </a>
						</li>
						@endcan

					</ul>
				</li>
				@endcan

				@can('jadwal_ujian')
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="icon-book-open nav-icon"></i>
						Jadwal Ujian
					</a>

					<ul class="dropdown-menu" aria-labelledby="pagesDropdown">
						@can('jadwal_ujian')
						<li>
							<a class="dropdown-item" href="/jadwal-uji-baak">Jadwal Dosen</a>
						</li>
						@endcan

						

					</ul>
				</li>
				@endcan

				@can('ralat_soal')
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="uiElementsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="icon-layers2 nav-icon"></i>
						Ruang Komplain
					</a>
					<ul class="dropdown-menu" aria-labelledby="uiElementsDropdown">
						<li>
							<a class="dropdown-item" href="/halaman-komplain-ujian">Komplain Ujian</a>
						</li>
						<li>
							<a class="dropdown-item" href="/halaman-komplain-soal">Komplain Soal</a>
						</li>

					</ul>
				</li>
				@endcan

				@can('laporan_ujian')
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="uiElementsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="icon-folder nav-icon"></i>
						Laporan
					</a>
					<ul class="dropdown-menu" aria-labelledby="uiElementsDropdown">
						@can('rekap_mengawas_ujian')
						<li>
							<a class="dropdown-item" href="carousel.html">Rekap Mengawas Ujian</a>
						</li>
						@endcan
						@can('rekap_nilai_ujian')
						<li>
							<a class="dropdown-item" href="modals.html">Rekap Nilai Ujian </a>
						</li>
						@endcan
				</li>

			</ul>
			</li>
			@endcan

			@can('administrasi_ujian')
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="icon-edit1 nav-icon"></i>
					ADMINISTRASI
				</a>
				<ul class="dropdown-menu" aria-labelledby="formsDropdown">
					{{-- @can('panitia_administrasi_ujian')
					<li>
						<a class="dropdown-item" href="/adm-panitia-uji">Panitia Ujian</a>
					</li>
					@endcan --}}

					@can('peserta_administrasi_ujian')
					<li>
						<a class="dropdown-item" href="/adm-peserta-uji">Peserta Ujian</a>
					</li>
					@endcan

					@can('rekap_administrasi_ujian')
					<li>
						<a class="dropdown-item" href="/adm-rekap-mengawas">Rekap Mengawas</a>
					</li>
					@endcan

					@can('dosen_pengganti_mengawas')
						<li>
							<a class="dropdown-item" href="/pengganti-mengawas">Dosen Pengganti</a>
						</li>
					@endcan

					{{-- @can('mhs_kurang_bayar') --}}
					@can('ujian_mhs_kurang_bayar')

						<li>
							<a class="dropdown-item" href="/kurang-bayar">Mhs Kurang Bayar</a>
						</li>
					@endcan
					@can('ujian_bap')

						<li>
							<a class="dropdown-item" href="/rekap-bap">Rekapitulasi BAP</a>
						</li>
					@endcan

					@can('ujian_absen')

						<li>
							<a class="dropdown-item" href="/rekapitulasi-absen-ujian">Rekapitulasi absen</a>
						</li>
					@endcan
				</ul>
			</li>
			@endcan

			@can('log_ujian')
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="formsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="icon-file nav-icon"></i>
					Log Aktivitas
				</a>
				<ul class="dropdown-menu" aria-labelledby="formsDropdown">
					<li>
						<a class="dropdown-item" href="">Log Aktivitas</a>
					</li>


				</ul>
			</li>
			</ul>
			@endcan
		</div>
	</nav>