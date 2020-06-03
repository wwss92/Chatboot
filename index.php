<?php

// your access token generated from the facebook developer console
$access_token = 'EAANoKKNNwMMBAMZAYhiLR1h0g5tzxivsRZAlGznMrCkkEzh8Nv8ZAOk6NLIoz6f6WIE14gfvyPWd86uLTr53j47bl5wAemx7SqSZBeYvi3TemORATgX0XGrhiPHtrANNk3Au1W6qAfTiP37ktp4SKzpYlFKHiM2K4QXa3tgMt2hrRV5Ia0ctysIZBTzvto8UZD';

// the json input sent from facebook
$input = json_decode(file_get_contents('php://input'), true);

// the URL to send messages back to the BOT
$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;

/**** THIS IS THE AUTHENTICATION ***/
$hub_verify_token = null;
$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'fb_time_bot') {
  echo $challenge;
}
/******** THIS IS THE END OF THE AUTHENTICATION ***/

// gets the sender and message sent
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];

// mark the message that was sent to the BOT as seen
$markAsSeen = curl_init($url);
$jsonData = '{
    "recipient":{
        "id":"'.$sender.'"
    },
    "sender_action":"mark_seen"
}';
curl_setopt($markAsSeen, CURLOPT_POST, 1);
curl_setopt($markAsSeen, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($markAsSeen, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($markAsSeen);

// get the information about the user
$profile_url = 'https://graph.facebook.com/v2.6/'.$sender.'?access_token='.$access_token;

// get the user profile and do what ever with this
$profileInfo = json_decode(file_get_contents($profile_url));

// send a message back to the user
$ch = curl_init($url);
$message_to_reply = 'You said: '.$message;
$jsonData = '{
    "recipient":{
        "id":"'.$sender.'"
    },
    "message":{
        "text":"'.$message_to_reply.'"
    }
}';
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
// send this message only if the user sent us a message
if(!empty($input['entry'][0]['messaging'][0]['message'])){
    $result = curl_exec($ch);
}

?>
