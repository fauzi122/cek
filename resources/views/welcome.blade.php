<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  {{--  <title>Arsha Bootstrap Template - Index</title>  --}}
        <script language='JavaScript'>
            var txt=" My Best | Universitas Bina Sarana Informatika |";
            var speed=300;
            var refresh=null;
            function action() { document.title=txt;
            txt=txt.substring(1,txt.length)+txt.charAt(0);
            refresh=setTimeout("action()",speed);}action();
        </script>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link href="{{ asset('assets/img/icon1.jfif') }}" rel="icon">
  <link href="{{ Storage::url('public/logo/ubsi.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->

  <!-- Vendor CSS Files -->
  <link href="{{ asset('home/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('home/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('home/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('home/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ asset('home/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('home/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{ asset('home/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('home/assets/css/style.css')}}" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      {{-- <h1 class="logo me-auto"><a href="/"><img src="{{ Storage::url('public/mybest_3.png') }}" alt="" loading="lazy"  class="img-fluid" width="150" height="200"></a></h1> --}}
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="{{ asset('home/assets/img/logo.png')}}" alt="" loading="lazy"  class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#skills">Fitur</a></li>
          <li><a class="nav-link  scrollto" href="#cta">Daftar MBKM</a></li>
          <li><a class="nav-link scrollto" href="#contact">Kontak Kami</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>MyBest</h1>
          <h2>Selamat datang dipembelajaran e-Learning Mybest Universitas Bina Sarana Informatika</h2>
          <div class="d-flex justify-content-center justify-content-lg-start">
            @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    @if (auth()->user()->utype === 'MHS')
                        <a href="{{ url('/user/dashboard') }}" class="btn-get-started scrollto">Dashboard Mahasiswa</a>
                    @elseif (auth()->user()->utype === 'ADM')
                        <a href="{{ url('/dashboard') }}" class="btn-get-started scrollto">Dashboard Admin</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-get-started scrollto">Masuk</a>

                  
                @endauth
            </div>
        @endif      
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="{{ asset('assets/assets_dasboard/img/home.svg')}}" class="img-fluid animated" alt="" loading="lazy" >
        </div>
      </div>
    </div>

  </section><!-- End Hero -->
  
  <main id="main">
    <!-- ======= Clients Section ======= -->
    <section id="clients" class="clients section-bg">
      <div class="container">
        <div class="row" >
          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="{{ Storage::url('public/logo/ubsi_t.png') }}" class="img-fluid" alt="" loading="lazy" >
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="{{ Storage::url('public/logo/logo_campus.png') }}" class="img-fluid" alt="" loading="lazy" >
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="{{ Storage::url('public/logo/logo_alumni.png') }}" class="img-fluid" alt="" loading="lazy" >
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="{{ Storage::url('public/logo/lldikti3.jpg') }}" class="img-fluid" alt="" loading="lazy" >
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="{{ Storage::url('public/logo/kampus_merdeka.jpg') }}" class="img-fluid" alt="" loading="lazy" >
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <img src="{{ Storage::url('public/logo/icei.png') }}" class="img-fluid" alt="" loading="lazy" >
          </div>

        </div>

      </div>
    </section>
    <!-- End Cliens Section -->

    <!-- ======= Skills Section ======= -->
    <section id="skills" class="skills">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-6 d-flex align-items-center" data-aos="fade-right" data-aos-delay="100">
            <img src="{{ asset('assets/img/about-img.png')}}" class="img-fluid" alt="" loading="lazy" >
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
            <h3>Fitur Aplikasi MyBest</h3>
            <p class="fst-italic">
              Pembelajaran terintegrasi dengan Mobile Apps
            </p>

            <div class="skills-content">

              <div class="progress">
                <span class="skill">Presensi & Rekapitulasi Kehadiran <i class="bi bi-bookmark-check val"></i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="progress">
                <span class="skill">Materi, Slide, Modul, Silabus, RPS <i class="bi bi-bookmark-check val"></i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="progress">
                <span class="skill">Tugas Pertemuan <i class="bi bi-bookmark-check val"></i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="progress">
                <span class="skill">Referensi Materi/Video Tambahan <i class="bi bi-bookmark-check val"></i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="progress">
                <span class="skill">Rangkuman Materi <i class="bi bi-bookmark-check val"></i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="progress">
                <span class="skill">Kuliah Pengganti <i class="bi bi-bookmark-check val"></i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

            </div>

          </div>
        </div>

      </div>
    </section><!-- End Skills Section -->

    <!-- ======= Services Section ======= -->
    {{--  <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Services</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row">
          <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box">
              <div class="icon"><i class="bx bxl-dribbble"></i></div>
              <h4><a href="">Lorem Ipsum</a></h4>
              <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-file"></i></div>
              <h4><a href="">Sed ut perspici</a></h4>
              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-tachometer"></i></div>
              <h4><a href="">Magni Dolores</a></h4>
              <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="400">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-layer"></i></div>
              <h4><a href="">Nemo Enim</a></h4>
              <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
            </div>
          </div>

        </div>

      </div>
    </section>  --}}
    <!-- End Services Section -->

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">
        <div class="row">
          <div class="col-lg-9 text-center text-lg-start">
            <h3>Merdeka Belajar Kampus Merdeka!</h3>
            <p> Kampus Merdeka adalah cara terbaik berkuliah. Dapatkan kemerdekaan untuk membentuk masa depan yang sesuai dengan aspirasi kariermu..</p>
          </div>
          <div class="col-lg-3 cta-btn-container text-center">
            <a class="cta-btn align-middle" href="#" data-toggle="modal" data-target="#exampleModalLong">Daftar MBKM</a>
          </div>
        </div>

      </div>
    </section>
    <!-- End Cta Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
          {{--  <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>  --}}
        </div>

        <div class="row">

          <div class="col-lg-5 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>Jl. Kramat Raya No.98, RW.9, Kwitang, Kec. Senen, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10450</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>elearning@bsi.ac.id</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>(021)8000063</p>
              </div>
              
                <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Hotline 1:</h4>
                <p>081381507561</p>
              </div>
                 <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Hotline 2:</h4>
                <p>081381507125</p>
              </div>

              {{--  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d991.6515850141262!2d106.84221341517201!3d-6.183408590112826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5346b7c250b%3A0x189a490ffddab322!2sUBSI%20Kramat%2098!5e0!3m2!1sid!2sid!4v1582606989163!5m2!1sid!2sid" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>  --}}
            </div>

          </div>

          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="name">Your Name</label>
                  <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="name">Your Email</label>
                  <input type="email" class="form-control" name="email" id="email" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Subject</label>
                <input type="text" class="form-control" name="subject" id="subject" required>
              </div>
              <div class="form-group">
                <label for="name">Message</label>
                <textarea class="form-control" name="message" rows="10" required></textarea>
              </div>
              <div class="my-3">
                {{--  <div class="loading">Loading</div>  --}}
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center">
          {{--  <div class="col-lg-6">
            <h4>Join Our Newsletter</h4>
            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>
          </div>  --}}
        </div>
      </div>
    </div>

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3><img src="{{ Storage::url('public/mybest_3.png') }}" alt="" loading="lazy"  class="img-fluid" width="150" height="100"></h3>
            <p>
              Jl. Kramat Raya No.98, RW.9, Kwitang, Kec. Senen, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10450<br><br>
              <strong>Phone:</strong> (021) 8000063<br>
              <strong>Hotline 1:</strong> 081381507561<br>
              <strong>Hotline 2:</strong> 081381507125<br>
              <strong>Email:</strong> info@bsi.ac.id<br>
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Link Terkait</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="http://www.bsi.ac.id">BSI</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="http://pmb.bsi.ac.id">PMB</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="http://ejournal.bsi.ac.id">eJournal</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="http://repository.bsi.ac.id">Repository</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="http://news.bsi.ac.id">News</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Link Terkait</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="https://kemahasiswaan.bsi.ac.id">Kemahasiswaan</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="http://lppm.bsi.ac.id">LPPM</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="http://alumni.bsi.ac.id/">Alumni</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="http://career.bsi.ac.id">Career</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="http://bec.bsi.ac.id">BEC</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Tentang Kami</h4>
            <p>Sistem Informasi Pembelajaran Online Elearning My Best</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; 2021 Copyright <strong><span>Universitas Bina Sarana Informatika</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="http://elearning.bsi.ac.id/">Biro Teknologi Informasi</a>
      </div>
    </div>
  </footer>
  <!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Pendaftaran MBKM</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Email</label>
            <input type="text" class="form-control" placeholder="example@gmail.com">
          </div>
          {{--  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nama Pengguna</label>
            <input type="text" class="form-control" placeholder="Nama Pengguna">
          </div>  --}}
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">NIM</label>
            <input type="text" class="form-control" placeholder="NIM">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nama Depan</label>
            <input type="text" class="form-control" placeholder="Nama Depan">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nama Belakang</label>
            <input type="text" class="form-control" placeholder="Nama Belakang">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nama Perguruan Tinggi</label>
            <input type="text" class="form-control" placeholder="Nama Perguruan Tinggi">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Kode Perguruan Tinggi</label>
            <input type="text" class="form-control" placeholder="Kode Perguruan Tinggi">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Kota</label>
            <input type="text" class="form-control" placeholder="Kota">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nomer Telpon</label>
            <input type="text" class="form-control" placeholder="Nomer Telpon">
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Jenis Kelamin</label>
            <select class="form-control">
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Buat Akun</button>
      </div>
    </div>
  </div>
</div>
  <!-- Vendor JS Files -->
  <script src="{{ asset('home/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('home/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('home/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset('home/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('home/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{ asset('home/assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
  <script src="{{ asset('home/assets/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <!-- Template Main JS File -->
  <script src="{{ asset('home/assets/js/main.js')}}"></script>

</body>

</html>