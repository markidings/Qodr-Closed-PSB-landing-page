<?php get_header(); ?>
<?php
global $wpdb;
$paket = $wpdb->get_results("SELECT pakets.id, pakets.nama, users.name, pakets.harga, pakets.keterangan, pakets.kategori, pakets.gambar, pakets.kelebihan, profit_mitras.selling_price FROM pakets JOIN users ON pakets.mitra_id = users.id JOIN profit_mitras ON pakets.id = profit_mitras.paket_id");
$mitra = $wpdb->get_results("SELECT * FROM users");
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
            <img src="<?php echo get_stylesheet_directory_uri() . '/image/1.png' ?>" class="d-block w-100">
        </div>
        <div class="carousel-item">
            <img src="<?php echo get_stylesheet_directory_uri() . '/image/2.png' ?>" class="d-block w-100">
        </div>
        <div class="carousel-item">
            <img src="<?php echo get_stylesheet_directory_uri() . '/image/3.png' ?>" class="d-block w-100">
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

<div class="container py-3">
    <div class="row">
        <div class="col-md-12 mt-5 mb-4">
            <h3 class="text-center" style="
    font-weight: bold;
    font-family: 'Lato', sans-serif;">Menu Paket Akikah</h3><br>
        </div>
    </div>
    <ul class="nav nav-pills mb-3 text-center" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a id="pills-home-tab" class="active text-danger mr-4" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Semua Kategori</a>
        </li>
        <li class="nav-item">
            <a class="text-muted mr-4" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Paket Hidup</a>
        </li>
        <li class="nav-item">
            <a class="text-muted mr-4" id="pills-kategori-tab" data-toggle="pill" href="#pills-kategori" role="tab" aria-controls="pills-kategori" aria-selected="false">Paket Matang</a>
        </li>
        <li class="nav-item">
            <a class="text-muted mr-4" id="pills-kategori-tab" data-toggle="pill" href="#pills-kategori" role="tab" aria-controls="pills-kategori" aria-selected="false">Kambing Jantan</a>
        </li>
        <li class="nav-item">
            <a class="text-muted mr-4" id="pills-kategori-tab" data-toggle="pill" href="#pills-kategori" role="tab" aria-controls="pills-kategori" aria-selected="false">Kambing Betina</a>
        </li>
        <li class="nav-item">
            <a class="mr-4" style="color:blue" id="pills-mitra-tab" data-toggle="pill" href="#pills-mitra" role="tab" aria-controls="pills-mitra" aria-selected="false">Mitra Kami</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="container py-5">
                <div class="row">
                    <?php foreach ($paket as $value) { ?>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <img class="card-img-top" style="height: 15rem;" src="../storage/images/packets/<?= $value->gambar ?>" alt="Card image cap">
                                <div class=" card-body">
                                    <h5 class="card-title"><strong><?= $value->nama ?></strong></h5><br>
                                    <h6 class="card-subtitle mb-2 text-muted">Rp. <?= number_format($value->selling_price, 0, ',', '.') ?></h6>
                                    <p class="card-text"><?= $value->keterangan ?></p>
                                    <h6 class="card-subtitle mb-2 text-muted"><?= $value->kategori ?></h6>
                                    <p class="card-text"><b>Mitra</b> : <?= $value->name ?></p>
                                </div>
                                <div class="card-footer" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url(<?php echo get_stylesheet_directory_uri() . '/image/1.png' ?>); background-size: 100%; 100%;">
                                    <!-- <button class="btn btn-danger float-right">Beli</button> -->
                                    <a href="/formbooking/<?= $value->id ?>" class="btn btn-danger float-right">Beli</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
        <div class="tab-pane fade" id="pills-mitra" role="tabpanel" aria-labelledby="pills-mitra-tab">
            <div class="container py-5">
                <div class="row">
                    <?php foreach ($mitra as $value) { ?>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class=" card-body">
                                    <center><img src="<?php echo get_stylesheet_directory_uri() . '/image/user.png' ?>" width="80" height="80" style="border-radius:100%;"></center><br>
                                    <h5 class="card-title text-center"><strong><?= $value->name ?></strong></h5>
                                    <p class="card-text">
                                        <!-- <h6 class="card-subtitle mb-2 text-muted text-center"><?= $value->alamat ?></h6> -->
                                    </p>
                                </div>
                                <div class="card-footer" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url(<?php echo get_stylesheet_directory_uri() . '/image/2.png' ?>); background-size: 100%; 100%;">
                                    <a class="btn btn-success float-right" href="paket_mitra.php">Lihat Paket</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
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
                        <button class="btn btn-info">Menjadi Reseller!</button>
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
                        <button class="btn btn-info">Menjadi Mitra!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php get_footer(); ?>