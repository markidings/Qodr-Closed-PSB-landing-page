<div class="container py-3 background-color">
    <div class="tab-content" id="pills-tabContent">
        <div class="row">
            <div class="col-md-12 mt-5 mb-4">
                <h3 class="text-center" style="
                    font-weight: bold;
                    font-family: 'Lato', sans-serif;">Daftar Mitra Akikah Kita</h3><br>
            </div>
        </div>
        <div class="container py-5">
            <div class="row">
                <?php foreach ($mitra as $value) { ?>
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <div class=" card-body">
                                <?php
                                $metaPartners = $wpdb->get_results("SELECT * FROM meta_partners WHERE user_id = $value->id");
                                $imageName = explode("profile_photo/", $metaPartners[0]->profile_photo_file);
                                ?>
                                <center><img src="../../../../storage/images/partners/profile_photo/<?= $imageName[1] ?>" width="80" height="80" style="border-radius:100%;"></center><br>
                                <h5 class="card-title text-center"><strong><?= $value->name ?></strong></h5>
                                <p class="card-text">
                                    <!-- <h6 class="card-subtitle mb-2 text-muted text-center"><?= $value->alamat ?></h6> -->
                                </p>
                            </div>
                            <div class="card-footer" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url(<?php echo get_stylesheet_directory_uri() . '/image/2.png' ?>); background-size: 100%; 100%;">
                                <a class="btn btn-success float-right" href="../detail-mitra/<?= $value->id ?>">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <hr>
        <div class="row">
        <div class="col-md-12 mt-5 mb-4">
            <h3 class="text-center" style="
                font-weight: bold;
                font-family: 'Lato', sans-serif;">Daftar Paket Akikah (Regional)</h3><br>
            </div>
        </div>
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="container py-5">
                <div class="row">
                    <?php
                    $cityGroup = [];
                    $totalPrice = 0;
                    $sumPrice = [];
                    $price = [];
                    $min = [];
                    $cityId = [];

                    $prices = $wpdb->get_results("SELECT * FROM pakets JOIN cities ON pakets.city_id=cities.id");

                    foreach ($prices as $pricess) {
                        $cityGroup[$pricess->city_id][] = $pricess;
                    }

                    foreach ($cityGroup as $packet) {
                        $lowerPrices = [];
                        foreach ($packet as $lowerPrice) {
                            array_push($lowerPrices, $lowerPrice->harga);
                        }
                        $city_id = $packet[0]->city_id;
                        $cityName = $wpdb->get_results("SELECT * FROM cities WHERE id = $city_id"); ?>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class=" card-body">
                                    <h5 class="card-title"><strong><?= $cityName[0]->name ?></strong></h5><br>
                                    <h6 class="card-subtitle mb-2 text-muted">Rp. <?= number_format(min($lowerPrices), 0, ',', '.') ?></h6>
                                </div>
                                <div class="card-footer" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url(<?php echo get_stylesheet_directory_uri() . '/image/1.png' ?>); background-size: 100%; 100%;">
                                    <!-- <button class="btn btn-danger float-right">Beli</button> -->
                                    <a href="/formbooking/<?= $cityName[0]->id ?>" class="btn btn-danger float-right">Pesan</a>
                                </div>
                            </div> 
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>