<?php get_header(); ?>
<?php
global $wpdb;
$paket = $wpdb->get_results("SELECT pakets.id, pakets.nama, users.name, pakets.harga, pakets.keterangan, pakets.kategori, pakets.gambar, pakets.kelebihan, profit_mitras.income_male FROM pakets JOIN users ON pakets.mitra_id = users.id JOIN profit_mitras ON pakets.id = profit_mitras.paket_id");
$mitra = $wpdb->get_results("SELECT * FROM users WHERE role = 'partner'");
$cities = $wpdb->get_results("SELECT * FROM users WHERE city_id IS NOT NULL");

function group_by($key, $data)
{
    $result = array();

    foreach ($data as $val) {
        if (array_key_exists($key, $val)) {
            $result[$val[$key]][] = $val;
        } else {
            $result[""][] = $val;
        }
    }

    return $result;
}

?>

<div id="carouselExampleIndicators" class="carousel slide contain" data-ride="carousel" style="margin-top:70px">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <span class="centered-element-tagline tagline">Akikah Kita</span>
        <p class="centered-element-desc">
            Menyediakan berbagai paket akikah untuk putera dan puteri Anda dengan harga bersaing. Langsung terhubung dengan mitra terbaik seluruh Indonesia!
        </p>
        <p class="centered-element-quality quality">Good Quality and Best Price!</p>
        <div class="carousel-item active">
            <img src="<?php echo get_stylesheet_directory_uri() . '/image/cute-baby-photo-shoot.jpg' ?>" class="d-block w-100">
        </div>
        <div class="carousel-item">
            <img src="<?php echo get_stylesheet_directory_uri() . '/image/tes2.jpg' ?>" class="d-block w-100">
        </div>
        <div class="carousel-item">
            <img src="<?php echo get_stylesheet_directory_uri() . '/image/s.jpg' ?>" class="d-block w-100">
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
<?php  echo do_shortcode('[listmitra][/listmitra]'); ?>
</div>

<div style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url(<?php echo get_stylesheet_directory_uri() . '/image/2.png' ?>); background-size: 100%; 100%;">
    <div class=" container py-5 text-white">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 mt-5 mb-2 text-center">
                        <h4>Mau Jadi Reseller Kami?</h4>
                    </div>
                    <div class="col-md-12 mb-3 text-center">
                        <p>Mau dapatkan keuntungan besar?, ayo gabung menjadi reseller <strong>akikah kita</strong>, caranya sangat mudah kok, silahkan anda klik tombol di bawah dan ikuti prosedurnya!</p>
                    </div>
                    <div class="col-md-12 mb-5 text-center">
                        <a href="../formreseller" class="btn btn-info">Menjadi Reseller!</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 mt-5 mb-2 text-center">
                        <h4>Mau Jadi Mitra Kami?</h4>
                    </div>
                    <div class="col-md-12 mb-3 text-center">
                        <p>Mau dapatkan keuntungan lebih besar?, anda juga bisa bergabung menjadi mitra <strong>akikah kita</strong>, caranya sangat mudah, silahkan klik tombol di bawah!</p>
                    </div>
                    <div class="col-md-12 mb-5 text-center">
                        <a href="../register/partner" class="btn btn-info">Menjadi Mitra!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php get_footer(); ?>