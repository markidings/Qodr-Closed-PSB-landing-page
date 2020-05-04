<?php

/**
 * @package EtalaseAkikahKita
 */
/*
    Plugin Name: Etalase Akikah Kita
    Plugin URI: http://localhost/plugin
    Description: Ini adalah plugin etalase paket Akikah Kita
    Version: 1.0.0
    Author: QodrBee
    Author URI: https://qodrbee.com/
    License: GPLv2 or later
    Text Domain: etalase-akikah-kita
*/

// if (!defined('ABSPATH')) {
//     die;
// }

// if (!function_exists('add_action')) {
//     echo 'Hey, you can\t access this file, you silly human!';
//     exit; 
// }

defined('ABSPATH') or die('Hey, you can\t access this file, you silly human!');
add_action('admin_menu', 'akikah_kita_menu');

wp_register_style('bootstrap.min', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
wp_enqueue_style('bootstrap.min');
//Bootstrap Scripts
wp_register_script('bootstrap.bundle.min', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js');
wp_enqueue_script('bootstrap.bundle.min');
//Google Jquery
wp_register_script('jquery.min', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js');
wp_enqueue_script('jquery.min');

function akikah_kita_menu()
{
  add_menu_page('Paket Akikah Kita', 'Etalase Paket', 'manage_options', 'test-plugin', 'etalase_paket', 'dashicons-store');
}

// function seconddb() {
//   global $seconddb;
//   $seconddb = new wpdb('root', 'Qweasd123$', 'db_akikahkita', 'localhost');
// }
// add_action('init', 'seconddb');

function etalase_paket()
{
  global $wpdb;
  $paket = $wpdb->get_results("SELECT * FROM ugi_akikahkita_paket");

  $html = '
  <!-- Page Content -->
  <div class="tes" style="margin-right: 50px; margin-left: 30px">

    <div class="row">

      <div class="col-lg-3">

        <h1 class="my-4">Paket Akikah Kita</h1>
        <div class="list-group">
          <a href="#" class="list-group-item">Paket Hidup</a>
          <a href="#" class="list-group-item">Paket Matang</a>
          <a href="#" class="list-group-item">Kambing Jantan</a>
          <a href="#" class="list-group-item">Kambing Betina</a>
        </div>

      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" src="https://pelangiaqiqah.com/wp-content/uploads/2019/10/aqiqah-online-zaman-milenial-kambing-1300x650.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="https://pelangiaqiqah.com/wp-content/uploads/2019/10/aqiqah-online-zaman-milenial-kambing-1300x650.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="https://pelangiaqiqah.com/wp-content/uploads/2019/10/aqiqah-online-zaman-milenial-kambing-1300x650.jpg" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="row">';
  foreach ($paket as $value) {
    $html .= '
            <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
            <div class="card-body">
            <h4 class="card-title">
            <a href="http://localhost:8000/backend/ugi/akikahkita/ccheckout/create?paket_id=' . $value->id . '">' . $value->nama_paket . '</a>
            </h4>
              <h5> Rp. ' . number_format($value->harga, 2, ',', '.') . '</h5>
              <p class="card-text">' . $value->keterangan . '</p>
            </div>
            <div class="card-footer">
            <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
            </div>
            </div>
            </div>
          ';
  }
  $html .= '
        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->';

  echo $html;
}

function etalase_paket_hidup()
{
  echo "paket hidup";
}

function hello(){
  
  $seconddb = new wpdb('root', 'Qwerty123$', 'db_akikahlara', 'localhost');
  $db2 = $seconddb->get_results("SELECT * FROM users");

  $html = '';
  $no = 1;
  foreach ($db2 as $k)  {
    $html .= '<p>'.$no.'. Nama  : '. $k->name.' Kelas : '. $k->email.'</p>';
    $no++;
  }
  echo $html;
}


function list_mitra($atts){

  // extract(shortcode_atts(array(
  //     'a' => '#'
  // ), $atts)

  // );
  
  $seconddb = new wpdb('root', 'Qwerty123$', 'db_akikahlara', 'localhost');
  
  $mitra = $seconddb->get_results("SELECT * FROM users WHERE role = 'partner'");

  $html = '
        <div class="row">
            <div class="col-md-12 mt-5 mb-4">
                <h3 class="text-center" style="
                    font-weight: bold;
                    font-family: "Lato", sans-serif;">Daftar Mitra Akikah Kita </h3><br>
            </div>
        </div>
        <div class="container py-5">
            <div class="row">';
            foreach ($mitra as $value) { 
      $html .= '<div class="col-md-3">
                  <div class="card mb-4">
                      <div class=" card-body">';
                          
                          $metaPartners = $seconddb->get_results("SELECT * FROM meta_partners WHERE user_id = $value->id");
                          $imageName = explode("profile_photo/", $metaPartners[0]->profile_photo_file);
                          
                          $html .= '<center><img src="../../../../storage/images/partners/profile_photo/'.  $imageName[1] .'" width="80" height="80" style="border-radius:100%;"></center><br>
                          <h5 class="card-title text-center"><strong>'. $value->name .'</strong></h5>
                          <p class="card-text">
                              <!-- <h6 class="card-subtitle mb-2 text-muted text-center">'. $value->alamat .'</h6> -->
                          </p>
                      </div>
                      <div class="card-footer" style="background: linear-gradient( rgba(0, 0, 0, 0.5); rgba(0, 0, 0, 0.5) ); background-image: url(\'wp-content/plugins/etalase-akikah-kita/image/2.png\'); background-size: 100%; 100%;">
                        <a class="btn btn-success float-right" href="../detail-mitra/'. $value->id .'">Lihat Detail</a>
                      </div>
                  </div>
              </div>';
            } 
  $html .= '</div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12 mt-5 mb-4">
              <h3 class="text-center" style="
                  font-weight: bold;
                  font-family: "Lato", sans-serif;">Daftar Paket Akikah (Regional)</h3><br>
            </div>
        </div>
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="container py-5">
                <div class="row">';
                    
                    $cityGroup = [];
                    $totalPrice = 0;
                    $sumPrice = [];
                    $price = [];
                    $min = [];
                    $cityId = [];

                    $prices = $seconddb->get_results("SELECT * FROM pakets JOIN cities ON pakets.city_id=cities.id");

                    foreach ($prices as $pricess) {
                        $cityGroup[$pricess->city_id][] = $pricess;
                    }

                    foreach ($cityGroup as $packet) {
                        $lowerPrices = [];
                        foreach ($packet as $lowerPrice) {
                            array_push($lowerPrices, $lowerPrice->harga);
                        }
                        $city_id = $packet[0]->city_id;
                        $cityName = $seconddb->get_results("SELECT * FROM cities WHERE id = $city_id");
                $html .= '<div class="col-md-3">
                            <div class="card mb-4">
                                <div class=" card-body">
                                    <h5 class="card-title"><strong>'. $cityName[0]->name .'</strong></h5><br>
                                    <h6 class="card-subtitle mb-2 text-muted">Rp. '. number_format(min($lowerPrices), 0, ',', '.') .'</h6>
                                </div>
                                <div class="card-footer" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url(\'wp-content/plugins/etalase-akikah-kita/image/1.png\'); background-size: 100%; 100%;">
                                    <!-- <button class="btn btn-danger float-right">Beli</button> -->
                                    <a href="/formbooking/'. $cityName[0]->id .'" class="btn btn-danger float-right">Pesan</a>
                                </div>
                            </div> 
                        </div>';
                     } 
            $html .= '</div>
            </div>
        </div>';
echo $html;
}


function shortcodes_init(){
  add_shortcode('listmitra','list_mitra');
  add_shortcode('hellocode','hello');
 }
 add_action('init', 'shortcodes_init');

/* OOP */
// class EtalaseAkikahKita
// {
//     function activate()
//     {
//         // generated a CPT
//         // flush rewrite rules
//     }

//     function deactivate()
//     {
//         // flush rewrite rules
//     }

//     function uninstall()
//     {
//         // delete CPT
//         // delete all plugin data from the DB
//     }
// }

// if (class_exists('EtalaseAkikahKita')) {
//     $etalaseAkikahKita = new EtalaseAkikahKita();
// }

// // activation
// register_activation_hook(__FILE__, [$etalaseAkikahKita, 'activate']);

// // deactivation
// register_deactivation_hook(__FILE__, [$etalaseAkikahKita, 'deactivate']);

// // uninstall

