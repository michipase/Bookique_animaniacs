<?php
// Include config file
$titolo = 'Bookique - Home';
require_once UTILS_DIR . 'config.php';
include ASSETS_DIR . 'asset.php';
    requiresAuth([0,1,2]);
    
?>

<?php
include('assets/asset.php');
?>
<section class="banner" role="banner">
    <div class="container login-container login-form-1">
        <div class="container-fluid">
            <div class="row">
                sei nella home<br>
                devi esserne fiero :)
            </div>
        </div>
    </div>
</section>

