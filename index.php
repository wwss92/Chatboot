<?php

$access_token = "EAANoKKNNwMMBAMZAYhiLR1h0g5tzxivsRZAlGznMrCkkEzh8Nv8ZAOk6NLIoz6f6WIE14gfvyPWd86uLTr53j47bl5wAemx7SqSZBeYvi3TemORATgX0XGrhiPHtrANNk3Au1W6qAfTiP37ktp4SKzpYlFKHiM2K4QXa3tgMt2hrRV5Ia0ctysIZBTzvto8UZD";
$verify_token = "fb_time_bot";
$hub_verify_token = null;
if(isset($_REQUEST['hub_challenge'])) {
 $challenge = $_REQUEST['hub_challenge'];
 $hub_verify_token = $_REQUEST['hub_verify_token'];
}
if ($hub_verify_token === $verify_token) {
 echo $challenge;
}

?>
