<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>MYBEST Jadwal Kuliah</title>
    <!-- Custom CSS -->
    <link href="{{asset('eliteadmin')}}/dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="skin-blue fix-header single-column card-no-border fix-sidebar">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Elite admin</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">&nbsp;&nbsp; <img src="{{asset('eliteadmin')}}/{{$datasays->logo}}" alt="homepage" class="dark-logo" width="50" />
                    <div class="col-md-11 align-self-center m-t-10">


                        <h2 class="text-dark text-left"><b><b> <b class='text-white'>Universitas Bina Sarana Informatika <b>&nbsp;&nbsp;&nbsp; >&nbsp; > &nbsp;> &nbsp; Kampus : {{$ref_cabang->nm_kampus}}</b></b></b></h2>
                    </div>
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->


                        <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12"> <br>

                        <!--  <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" id="1">Informasi Terbaru</h4>
                                <b>[Reminder] Untuk Mahasiswa <b>semester 4</b> keatas perlu dipersiapkan untuk mengikuti sertifikati <b>Kompetensi</b>.</b>
                                
                            </div>
                        </div> -->
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center"><b>Jadwal Perkuliahan {{$namaHari}}, {{ formattanggal2(date('Y-m-d'))}}</b> </h4>

                                <div class="table-responsive">
                                    <table class="table color-bordered-table primary-bordered-table">
                                        <thead>
                                            <tr>

                                                <th width='15%' class='text-left'>WAKTU</th>
                                                <th width='10%' class='text-left'>RUANG</th>
                                                <th width='10%' class='text-left'>KELAS</th>
                                                <th width='35%' class='text-left'>MATA KULIAH</th>
                                                <th class='text-left'>DOSEN</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                        </tbody>
                                    </table>
                                </div>
                                <div id="tbody3" class='text-center text-danger'> </div>


                            </div>
                        </div>
                    </div>

                    <!--  <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" id="1">1. Title will be here</h4>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
                                
                            </div>
                        </div>
                    </div>-->
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-skin="skin-default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-blue" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-skin="skin-default-dark" class="default-dark-theme ">7</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-skin="skin-megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>
                            <ul class="m-t-20">

                                @forelse ($ref_cabangpilih as $datajadwalx)
                                <li><a href="/jadwalkuliah/{{$datajadwalx->kd_kampus}}"><b class='text-info'><b>{{$datajadwalx->nm_kampus}}</b></b></a></li>

                                @empty

                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('eliteadmin')}}/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('eliteadmin')}}/assets/node_modules/popper/popper.min.js"></script>
    <script src="{{asset('eliteadmin')}}/assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('eliteadmin')}}/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="{{asset('eliteadmin')}}/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="{{asset('eliteadmin')}}/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('eliteadmin')}}/dist/js/custom.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const data = JSON.parse(@json($datajadwalharianJson));
            let currentIndex = 0;
            let lastCheckedDate = new Date().getDate(); // Menyimpan tanggal saat halaman pertama kali dimuat

            function modifyPrefix(text) {
                const prefixes = ['EN', 'EL', 'ET'];
                const prefix = text.substring(0, 2).toUpperCase();
                if (prefixes.includes(prefix)) {
                    return 'ELEARNING';
                }
                return text;
            }

            function showData() {
                const tbody = document.querySelector('tbody');
                tbody.innerHTML = '';

                const dataToShow = data.slice(currentIndex, currentIndex + 10);

                if (dataToShow.length === 0) {
                    currentIndex = 0;
                    showData();
                    return;
                }

                dataToShow.forEach(item => {
                    const tr = document.createElement('tr');
                    tbody.appendChild(tr);
                    const dataToDisplay = [
                        item.jam_t,
                        modifyPrefix(item.no_ruangx),
                        item.kd_lokalx,
                        item.nm_mtk,
                        item.nm_dosen
                    ];

                    dataToDisplay.forEach((text, index) => {
                        const td = document.createElement('td');
                        td.classList.add('text-left');
                        td.style.fontWeight = 'bold';
                        tr.appendChild(td);
                        displayTextCharByChar(text, td, 0, 'default');
                    });
                });

                currentIndex += 10;
            }

            function displayTextCharByChar(text, element, index, color) {
                if (index < text.length) {
                    const charHtml = (color === 'blue' || color === 'red') ? `<span style="color: ${color};">${text.charAt(index)}</span>` : text.charAt(index);
                    element.innerHTML += charHtml;
                    setTimeout(() => displayTextCharByChar(text, element, index + 1, color), 50);
                }
            }

            function checkPageBeforeReload() {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', window.location.href, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            window.location.reload();
                        } else {
                            const errorDiv = document.getElementById('tbody3');
                            errorDiv.textContent = 'Gagal Reload Halaman: ' + xhr.status + '. Mencoba kembali...';
                            setTimeout(checkPageBeforeReload, 5000);
                        }
                    }
                };
                xhr.send();
            }

            function checkDateAndReload() {
                const currentDate = new Date().getDate();
                if (currentDate !== lastCheckedDate) {
                    window.location.reload();
                }
            }

            setInterval(showData, 20000);
            setInterval(checkDateAndReload, 60000);
            showData();
        });
    </script>







</body>

</html>