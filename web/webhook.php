<?php
$access_token = "CAAPQaB88oLcBAJecxU4cwaA2mGy30YZAZBDmZAXCl3h0C41sZBXBd4eVxfcStKstpZAyqRZAh4zW1qBxoKSk64xd3yAVQedAOsUXZAeUhN46mNB60XrdR9Y6zHghswukUmZCSUq1KqPkNPZBpHZCOhP37X5S2dVfHtyS5gcaUmNAwCJZCeiFcjYeYw0fu3ic1xqCNuW2afSbnQi3QZDZD";
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);
$messaging = $json_object->entry{0}->messaging{0};

if(isset($messaging->message)) {
    $id = $messaging->sender->id;
    $message = 'マカロンはお金持ちのお菓子';
    $post = <<< EOM
    {
        "recipient":{
            "id":"{$id}"
        },
        "message":{
            "text":"{$message}"
        }
    }
EOM;

    api_send_request($access_token, $post);
}

function api_send_request($access_token, $post) {
    error_log("api_get_message_content_request start");
    $url = "https://graph.facebook.com/v2.6/me/messages?access_token={$access_token}";
    $headers = array(
            "Content-Type: application/json"
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($curl);
}
