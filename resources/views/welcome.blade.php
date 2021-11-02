{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <div class="card">
                <h1 class="text-center">Welcome to MN Express Livraison ...</h1>
            </div>
        </div>
    </body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Mn Express Livraison</title>
	<meta charset="UTF-8">
	<meta name="description" content="Unica University Template">
	<meta name="keywords" content="event, unica, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->   
	<link href="{{ asset('images/logo_MN.png') }}" rel="shortcut icon"/>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/themify-icons.css"/>
	<link rel="stylesheet" href="css/magnific-popup.css"/>
	<link rel="stylesheet" href="css/animate.css"/>
	<link rel="stylesheet" href="css/owl.carousel.css"/>
	<link rel="stylesheet" href="css/style.css"/>


	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- header section -->
	<header class="header-section">
		<div class="container">
			<!-- logo -->
			<a href="index.html" class="site-logo"><img src="img/logo.png" alt=""></a>
			<div class="nav-switch">
				<i class="fa fa-bars"></i>
			</div>
			<div class="header-info">
				<div class="hf-item">
					<i class="fa fa-clock-o"></i>
					<p><span>Horaire de travail</span>Lundi - Vendredi: 09 AM - 08 PM <br> Samedi: 09 AM - 03 PM</p>
				</div>
				<div class="hf-item">
					<i class="fa fa-map-marker"></i>
					<p><span>Adresse:</span>28 Rue 7 Bournazel (Derrière Café Mohajir) <br> Casablanca</p>
				</div>
			</div>
		</div>
	</header>
	<!-- header section end-->


	<!-- Header section  -->
	<nav class="nav-section">
		<div class="container">
			<div class="nav-right">
				<a href="{{ route('register') }}">Devenir client</a>
				 <a href="{{ route('login') }}">Espace Clinet</a><!--<i class="fa fa-shopping-cart"></i> -->
			</div>
			<ul class="main-menu">
				<li class="active"><a href="">ACCUEIL</a></li>
				<li><a href="#quiSommes">QUI SOMMES NOUS ?</a></li>
				<!-- <li><a href="#">Event</a></li> -->
				<li><a href="#services">Nos services</a></li>
				<!-- <li><a href="blog.html">blog</a></li> -->
				<li><a href="#contact">Contact</a></li>
			</ul>
		</div>
	</nav>
	<!-- Header section end -->


	<!-- Hero section -->
	<section class="hero-section">
		<div class="hero-slider owl-carousel">
			<div class="hs-item set-bg" data-setbg="img/hero-slider/photo-header.jpg">
				<div class="hs-text">
					<div class="container">
						<div class="row">
							<div class="col-lg-8">
								<div class="hs-subtitle"></div>
								<h2 class="hs-title" style="color: rgb(206, 0, 0);">MN EXPRESS LIVRAISON</h2>
								
								<p class="hs-des" style="color: rgb(0, 0, 0);">EQUIPE PROFESSIONEL, COMPÉTANT, DYNAMIQUE ET BIEN MOTIVÉ</p>
								<div class="site-btn">Commencer</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="hs-item set-bg" data-setbg="img/hero-slider/3.jpg">
				<div class="hs-text">
					<div class="container">
						<div class="row">
							<div class="col-lg-8">
								<!-- <div class="hs-subtitle">Award Winning UNIVERSITY</div> -->
								<h2 class="hs-title" style="color: rgb(206, 0, 0);">MN EXPRESS LIVRAISON</h2>
								<p class="hs-des" style="color: rgb(0, 0, 0);">ASSURE LA LIVRAISON DE VOS COLIS ET MARCHANDISES PARTOUT DANS LE MAROC</p>
								<div class="site-btn">Commencer</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="hs-item set-bg" data-setbg="img/hero-slider/photo-header3.jpg">
				<div class="hs-text">
					<div class="container">
						<div class="row">
							<div class="col-lg-8">
								<!-- <div class="hs-subtitle">Award Winning UNIVERSITY</div> -->
								<h2 class="hs-title" style="color: rgb(206, 0, 0);">MN EXPRESS LIVRAISON</h2>
								<p class="hs-des" style="color: rgb(0, 0, 0);">TRANSPORT DE HAUTE QUALITÉ POUR ASSURER LA LIVRAISON DE VOS COLIS ET MARCHANDISES</p> 
								<div class="site-btn">Commencer</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Hero section end -->

		<!-- Counter section  -->
		<section class="counter-section">
			<div class="container">
				<div class="row">
					<div class="col-lg-11 col-md-6">
						<div class="big-icon">
							<!-- <i class="fa fa-truck"></i> -->
							<img src="img/logo.png" alt="">
						</div>
						<div class="counter-content">
							<h2>MN EXPRESS LIVRAISON N° 1 AU MAROC</h2>
							
						</div>
					</div>
					<!-- <div class="col-lg-5 col-md-6">
						<div class="counter">
							<div class="counter-item"><h4>00</h4>Days</div>
							<div class="counter-item"><h4>08</h4>Hrs</div>
							<div class="counter-item"><h4>40</h4>Mins</div>
							<div class="counter-item"><h4>56</h4>secs</div>
						</div>
					</div> -->
				</div>
			</div>
		</section>
		<!-- Counter section end -->

	<!-- About section -->
	<section class="about-section spad pt-0">
	<!-- <section class="newsletter-section"> -->
		<div class="container">
			<div class="section-title text-center">
				<br>
				<h2 style="color: rgb(192, 0, 0);">MN EXPRESS LIVRAISON</h2>
				<br>
				<h4 >سرعة و أمان ، فين مكان</h4>
			</div>
			<div class="row" id="quiSommes">
				<div class="col-lg-6 about-text">
					<h4 style="color: rgb(192, 0, 0);">QUI SOMMES NOUS ?</h4>
					<br>
					<p>MN EXPRESS est votre société de livraison la plus pratique qui vous propose plusieurs services et plusieurs solutions de transport express que ce soit <br>  pour le B to B et/ou le B to C dans toutes les régions du Royaume 24/7.</p>
					<h3 class="pt-4"></h3>
					<p>Particulier ou Professionnel nous nous engageons de livrer vos colis dans les délais convenus en toute sécurité et confidentialité. <br> La traçabilité des envois est consultable en ligne sur le portail web de MN Express.</p>
					<ul class="about-list">
						<li><i class="fa fa-check-square-o"></i> RAMASSAGE</li>
						<li><i class="fa fa-check-square-o"></i> LIVRAISON RAPIDE & EFFICACE</li>
						<li><i class="fa fa-check-square-o"></i> COURSES RAPIDES</li>
						<li><i class="fa fa-check-square-o"></i> SUIVI ET TRAÇABILITÉ</li>	
						<li><i class="fa fa-check-square-o"></i> DOCUMENTS ADMINISTRATIFS</li>
					</ul>
				</div>
				<div class="col-lg-6 pt-5 pt-lg-0">
					<img src="img/about.png" alt="">
				</div>
			</div>
		</div>
	</section>
	<!-- About section end-->

	<section class="counter-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-11 col-md-6">
					<!-- <div class="big-icon">
						<i class="fa fa-truck"></i>
					</div> -->
					<div class="counter-content text-center" id="services">
						<h1 style="color: lightyellow;">Nos services</h1>
						
					</div>
				</div>
				
			</div>
		</div>
	</section>
<br><br>

	<!-- Courses section -->

	<section class="full-courses-section spad pt-0">
		<div class="container">
			<div class="row">
				<!-- course item -->
				<div class="col-lg-4 col-md-6 course-item">
					<div class="course-thumb">
						<img src="img/course/1.jpg" alt="">
						<div class="course-cat">
							<span>RAMASSAGE</span>
						</div>
					</div>
					<div class="course-info">
						<!-- <div class="date"><i class="fa fa-clock-o"></i> 22 Mar 2018</div> -->
						<h5>Le ramassage est un service qui vous permet de gagner du temps et d’assurer la disposition de vos colis chez nous avec le moindre effort.</h5>
						<!-- <h4 class="cource-price">$100<span>/month</span></h4> -->
					</div>
				</div>
				<!-- course item -->
				<div class="col-lg-4 col-md-6 course-item">
					<div class="course-thumb">
						<img src="img/course/2.jpg" alt="">
						<div class="course-cat">
							<span>LIVRAISON RAPIDE & EFFICACE</span>
						</div>
					</div>
					<div class="course-info">
						<!-- <div class="date"><i class="fa fa-clock-o"></i> 22 Mar 2018</div> -->
					<h5>Nous livrons à vos clients deux fois plus vite que ce que le marché peut offrir. Parce que la satisfaction de vos clients est notre priorité absolue, nous avons conçu une solution de livraison unique qui correspond parfaitement à leurs besoins et va même au-delà de leurs attentes. </h5>
						<!-- <h4 class="cource-price">$150<span>/month</span></h4> -->
					</div>
				</div>
				<!-- course item -->
				<div class="col-lg-4 col-md-6 course-item">
					<div class="course-thumb">
						<img src="img/course/3.jpg" alt="">
						<div class="course-cat">
							<span>COURSES RAPIDES</span>
						</div>
					</div>
					<div class="course-info">
						<!-- <div class="date"><i class="fa fa-clock-o"></i> 22 Mar 2018</div> -->
						<h5>Ce service permet de livrer vos commandes dans un délais de 4h dans la même ville.</h5>
						<!-- <h4 class="cource-price">$180<span>/month</span></h4> -->
					</div>
				</div>
				<!-- course item -->
				<div class="col-lg-4 col-md-6 course-item">
					<div class="course-thumb">
						<img src="img/course/4.jpg" alt="">
						<div class="course-cat">
							<span>SUIVI ET TRAÇABILITÉ</span>
						</div>
					</div>
					<div class="course-info">
						<!-- <div class="date"><i class="fa fa-clock-o"></i> 22 Mar 2018</div> -->
						<h5>Notre plateforme vous permet de suivre vos colis et leurs statuts en temps réel.</h5>
						<!-- <h4 class="cource-price">$150<span>/month</span></h4> -->
					</div>
				</div>
				<!-- course item -->
				<div class="col-lg-4 col-md-6 course-item">
					<div class="course-thumb">
						<img src="img/course/5.jpg" alt="">
						<div class="course-cat">
							<span>DOCUMENTS ADMINISTRATIFS</span>
						</div>
					</div>
					<div class="course-info">
						<!-- <div class="date"><i class="fa fa-clock-o"></i> 22 Mar 2018</div> -->
						<h5>Être missionné pour transporter des documents administratifs dans un délai impératif.</h5>
						<!-- <h4 class="cource-price">$250<span>/month</span></h4> -->
					</div>
				</div>
				<!-- course item -->
				<div class="col-lg-4 col-md-6 course-item">
					<div class="course-thumb">
						<img src="img/course/6.jpg" alt="">
						<div class="course-cat">
							<span>Fonds et paiements</span>
						</div>
					</div>
					<div class="course-info">
						<!-- <div class="date"><i class="fa fa-clock-o"></i> 22 Mar 2018</div> -->
						<h5>La société MN EXPRESS assure le retour de fonds, des Virements, des traites et des bons de livraison d’une manière régulière sur les services de messagerie de nos clients.</h5>
						<!-- <h4 class="cource-price">$150<span>/month</span></h4> -->
					</div>
				</div>
			</div>
			<!-- <div class="text-center">
				<ul class="site-pageination">
					<li><a href="#" class="active">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#"><i class="fa fa-angle-right"></i></a></li>
				</ul>
			</div> -->
		</div>
	</section>
	<!-- Courses section end-->

	<!-- Services section -->
	
	<!-- Services section end -->

	
	<!-- Enroll section -->
	<section class="enroll-section spad set-bg" data-setbg="img/enroll-bg.jpg">
		<div class="container">
			<div class="row">
				<div class="col-lg-5">
					<div class="section-title text-white">
						<h3>Comment ça marche</h3>
						<!-- <p>Get started with us to explore the exciting</p> -->
					</div>
					<div class="enroll-list text-white">
						<div class="enroll-list-item">
							<span>1</span>
							<h5>Inscrivez vous </h5>
							<!-- <p>Lorem ipsum dolor sitdo amet, consectetur dont adipis elit. Vivamus interdum ultrices augue.</p> -->
						</div>
						<div class="enroll-list-item">
							<span>2</span>
							<h5>Vos clients passent leur commande </h5>
							<!-- <p>Lorem ipsum dolor sitdo amet, consectetur dont adipis elit. Vivamus interdum ultrices augue.</p> -->
						</div>
						<div class="enroll-list-item">
							<span>3</span>
							<h5>Ajoutez et préparez vos colis </h5>
							<!-- <p>Lorem ipsum dolor sitdo amet, consectetur dont adipis elit. Vivamus interdum ultrices augue.</p> -->
						</div>
						<div class="enroll-list-item">
							<span>4</span>
							<h5>Nous passerons pour ramasser vos colis </h5>
							<!-- <p>Lorem ipsum dolor sitdo amet, consectetur dont adipis elit. Vivamus interdum ultrices augue.</p> -->
						</div>
						<div class="enroll-list-item">
							<span>5</span>
							<h5>Exécutions et expéditions de vos colis </h5>
							<!-- <p>Lorem ipsum dolor sitdo amet, consectetur dont adipis elit. Vivamus interdum ultrices augue.</p> -->
						</div>
						<div class="enroll-list-item">
							<span>6</span>
							<h5>Suivi des colis jusqu'à la livraison  </h5>
							<!-- <p>Lorem ipsum dolor sitdo amet, consectetur dont adipis elit. Vivamus interdum ultrices augue.</p> -->
						</div><div class="enroll-list-item">
							<span>7</span>
							<h5>Nous réglons vos factures </h5>
							<!-- <p>Lorem ipsum dolor sitdo amet, consectetur dont adipis elit. Vivamus interdum ultrices augue.</p> -->
						</div>
					</div>
				</div>
				<div class="col-lg-6 offset-lg-1 p-lg-0 p-4">
					<img src="img/encroll-img.png" alt="">
				</div>
			</div>
		</div>
	</section>
	<!-- Enroll section end -->


	<!-- Courses section -->
	
	<!-- Courses section end-->


	

    {{-- background-image:url('/images/back.jpg'); --}}
	<!-- Event section -->
	<section class="event-section spad" style=" background:rgb(247,247,247); ">
		<div class="container">
			<div class="section-title text-center">
				<h3 style = "color: rgb(192, 0, 0);">Zones De Livraison Et Tarifs</h3>
				<!-- <p>Our department  initiated a series of events</p> -->
			</div>
		</div>
            <div class="m-4" style="border: 2px dashed #020031;">
                <div>
                    <h4 class="font-wheight-bold m-4"> <span style = "color: rgb(192, 0, 0);"> NB: </span> Si vous voulez livrer un colis dans votre ville les frais seront juste 17 dh </h4>
                </div>
                <div class="m-4">
                <table id="regions" class="display">
                  <thead>
                      <tr>
                          <th style = "color: rgb(192, 0, 0);">Région</th>
                          <th style = "color: rgb(192, 0, 0);">Ville</th>
                          <th style = "color: rgb(192, 0, 0);">Frais de Livraison (MAD)</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($villes as $v)
                      <tr>
                        <td>{{$v->region}}</td>
                        <td class ="ville_table">{{$v->ville}}</td>
                        <td class ="frais">{{$v->frais_livraison}}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              </div>
			<!-- <div class="row">
				<div class="col-md-6 event-item">
					<div class="event-thumb">
						<img src="img/event/1.jpg" alt="">
						<div class="event-date">
							<span>24 Mar 2018</span>
						</div>
					</div>
					<div class="event-info">
						<h4>The dos and don'ts of writing a personal<br>statement for languages</h4>
						<p><i class="fa fa-calendar-o"></i> 08:00 AM - 10:00 AM <i class="fa fa-map-marker"></i> Center Building, Block A</p>
						<a href="" class="event-readmore">REGISTER <i class="fa fa-angle-double-right"></i></a>
					</div>
				</div>
				<div class="col-md-6 event-item">
					<div class="event-thumb">
						<img src="img/event/2.jpg" alt="">
						<div class="event-date">
							<span>22 Mar 2018</span>
						</div>
					</div>
					<div class="event-info">
						<h4>University interview tips:<br>confidence won't make up for flannel</h4>
						<p><i class="fa fa-calendar-o"></i> 08:00 AM - 10:00 AM <i class="fa fa-map-marker"></i> Center Building, Block A</p>
						<a href="" class="event-readmore">REGISTER <i class="fa fa-angle-double-right"></i></a>
					</div>
				</div>
			</div> -->
	</section>
	<!-- Event section end -->


	<!-- Fact section -->
	<section class="fact-section spad set-bg" data-setbg="img/fact-bg.jpg">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-3 fact">
					<div class="fact-icon">
						<i class="ti-time"></i>
					</div>
					<div class="fact-text">
						<h2>05</h2>
						<p>ANS</p>
					</div>
				</div>
				<div class="col-sm-6 col-lg-3 fact">
					<div class="fact-icon">
						<i class="ti-package"></i>
					</div>
					<div class="fact-text">
						<h2>100000</h2>
						<p>Colis</p>
					</div>
				</div>
				<div class="col-sm-6 col-lg-3 fact">
					<div class="fact-icon">
						<i class="ti-user"></i>
					</div>
					<div class="fact-text">
						<h2>1000+</h2>
						<p>Clients</p>
					</div>
				</div>
				<div class="col-sm-6 col-lg-3 fact">
					<div class="fact-icon">
						<i class="ti-briefcase"></i>
					</div>
					<div class="fact-text">
						<h2>50+</h2>
						<p>Société</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Fact section end-->

	<!-- Gallery section -->
	<!-- <div class="gallery-section">
		<div class="gallery">
			<div class="grid-sizer"></div>
			<div class="gallery-item gi-big set-bg" data-setbg="img/gallery/1.jpg">
				<a class="img-popup" href="img/gallery/1.jpg"><i class="ti-plus"></i></a>
			</div>
			<div class="gallery-item set-bg" data-setbg="img/gallery/2.jpg">
				<a class="img-popup" href="img/gallery/2.jpg"><i class="ti-plus"></i></a>
			</div>
			<div class="gallery-item set-bg" data-setbg="img/gallery/3.jpg">
				<a class="img-popup" href="img/gallery/3.jpg"><i class="ti-plus"></i></a>
			</div>
			<div class="gallery-item gi-long set-bg" data-setbg="img/gallery/5.jpg">
				<a class="img-popup" href="img/gallery/5.jpg"><i class="ti-plus"></i></a>
			</div>
			<div class="gallery-item gi-big set-bg" data-setbg="img/gallery/8.jpg">
				<a class="img-popup" href="img/gallery/8.jpg"><i class="ti-plus"></i></a>
			</div>
			<div class="gallery-item gi-long set-bg" data-setbg="img/gallery/4.jpg">
				<a class="img-popup" href="img/gallery/4.jpg"><i class="ti-plus"></i></a>
			</div>
			<div class="gallery-item set-bg" data-setbg="img/gallery/6.jpg">
				<a class="img-popup" href="img/gallery/6.jpg"><i class="ti-plus"></i></a>
			</div>
			<div class="gallery-item set-bg" data-setbg="img/gallery/7.jpg">
				<a class="img-popup" href="img/gallery/7.jpg"><i class="ti-plus"></i></a>
			</div>
		</div>
	</div> -->
	<!-- Gallery section -->


	<!-- Blog section -->
	<!-- <section class="blog-section spad">
		<div class="container">
			<div class="section-title text-center">
				<h3>LATEST NEWS</h3>
				<p>Get latest breaking news & top stories today</p>
			</div>
			<div class="row">
				<div class="col-xl-6">
					<div class="blog-item">
						<div class="blog-thumb set-bg" data-setbg="img/blog/1.jpg"></div>
						<div class="blog-content">
							<h4>Parents who try to be their children’s best friends</h4>
							<div class="blog-meta">
								<span><i class="fa fa-calendar-o"></i> 24 Mar 2018</span>
								<span><i class="fa fa-user"></i> Owen Wilson</span>
							</div>
							<p>Integer luctus diam ac scerisque consectetur. Vimus dot euismod neganeco lacus sit amet. Aenean interdus mid vitae sed accumsan...</p>
						</div>
					</div>
				</div>
				<div class="col-xl-6">
					<div class="blog-item">
						<div class="blog-thumb set-bg" data-setbg="img/blog/2.jpg"></div>
						<div class="blog-content">
							<h4>Graduations could be delayed as external examiners</h4>
							<div class="blog-meta">
								<span><i class="fa fa-calendar-o"></i> 23 Mar 2018</span>
								<span><i class="fa fa-user"></i> Owen Wilson</span>
							</div>
							<p>Integer luctus diam ac scerisque consectetur. Vimus dot euismod neganeco lacus sit amet. Aenean interdus mid vitae sed accumsan...</p>
						</div>
					</div>
				</div>
				<div class="col-xl-6">
					<div class="blog-item">
						<div class="blog-thumb set-bg" data-setbg="img/blog/3.jpg"></div>
						<div class="blog-content">
							<h4>Private schools adopt a Ucas style application system</h4>
							<div class="blog-meta">
								<span><i class="fa fa-calendar-o"></i> 24 Mar 2018</span>
								<span><i class="fa fa-user"></i> Owen Wilson</span>
							</div>
							<p>Integer luctus diam ac scerisque consectetur. Vimus dot euismod neganeco lacus sit amet. Aenean interdus mid vitae sed accumsan...</p>
						</div>
					</div>
				</div>
				<div class="col-xl-6">
					<div class="blog-item">
						<div class="blog-thumb set-bg" data-setbg="img/blog/4.jpg"></div>
						<div class="blog-content">
							<h4>Cambridge digs in at the top of university league table</h4>
							<div class="blog-meta">
								<span><i class="fa fa-calendar-o"></i> 23 Mar 2018</span>
								<span><i class="fa fa-user"></i> Owen Wilson</span>
							</div>
							<p>Integer luctus diam ac scerisque consectetur. Vimus dot euismod neganeco lacus sit amet. Aenean interdus mid vitae sed accumsan...</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> -->
	<!-- Blog section -->


	<!-- Newsletter section -->
	<section class="newsletter-section">
		<div class="container">
			<div class="row">
				<div class="col-md-5 col-lg-7">
					<div class="section-title mb-md-0">
					<h3>NEWSLETTER</h3>
					<p>Abonnez-vous et recevez les dernières nouvelles et des conseils utiles, des conseils et la meilleure offre.</p>
				</div>
				</div>
				<div class="col-md-7 col-lg-5">
					<form class="newsletter">
						<input type="text" placeholder="Votre Email ici">
						<button class="site-btn">Envoyes</button>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!-- Newsletter section end -->	

	<!-- Contact -->
	<section class="contact-page spad pt-0">
		<div class="container">
			<!-- <div class="map-section">
				<div class="contact-info-warp">
					<div class="contact-info">
						<h4>Address</h4>
						<p>40 Baria Street 133/2, NewYork City, US</p>
					</div>
					<div class="contact-info">
						<h4>Phone</h4>
						<p>(+88) 111 555 666</p>
					</div>
					<div class="contact-info">
						<h4>Email</h4>
						<p>infodeercreative@gmail.com</p>
					</div>
					<div class="contact-info">
						<h4>Working time</h4>
						<p>Monday - Friday: 08 AM - 06 PM</p>
					</div>
				</div>
				
				<div class="map" id="map-canvas"></div>
			</div> -->
			<div class="contact-form spad pb-0" id="contact">
				<div class="section-title text-center">
					<h3>Contact</h3>
					<!-- <p>Contact us for best deals and offer</p> -->
				</div>
				<form class="comment-form --contact">
					<div class="row">
						<div class="col-lg-4">
							<input type="text" placeholder="Votre Nom">
						</div>
						<div class="col-lg-4">
							<input type="text" placeholder="Votre Email">
						</div>
						<div class="col-lg-4">
							<input type="text" placeholder="Sujet">
						</div>
						<div class="col-lg-12">
							<textarea placeholder="Message"></textarea>
							<div class="text-center">
								<button class="site-btn">envoyer</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
<!-- fin Contact -->
	<!-- Footer section -->
	<footer class="footer-section">
		<div class="container footer-top">
			<div class="row">
				<!-- widget -->
				<div class="col-sm-6 col-lg-3 footer-widget">
					<div class="about-widget">
						<img src="img/logo2.png" width="150" alt="">
						<p>Société N° 1 AU MAROC </p>
						<div class="social pt-1">
							<!-- <a href=""><i class="fa fa-twitter-square"></i></a> -->
							<a href="https://www.facebook.com/MN-Express-Livraison-104009785422968"><i class="fa fa-facebook-square"></i></a>
							<!-- <a href=""><i class="fa fa-google-plus-square"></i></a> -->
							<!-- <a href=""><i class="fa fa-linkedin-square"></i></a> -->
							<a href="https://instagram.com/mn_express_livraison?utm_medium=copy_link"><i class="fa fa-instagram"></i></a>
						</div>
					</div>
				</div>
				<!-- widget -->
				<div class="col-sm-6 col-lg-3 footer-widget">
					<h6 class="fw-title">Lien</h6>
					<div class="dobule-link">
						<ul>
							<li><a href="">Accueil</a></li>
							<li><a href="">Qui sommes nous</a></li>
							<li><a href="">Service</a></li>
							<!-- <li><a href="">Events</a></li> -->
							<li><a href="">Contact</a></li>
						</ul>
						<!-- <ul>
							<li><a href="">Policy</a></li>
							<li><a href="">Term</a></li>
							<li><a href="">Help</a></li>
							<li><a href="">FAQs</a></li>
							<li><a href="">Site map</a></li>
						</ul> -->
					</div>
				</div>
				<!-- widget -->
				<div class="col-sm-6 col-lg-3 footer-widget">
					<!-- <h6 class="fw-title">RECENT POST</h6>
					<ul class="recent-post">
						<li>
							<p>Snackable study:How to break <br> up your master's degree</p>
							<span><i class="fa fa-clock-o"></i>24 Mar 2018</span>
						</li>
						<li>
							<p>Open University plans major <br> cuts to number of staff</p>
							<span><i class="fa fa-clock-o"></i>24 Mar 2018</span>
						</li>
					</ul> -->
				</div>
				<!-- widget -->
				<div class="col-sm-6 col-lg-3 footer-widget">
					<h6 class="fw-title">CONTACT</h6>
					<ul class="contact">
						<li><p><i class="fa fa-map-marker"></i> 28 Rue 7 Bournazel (Derrière Café Mohajir) Casablanca</p></li>
						<li><p><i class="fa fa-phone"></i> (+212) 679 280 061</p></li>
						<li><p><i class="fa fa-envelope"></i> contact@mnexpress.ma</p></li>
						<li><p><i class="fa fa-clock-o"></i> Lundi - Vendredi: 09 AM - 08 PM <br> Samedi: 09 AM - 03 PM</p></li>
						
					</ul>
				</div>
			</div>
		</div>
		<!-- copyright -->
		<div class="copyright">
			<div class="container">
				<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This web site is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://yansoft.ma" target="_blank">YAN SOFT</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
			</div>		
		</div>
	</footer>
	<!-- Footer section end-->



	<!--====== Javascripts & Jquery ======-->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.countdown.js"></script>
	<script src="js/masonry.pkgd.min.js"></script>
	<script src="js/magnific-popup.min.js"></script>
	<script src="js/main.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
	 <script>
        $(document).ready( function () {
          $('#regions').DataTable();
        });
        var ville = document.querySelector("#ville");
        ville.addEventListener('change',function(){
            var td = document.querySelector(".ville_table");
            if(td.innerHTML == ville.value) {
                document.querySelector(".frais").innerHTML = "17";
            };
        });
    </script>
</body>
</html>

	