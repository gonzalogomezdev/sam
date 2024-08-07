<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>

    <title>S.A.M</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/svg" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/home/bootstrap.min.css') }}" />

    <!-- Line Icons CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/home/lineicons.css') }}" /> 

    <!-- Starter CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/home/starter.css') }}" />
    
    <!-- gLightBox CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/home/glightbox.min.css') }}" /> 

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/home/home.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/home/contact/contact-02.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/home/videos/video-01.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/home/blogs/blog-01.css') }}" />

    <style>
      nav {
        margin-top: -10px;
      }

      #text-index:hover, #text-sub-index:hover {
        color: inherit; /* Mantiene el color actual */
      }

      /* Estilo predeterminado para el logo */
      #logo-doctor {
        /* border: 1px solid red; */
        width: 200px; /* Ajusta el tamaño predeterminado */
        height: auto; /* Mantiene la proporción */
      }

      /* Media query para pantallas pequeñas */
      @media (max-width: 768px) {
        #logo-doctor {
          width: 100px; /* Ajusta el tamaño para pantallas pequeñas */
          height: auto; /* Mantiene la proporción */
        }
      }

      /* Media query para pantallas muy pequeñas */
      @media (max-width: 576px) {
        #logo-doctor {
          width: 100px; /* Ajusta el tamaño para pantallas muy pequeñas */
          height: auto; /* Mantiene la proporción */
        }
      }
    </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-white">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="{{ asset('assets/images/logo_doctor.png') }}" id="logo-doctor">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="bi bi-list"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item order-1">
            <a class="nav-link" id="navitem1" href="#servicios">Servicios</a>
          </li>
          <li class="nav-item order-2" >
            <a class="nav-link" id="navitem2" href="#conoceme">Conóceme</a>
          </li>
          <li class="nav-item order-3">
            <a class="nav-link" id="navitem3" href="#tecmedica">Tecnologia Médica</a>
          </li>
          <li class="nav-item order-5">
            <a class="nav-link" id="navitem3" href="#ubic">Ubicación</a>
          </li>
          <li class="nav-item order-5">
            <a class="nav-link" id="navitem3" href="#acerca-del-sistema">Acerca del S.A.M. </a>
          </li>
        </ul>
        <!-- Separador entre elementos y elementos de registro e inicio de sesión -->
        <ul class="navbar-nav">
          <li class="nav-item  order-4">
          <button type="button"  onclick="window.location='{{ route('login.form') }}'" class="btn btn-dark">Iniciar Sesión</button>
          <li class="nav-item ms-lg-2 py-2 py-lg-0" id="registrate">
          <a href="{{ route('register.form') }}" class="nav-link">Registrate</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <a href="https://wa.me/" class="whatsapp-btn" target="_blank">
    <img src="{{ asset('assets/css/home/images/iconowpp.png') }}" alt="Icono de WhatsApp">
  </a>
  
  <!-- Page Content-->
  <div class="container px-10 px-lg-5 margin-top-right-200"">
    <!-- Heading Row-->
    <div class="row gx-4 gx-lg-5 text-center align-items-center mg-20 my-5 justify-content-center">
      <div class="col-lg-7">
        <h2 class="font-weight-light" id="text-index">Bienvenido al Sistema <br> de Atención Médica</h2>
        <p id="text-sub-index"><br>Del Dr. Fabio Cantero</p>
        <a class="btn btn-primary mt-4" href="#tecmedica">Conocer más </a>
      </div>
    </div>
  </div>

  <div class="container mt-5">   
    <section class="blog-area pb-5">
      <div class="container" id="servicios">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-8 col-sm-10 d-flex">
            <div class="single-blog blog-style-one d-flex flex-column">
              <div class="blog-image">
                <a href="javascript:void(0)">
                  <img src="{{ asset('assets/css/home/images/1.png') }}" alt="Blog" />
                </a>
                <a class="category">Atención Exhaustiva</a>
              </div>
              <div class="blog-content flex-grow-1">
                <h5 class="blog-title">
                  <a href="javascript:void(0)">
                    Diagnostico y tratamiento de enfermedades
                  </a>
                </h5>
                <p class="text">
                  La atención exhaustiva es fundamental en el diagnóstico y tratamiento de enfermedades. Mi compromiso como médico es brindar una evaluación minuciosa y un diagnóstico preciso, seguido de un plan de tratamiento efectivo para cada paciente.
                </p>
                <!-- <a class="more" href="https://api.whatsapp.com/">Contáctame</a> -->
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-8 col-sm-10 d-flex">
            <div class="single-blog blog-style-one d-flex flex-column">
              <div class="blog-image">
                <a href="javascript:void(0)">
                  <img src="{{ asset('assets/css/home/images/4.png') }}" alt="Blog" />
                </a>
                <a class="category">Atención Eficaz</a>
              </div>
              <div class="blog-content flex-grow-1">
                <h5 class="blog-title">
                  <a>
                    Derivación a Especialistas
                  </a>
                </h5>
                <p class="text">
                  La gestión médica es clave para brindar una atención de calidad. La derivación a especialistas es parte esencial de mi labor, ya que permite que los pacientes reciban la atención más adecuada a sus necesidades de salud. Coordinar estas referencias garantiza una atención integral y personalizada, mejorando la experiencia y los resultados de los pacientes.
                </p>
                <!-- <a class="more" href="https://api.whatsapp.com/">Agenda un turno</a> -->
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-8 col-sm-10 d-flex">
            <div class="single-blog blog-style-one d-flex flex-column">
              <div class="blog-image">
                <a href="javascript:void(0)">
                  <img src="{{ asset('assets/css/home/images/2.png') }}" alt="Blog" />
                </a>
                <a class="category">Responsabilidad Vocacional</a>
              </div>
              <div class="blog-content flex-grow-1">
                <h5 class="blog-title">
                  <a href="javascript:void(0)">
                    Atención de Emergencia
                  </a>
                </h5>
                <p class="text">
                  La atención de emergencia es un deber vocacional que asumo con responsabilidad como médico. En situaciones críticas, mi compromiso es brindar cuidado inmediato y efectivo, priorizando la vida y la salud de los pacientes. Mi vocación me impulsa a estar preparado y actuar con diligencia en momentos de urgencias y asegurar que cada paciente reciba la atención que merece.
                </p>
                <!-- <a class="more" href="https://api.whatsapp.com/">Contáctame</a> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <section class="video-area video-one">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10">
          <div class="video-title text-center" id="tecmedica">
            <h5>CONOCE & APRENDE</h5>
            <h2>La tecnologia de la salud</h2>
            <p class="text-lg">
              Mi experiencia como médico que ha transformado el sistema de gestión médica y los desafíos que enfrento como profesional de la salud que está dando forma al futuro de la atención médica.
            </p>
          </div>
        </div>
      </div>
      <!-- row -->
      <div class="row justify-content-center">
          <div class="col-lg-10">
              <div class="video-content text-center">
                  <img src="{{ asset('assets/css/home/images/5.png') }}" alt="Video" />
                  <a class="video-popup glightbox" href="https://youtu.be/19uUK4r11Z4">
                    <i><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                      <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/></svg></i>
                  </a>
              </div>
          </div>
      </div>
      <!-- container -->
      <div class="container mt-5" id="ubic">
        <br>
        <br>
        <div class="row">
          <div class="col-lg-4 col-12">
            <h2>Ubicación del Consultorio</h2>
            <br>
            <br>
            <p class="text">
              El consultorio del Dr. Fabio Cantero se encuentra en el corazón de la ciudad, en la calle principal, a solo unos pasos de la estación de metro y con fácil acceso en transporte público. La dirección exacta es 123 Calle Principal, Ciudad Ejemplo. Nuestra ubicación céntrica garantiza que los pacientes puedan acceder fácilmente a sus servicios médicos con comodidad y rapidez.
            </p>
            <br>  
            <ul class="contact-info">
              <li>
                <p class="text "><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                  <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                  <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg></i> Posadas, Misiones, Argentina</p>
              </li>
              <li>
                <p class="text "><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                  <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                </svg></i> +3765 013593</p>
              </li>
              <li>
                <p class="text "><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                </svg></i> drfabiocantero@gmail.com</p></li>
            </ul>
          </div>
          <!-- Columna de la imagen (4 columnas para dispositivos grandes, 12 para dispositivos pequeños) -->
          <div class="col-lg-8 col-12" id="img-ubic">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3543.2123041266186!2d-55.950326425486!3d-27.369084312424913!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9457bdf76b0dcce9%3A0x811bcb38f48430cb!2sAv.%20L%C3%B3pez%20y%20Planes%207415%2C%20N3301FPV%20Posadas%2C%20Misiones!5e0!3m2!1ses!2sar!4v1722815859301!5m2!1ses!2sar" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>
    </div>
  </section>
  
  <div class="container mt-5 " id="conoceme">
    <section>
      <h2>Conóceme</h2>
      <br>
      <br>
    </section>
    <div class="row">
      <!-- Columna de la imagen (4 columnas para dispositivos grandes, 12 para dispositivos pequeños) -->
      <div class="col-lg-4 col-12" id="img-ubic">
          <img src="{{ asset('assets/css/home/images/6.jpg') }}" class="img-fluid" alt="Imagen">
      </div>
            
      <!-- Columna del contenido (8 columnas para dispositivos grandes, 12 para dispositivos pequeños) -->
      <div class="col-lg-7 col-12" id="text-left">
          <h2>Historia de vida</h2>
          <br>
          <br>
          <p class="text-lg">El Dr. Fabio Cantero creció en una familia de médicos y siempre soñó con seguir sus pasos. Tras graduarse con honores de la escuela de medicina, se especializó en cirugía cardiovascular. Durante su carrera, salvó innumerables vidas y lideró misiones médicas en zonas desfavorecidas. Su dedicación y empatía lo convirtieron en un referente en su campo. Hoy, el Dr. Ramírez sigue trabajando incansablemente, inspirando a las generaciones futuras y dejando un legado de cuidado y compromiso con la salud.</p>
      </div>
    </div>
    <br>
    <br>
  </div>
  
  <section class="contact-area contact-area-two">
    <div class="container" id="acerca-del-sistema">
      <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7">
          <div class="section-title-2 text-center">
            <h2 class="title">Acerca del S.A.M.</h2>
          </div>
        </div>
    </div>
    <div class="row">
      <div class="col-xl-5 col-lg-6">
        <div class="contact-two">
          <h4 class="contact-title">Desarrolladores del Sistema De Atención Médica</h4>
          <p class="text">
            Comos alumnos de tercer año de Analista de Sistemas y Programación, participamos en el desarrollo del sistema de atención médica para el Dr. Fabio Cantero. Fue una experiencia enriquecedora que nos permitió aplicar nuestros conocimientos en análisis y programación para crear una solución efectiva y personalizada para su atención médica. Estamos orgullosos de haber contribuido a mejorar la eficiencia de su consultorio y el bienestar de sus pacienes.
          </p>
              
          <ul class="contact-info">
            <li>
                <i>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"class="bi bi-geo-alt" viewBox="0 0 16 16">
                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
                </i> Posadas, Misiones, Argentina
            </li>

            <li>
              <i>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                  <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                </svg>
              </i>+3765 013593
            </li>
              
            <li><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
              <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/></svg></i> projectfinalnormal10@gmail.com
            </li>
          </ul>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 offset-xl-1">
        <div class="contact-form form-style-one">
          <div class="col-lg-10 col-12">
          <img src="{{ asset('assets/css/home/images/7.jpg') }}" id="img-ubic" class="img-fluid" alt="Imagen">
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container px-4 px-lg-5">
        <p class="m-0 text-center text-white">Copyright &copy; Sistema de Atención Médica | Desarrollado por Final Project Team | Analistas de Sistemas - Normal 10</p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS -->
  <script src="{{ asset('assets\css\home\js\glightbox.min.js') }}"></script>

  <script>
  //========= glightbox
    const myGallery = GLightbox({
      href: "assets/css/home/video/video2.mp4",
      type: "video",
      source: "local", // vimeo, youtube or local
      width: 900,
      autoplayVideos: true,
    });
  </script>
</body>
</html>