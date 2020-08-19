<!DOCTYPE html><html lang="en"><head>    <meta charset="utf-8">    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    <title>Howetools - Warehouse System</title>    <link rel="icon" type="image/ico" href="<?php echo base_url ?>public/images/favicon.ico">    <link href="<?php echo base_url ?>public/assets/bootstrap/bootstrap.min.css" rel="stylesheet"/>    <link rel="stylesheet" href="<?php echo base_url ?>public/assets/css/custom.css"/></head><body><header>    <?php Session::init(); ?>            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">                <button class="navbar-toggler" type="button" data-toggle="collapse"                        data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"                        aria-label="Toggle navigation">                    <span class="navbar-toggler-icon"></span>                </button>                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">                        <?php if (Session::get('loggedIn') == true): ?>                            <li class="nav-link<?php echo $this->parent == "imagechecker" ? " active" : "" ?>"><a                                    class="nav-link" href="<?php echo base_url ?>imagechecker/">Image Checker</a></li>                            <li class="nav-link<?php echo $this->parent == "my_account" ? " active" : "" ?>"><a                                    class="nav-link" href="<?php echo base_url ?>my_account/">Account</a></li>                            <li class="nav-link"><a class="nav-link" href="<?php echo base_url ?>my_account/logout">Logout</a>                        <?php else: ?>                            <li class="nav-link<?php echo $this->parent == "index" ? " active" : "" ?>"><a class="                                    nav-link" href="<?php echo base_url ?>">Home</a></li>                        <?php endif; ?>                    </ul>                </div>            </nav></header>