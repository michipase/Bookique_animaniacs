<?php
// Include config file
$titolo = 'Bookique - Home';
require_once UTILS_DIR . 'config.php';
include ASSETS_DIR . 'asset.php';
if (isset($_SESSION['user'])){
    requiresAuth([0,1,2]);

    ?>
    <section class="banner" role="banner">
        <div class="container login-container login-form-1">
            <div class="container-fluid">
                <h2 style="color: black; text-align: left; left: 0">Home</h2>
                <div class="row" style="text-align: left">

                    Benvenuto nella tua homepage, <?php  echo $_SESSION['user']['data']['nome']; ?> <br>
                    devi esserne fiero :)
                    <br><br>

                        <div class="container-checkbox">
                            <a href="/upload" id="test2" class="btn">Carica Libri (solo per admin e case editrici)</a>
                            <label class="btn" for="test2"></label>
                            <span class="span"></span>
                        </div>

                </div>
            </div>
        </div>
    </section>
<?php } else header("location: landing"); ?>
