<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>E-BLUD Kesehatan Kota Malang.</title>

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="{{ asset('landing/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('landing/vendor/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="{{ asset('landing/css/landing-page.min.css') }}" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
      <a class="navbar-brand" href="javascript:void(0)">
        <img src="{{ asset('img/logo.png') }}" class="img-responsive" style="width: 45px; height: 45px;"> E-BLUD Kesehatan
      </a>
      <a class="btn btn-outline-primary icon-color" href="{{ route('login') }}">
        Masuk Aplikasi <i class="fas fa-arrow-right"></i>  
      </a>
    </div>
  </nav>

  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h2 class="mb-5">Selamat Datang di Portal Resmi E-BLUD Kesehatan.</h2>
        </div>
      </div>
    </div>
  </header>

  <!-- Icons Grid -->
  <section class="features-icons bg-light text-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="icon-screen-desktop m-auto icon-color"></i>
            </div>
            <h3>Aplikasi fleksibel</h3>
            <p class="lead mb-0">Tidak usah khawatir, aplikasi E-BLUD Kehatan bisa dibuka melalui PC maupun Smartphone anda.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="icon-layers m-auto icon-color"></i>
            </div>
            <h3>Fitur yang lengkap</h3>
            <p class="lead mb-0">Fitur yang kami sediakan sangat lengkap dan sesuai kebutuhan pengguna.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="icon-check m-auto icon-color"></i>
            </div>
            <h3>Mudah digunakan</h3>
            <p class="lead mb-0">Aplikasi yang kami buat sudah kami rancang untuk mudah digunakan oleh pengguna.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Image Showcases -->
  <section class="showcase">
    <div class="container-fluid p-0">
      <div class="row no-gutters">

        <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url({{ asset('img/responsive_design.png') }});"></div>
        <div class="col-lg-6 order-lg-1 my-auto showcase-text">
          <h2>Aplikasi fleksibel</h2>
          <p class="lead mb-0">Aplikasi E-BLUD Kesehatan ini bisa diakses melalui laptop/pc, smartphone atau tablet anda.</p>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-lg-6 text-white showcase-img" style="background-image: url({{ asset('img/completed_feature.png') }});"></div>
        <div class="col-lg-6 my-auto showcase-text">
          <h2>Fitur yang lengkap</h2>
          <p class="lead mb-0">Semua fitur yang ada di aplikasi E-BLUD Kesehatan ini sudah kami rancang sesuai kebutuhan pengguna.</p>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url({{ asset('img/easy_to_use.png') }});"></div>
        <div class="col-lg-6 order-lg-1 my-auto showcase-text">
          <h2>Mudah digunakan</h2>
          <p class="lead mb-0">Mudah digunakan karena tampilan aplikasi E-BLUD Kesehatan merupakan tampilan modern alias kekinian.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="testimonials text-center bg-light">
    <div class="container">
      <h2 class="mb-5">Apa kata puskesmas...</h2>
      <div class="row">
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="{{ asset('landing/img/testimonials-1.jpg') }}" alt="">
            <h5>Mutiara Berliantina.</h5>
            <p class="font-weight-light mb-0">"Aplikasi E-BLUD MUDAH DIGUNAKAN dan MUDAH DIPAHAMI. KERENNNNNN!"</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="{{ asset('landing/img/testimonials-2.jpg') }}" alt="">
            <h5>Bambang.</h5>
            <p class="font-weight-light mb-0">"Aplikasi E-BLUD sangat membantu untuk pencatatan data puskemas kami."</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="{{ asset('landing/img/testimonials-3.jpg') }}" alt="">
            <h5>Priscilla.</h5>
            <p class="font-weight-light mb-0">"Terima kasih banyak sudah membuatkan aplikasi E-BLUD yang keren!"</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <p class="text-muted small mb-4 mb-lg-0">{{ config('app.name') }} &copy; @php echo date('Y') @endphp. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="{{ asset('landing/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('landing/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
