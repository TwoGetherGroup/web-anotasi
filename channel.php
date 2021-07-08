<?php

$ch = $_GET['ch'];
if(!isset($_GET['ch']) || $ch < 0 || $ch >= 100){
  header("location: index.html");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>2GetherGroup - Channel</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <script type="text/javascript">
    const flt_cod = ["prank", "skit", "standup", "food", "daily", "review", "reaction", "podcast", "music", "clip", "reality", "game", "otomotive", "technology", "beauty", "education", "horror", "howto", "magic", "challenge", "discussion", "animation", "news"];
    const flt_str = ["Prank", "Comedy Skit", "Stand Up Comedy", "Food Vlog", "Daily Vlog", "Review", "Reaction", "Podcast", "Music", "Cuplikan Film", "Reality Show", "Gaming", "Otomotif", "Teknologi", "Beauty Vlog", "Edukasi", "Horor", "Tutorial", "Magic", "Challenge", "Diskusi", "Animasi", "Berita"];

    $(function(){
      $.get('datafinal.json',function(obj){
        var str = "";
        var desc = "";
        var flt = "<li data-filter='*' class='filter-active'>All</li>";
        obj = obj[<?php echo $ch; ?>];  
        
        obj.category.forEach((categ) => {
          var fltint = -1;
          for(let i = 0; i < flt_cod.length; i++){
            if(flt_cod[i].localeCompare(categ) == 0){
              fltint = i;
              break;
            }
          }
          flt += "<li data-filter='.filter-" + categ + "'>" + flt_str[fltint] + "</li>";
        });

        var channel_id = obj.channel_id;
        var channel_name = obj.channel_name;
        var channel_photo = obj.channel_photo;
        var subs_string = "" + obj.subs_count + " juta";
        var video_count = obj.video_count;
        var videos = obj.videos;

        var yt_link = "https://youtube.com/";
        if(channel_id.startsWith("UC")){
          yt_link += "channel/" + channel_id;
        } else {
          yt_link += "user/" + channel_id;
        }
        
        desc += "<h2 data-aos='fade-in'>" + channel_name + "</h2>";
        desc += "<a href='" + yt_link + "' class='channel-photo'><img src='"+ channel_photo +"' width='20%' height='auto' alt=''></a>";
        desc += "</br></br><p data-aos='fade-in'>" + subs_string + " subscribers.</p>"
        desc += "<p data-aos='fade-in'>" + video_count + " videos.</p>"
        
        $.each(videos,function(n,data){
          str += "<div class='offset-lg-4 col-lg-4 col-md-6 portfolio-item filter-" + data.category + "'>"

          str += "<div class='portfolio-wrap'>";
          
          str+= "<img src='"+ data.thumbnail +"' width='100%' height='auto' class='img-fluid' alt=''>";

          str += "<div class='portfolio-links'>";

          str += "<a href='"+ data.thumbnail +"' data-gallery='portfolioGallery' class='portfolio-lightbox' title='"+ data.title +"'><i class='bi bi-plus'></i></a>";

          str += "<a href='" + data.url + "' title='Watch'><i class='bi bi-link'></i></a> </div> <div class='portfolio-info'> <h4>"+ data.title +"</h4> </div> </div> </div>"
          
        });
        $('#portfolio-flters').html(flt);
        $('.portfolio-container').html(str);
        $('#channel-desc').html(desc);
        doIsotope();
      });
    });

    const select = (el, all = false) => {
      el = el.trim()
      if (all) {
        return [...document.querySelectorAll(el)]
      } else {
        return document.querySelector(el)
      }
    }

    const on = (type, el, listener, all = false) => {
      let selectEl = select(el, all)
      if (selectEl) {
        if (all) {
          selectEl.forEach(e => e.addEventListener(type, listener))
        } else {
          selectEl.addEventListener(type, listener)
        }
      }
    }

    function doIsotope(){
      let portfolioContainer = select('.portfolio-container');
      if (portfolioContainer) {
        let portfolioIsotope = new Isotope(portfolioContainer, {
          itemSelector: '.portfolio-item',
          layoutMode: 'vertical'
        });

        let portfolioFilters = select('#portfolio-flters li', true);

        on('click', '#portfolio-flters li', function(e) {
          e.preventDefault();
          portfolioFilters.forEach(function(el) {
            el.classList.remove('filter-active');
          });
          this.classList.add('filter-active');

          portfolioIsotope.arrange({
            filter: this.getAttribute('data-filter')
          });
          portfolioIsotope.on('arrangeComplete', function() {
            AOS.refresh()
          });
        }, true);
      }
      setTimeout(function(){select('.filter-active').click();}, 3000);
    }
  </script>

<script type="text/javascript">

// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawChart);

// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
function drawChart() {
  var ch = <?php echo $ch; ?>;
  var data = new google.visualization.DataTable();
  var request = new XMLHttpRequest();
  request.open("GET", "./datafinal.json", false);
  request.send(null)
  var obj = JSON.parse(request.responseText);
  obj = obj[ch];

  data.addColumn('string', 'Category');
  data.addColumn('number', 'Channel Amount');
  var category_count = [];
  for(let i = 0; i < flt_cod.length; i++){
    category_count[i] = 0;
  }

  //get all categories
  for(let j = 0; j < obj.videos.length; j++){
    
    //compare to list categories
    for(let i = 0; i < flt_cod.length; i++){
      if(flt_cod[i].localeCompare(obj.videos[j].category) == 0){
        //add increment to category_count
        category_count[i]++;
        break;
      }
    }
  }

  for(let i = 0; i < flt_str.length; i++){
    data.addRow([flt_str[i], category_count[i]]);
  }

  // Set chart options
  var options = {'title':'Category Per Video in this channel\'s content.',
                 'titleTextStyle':{
                    fontSize: 17
                 },
                 'height':400,
                 'legend':{'position':'none'},
                 'animation':{
                     'duration': 1000,
                     'startup': true,
                     'easing':'inAndOut'
                 },
                 'tooltip':{
                     'trigger':'selection'
                 }};

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
  chart.draw(data, options);
}
</script>

  <!-- =======================================================
  * Template Name: Bocor - v4.3.0
  * Template URL: https://bootstrapmade.com/bocor-bootstrap-template-nice-animation/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1><a href="index.html">2GetherGroup<span>.</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a> -->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="./index.html">Home</a></li>
          <li><a class="nav-link scrollto" href="./index.html#team">Team</a></li>
          <li><a class="nav-link scrollto" href="./index.html#features">Features</a></li>
          <li><a class="nav-link scrollto" href="./index.html#graph">Chart</a></li>
          <li><a class="nav-link scrollto" href="./index.html#portfolio">Channel</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">

    <div class="container">
      <div class="row d-flex align-items-center">
        <div class="offset-lg-3 col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-up">
          <img src="assets/img/Logo polos.png" class="img-fluid" alt="">
        </div>
        <a></a>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">
    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio section-bg">
      <div class="container">

        <div id="channel-desc" class="section-title" data-aos="fade-up"></div>
        <div id="pie_chart" class="offset-lg-3 col-lg-6" data-aos="fade-up"></div>

        <div class="row">
          <div class="col-lg-12">
            <ul id="portfolio-flters">
            </ul>
          </div>
        </div>

        <div class="row portfolio-container" data-aos="fade-up"></div>

      </div>
    </section><!-- End Portfolio Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">

      <div class="container">

        <div class="row  justify-content-center">
          <div class="col-lg-6">
            <h3>2GETHERGROUP</h3>
          </div>
        </div>

        <div class="social-links">
          <a href="https://github.com/twogethergroup/" class="github"><i class="bx bxl-github"></i></a>
        </div>

      </div>
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>Bocor</span></strong>. Modified by 2GetherGroup
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/bocor-bootstrap-template-nice-animation/ -->
          Modified by <a href="https://github.com/twogethergroup/">TwoGetherGroup</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script> 
</body>

</html>