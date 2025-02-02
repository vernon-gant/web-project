<?php
require_once APPROOT . '/views/includes/head.php';
require_once APPROOT . '/views/includes/navbar.php';
?>
    <div class="w-100 overflow-hidden">
        <div class="row my-5">
            <div class="col-8 px-0 shadow mx-auto rounded-pill d-none d-md-block">
                <?php flash("booking_created");?>
				<?php flash("booking_rejected");?>
				<?php flash("user_logout_needed");?>
                <form method="get" action="<?php echo URL_ROOT?>/bookings" class="shadow
                rounded-pill px-0 overflow-hidden row mx-0">
                    <div class="col-9 overflow-hidden px-0">
                        <div class="px-2 mx-0 row">
                            <div class="col-9 d-flex flex-row px-0">
                                <div class="col-5 form-floating position-relative">
                                    <input required
                                           class="form-control border-0 <?php echo (!empty($data['arrival_err'])) ? 'is-invalid' : ''?>"
                                           id="arrival"
                                           name="arrival"
                                           type="date">
                                    <label class="form-label"
                                           for="arrival">Arrival</label>
                                    <span class="invalid-feedback"><?php if(!empty($data['arrival_err'])) echo $data['arrival_err']?></span>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-arrow-right fa-lg"></i>
                                </div>
                                <div class="col-5 form-floating">
                                    <input required
                                           class="form-control border-0 <?php echo (!empty($data['departure_err'])) ? 'is-invalid' : ''?>"
                                           id="departure"
                                           name="departure"
                                           type="date">
                                    <label class="form-label"
                                           for="departure">Departure</label>
                                    <span class="invalid-feedback"><?php if(!empty($data['departure_err']))echo $data['departure_err']?></span>
                                </div>
                            </div>
                            <div class="col-3 d-flex justify-content-center align-items-center
                            px-0">
                                <div class="input-group row m-0 align-self-center">
                                    <select class="col-auto w-100 rounded-2 h-50 p-0"
                                            id="guests"
                                            name="guests"
                                            required>
										<?php
										for ($i = 1; $i < 7; $i++) : ?>
                                            <option class="text-center"
                                                    value="<?php
													echo $i; ?>">
                                                <?php echo $i . " guests"; ?>
                                            </option>
										<?php
										endfor ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 overflow-hidden px-0 d-flex justify-content-center
                    align-items-center"
                         style="background-color: var(--link-color)">
                        <button type="submit" class="bg-transparent border-0">
                            <span class="fw-bold">Book Now</span>
                            <i class="fa-solid fa-arrow-right ms-1 ms-lg-2"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="row-cols-3 mx-auto d-flex justify-content-center d-md-none">
                <button class="btn btn-primary btn-success"> Book Now</button>
            </div>
        </div>
    </div>
    <div class="container p-5">
        <div class="card border-0 shadow-lg mx-auto mb-5 w-100">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <img src="<?php
					echo URL_ROOT ?>/img/home/bed.jpg"
                         alt="beds"
                         class="card-img fit-cover w-100 h-100">
                </div>
                <div class="col-12 col-lg-6 my-auto">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h2 class="text-center card-title mb-4">Directly in the center of the
                            city</h2>
                        <ul class="card-text">
                            <li class="mb-2">two&nbsp; freshly renovated&nbsp;studio apartments,
                                each suitable for 4
                                guests:
                                Kronberg &amp; Wiener Wald can accomodate up to 8 guests
                            </li>
                            <li class="mb-2">located in front of&nbsp;Schönbrunn Palace &amp; Vienna
                                Zoo
                            </li>
                            <li class="mb-2">2min walk from the city's&nbsp;U4 Metro Station
                                "Hietzing"
                            </li>
                            <li class="mb-2">10min from City Center via the U4 Metro line</li>
                            <li class="">supermarkt and several fine&nbsp;restaurants within a
                                walking distance
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-lg mx-auto mb-5 w-100">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <img src="<?php
					echo URL_ROOT ?>/img/home/lounge_bar.jpg"
                         alt="beds"
                         class="card-img fit-cover w-100 h-100">
                </div>
                <div class="col-12 col-lg-6 my-auto">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h2 class="text-center card-title mb-4">Directly in the center of the
                            city</h2>
                        <ul class="card-text">
                            <li class="mb-2">two&nbsp; freshly renovated&nbsp;studio apartments,
                                each suitable for 4
                                guests:
                                Kronberg &amp; Wiener Wald can accomodate up to 8 guests
                            </li>
                            <li class="mb-2">located in front of&nbsp;Schönbrunn Palace &amp; Vienna
                                Zoo
                            </li>
                            <li class="mb-2">2min walk from the city's&nbsp;U4 Metro Station
                                "Hietzing"
                            </li>
                            <li class="mb-2">10min from City Center via the U4 Metro line</li>
                            <li class="">supermarkt and several fine&nbsp;restaurants within a
                                walking distance
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-lg mx-auto mb-5 w-100">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <img src="<?php
					echo URL_ROOT ?>/img/home/terasse.jpg"
                         alt="beds"
                         class="card-img fit-cover w-100 h-100">
                </div>
                <div class="col-12 col-lg-6 d-flex flex-column">
                    <div class="card-body d-flex flex-column flex-grow-1">
                        <h2 class="text-center card-title mb-4">Directly in the center of the
                            city</h2>
                        <ul class="card-text flex-grow-1 d-flex flex-column justify-content-around">
                            <li class="mb-2 lh-lg">two&nbsp; freshly renovated&nbsp;studio
                                apartments, each suitable for
                                4 guests:
                                Kronberg &amp; Wiener Wald can accomodate up to 8 guests
                            </li>
                            <li class="mb-2 lh-lg">located in front of&nbsp;Schönbrunn Palace &amp;
                                Vienna Zoo
                            </li>
                            <li class="mb-2 lh-lg">2min walk from the city's&nbsp;U4 Metro Station
                                "Hietzing"
                            </li>
                            <li class="mb-2 lh-lg">10min from City Center via the U4 Metro line</li>
                            <li class="">supermarkt and several fine&nbsp;restaurants within a
                                walking distance
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-5">
        <h2 class="text-center mb-5 pb-4">EVERYTHING YOU NEED AT A GLANCE</h2>
        <div class="row d-flex flex-row justify-content-around mb-3">
            <div class="col-12 col-md-6 col-lg-3 mb-5">
                <div class="card w-100 flex-row justify-content-center border-0">
                    <div class="w-25 me-4 d-flex justify-content-end">
                        <i class="fa-solid fa-wifi fa-3x pe-1"></i>
                    </div>
                    <div class="w-50 d-flex flex-column justify-content-start">
                        <h6 class="card-title fw-bold">FREE WIFI</h6>
                        <p class="card-text fw-light">Throughout the premises</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-5">
                <div class="card w-100 flex-row justify-content-center border-0">
                    <div class="w-25 me-4 d-flex justify-content-end">
                        <i class="fa-solid fa-clock fa-3x pe-3"></i>
                    </div>
                    <div class="w-50 d-flex flex-column justify-content-start">
                        <h6 class="card-title fw-bold">RECEPTION</h6>
                        <p class="card-text fw-light">There for you 24/7</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card w-100 flex-row justify-content-center border-0">
                    <div class="w-25 me-4 d-flex justify-content-end">
                        <i class="fa-solid fa-burger fa-3x pe-3"></i>
                    </div>
                    <div class="w-50 d-flex flex-column justify-content-start">
                        <h6 class="card-title fw-bold">DRINKS AND SNACKS</h6>
                        <p class="card-text fw-light">Discover our wide selection at the One
                            Lounge</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex flex-row justify-content-around mb-3">
            <div class="col-12 col-md-6 col-lg-3 mb-5">
                <div class="card w-100 flex-row justify-content-center border-0">
                    <div class="w-25 me-4 d-flex justify-content-end">
                        <i class="fa-solid fa-location-dot fa-3x pe-3"></i>
                    </div>
                    <div class="w-50 d-flex flex-column justify-content-start">
                        <h6 class="card-title fw-bold">GREAT LOCATION</h6>
                        <p class="card-text fw-light">Stay somewhere special</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-5">
                <div class="card w-100 flex-row justify-content-center border-0">
                    <div class="w-25 me-4 d-flex justify-content-end">
                        <i class="fa-solid fa-mug-saucer fa-3x pe-3"></i>
                    </div>
                    <div class="w-50 d-flex flex-column justify-content-start">
                        <h6 class="card-title fw-bold">HEALTHY BREAKFAST BUFFET</h6>
                        <p class="card-text fw-light">Range of organic products and Fairtrade
                            coffee</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card w-100 flex-row justify-content-center border-0">
                    <div class="w-25 me-4 d-flex justify-content-end">
                        <i class="fa-solid fa-bed fa-3x pe-3"></i>
                    </div>
                    <div class="w-50 d-flex flex-column justify-content-start">
                        <h6 class="card-title fw-bold">HYPOALLERGENIC PILLOWS & DUVETS</h6>
                        <p class="card-text fw-light">Enjoy sweet dreams in quality bedding</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex flex-row justify-content-around">
            <div class="col-12 col-md-6 col-lg-3 mb-5">
                <div class="card w-100 flex-row justify-content-center border-0">
                    <div class="w-25 me-4 d-flex justify-content-end">
                        <i class="fa-solid fa-child fa-4x pe-3"></i>
                    </div>
                    <div class="w-50 d-flex flex-column justify-content-start ">
                        <h6 class="card-title fw-bold">STAY IN PARENTS’ ROOM</h6>
                        <p class="card-text fw-light">Free for children up to 12 years old</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-5">
                <div class="card w-100 flex-row justify-content-center border-0">
                    <div class="w-25 me-4 d-flex justify-content-end">
                        <i class="fa-solid fa-dog fa-3x pe-3"></i>
                    </div>
                    <div class="w-50 d-flex flex-column justify-content-start">
                        <h6 class="card-title fw-bold">PETS WELCOME</h6>
                        <p class="card-text fw-light">Contact the hotel directly</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="card w-100 flex-row justify-content-center border-0">
                    <div class="w-25 me-4 d-flex justify-content-end">
                        <i class="fa-solid fa-arrows-rotate fa-3x pe-3"></i>
                    </div>
                    <div class="w-50 d-flex flex-column justify-content-start">
                        <h6 class="card-title fw-bold">MY SERVICE OPTION</h6>
                        <p class="card-text fw-light">Opt out of daily housekeeping – to help our
                            environment</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
require_once APPROOT . '/views/includes/footer.php' ?>