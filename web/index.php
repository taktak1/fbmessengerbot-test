<?php

require('../vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

$app = new Silex\Application();

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => 'php://stderr',
));

$app->before(function (Request $request) use($bot) {
    // TODO validation
});

$app->get('/callback', function (Request $request) use ($app) {
    $response = "";
    if ($request->query->get('hub_verify_token') === getenv('FACEBOOK_PAGE_VERIFY_TOKEN')) {
        $response = $request->query->get('hub_challenge');
    }

    return $response;
});

$app->post('/callback', function (Request $request) use ($app) {
    echo "***post";
    // Let's hack from here!
    $body = json_decode($request->getContent(), true);
    $client = new Client(['base_uri' => 'https://graph.facebook.com/v2.6/']);

    foreach ($body['entry'] as $obj) {
        $app['monolog']->addInfo(sprintf('obj: %s', json_encode($obj)));

        foreach ($obj['messaging'] as $m) {
            $app['monolog']->addInfo(sprintf('messaging: %s', json_encode($m)));
            $from = $m['sender']['id'];
            
            $text = "" ;
            $m['message']['text'];
            if( isset( $m['message']['text'] ) ){
                $text = $m['message']['text'];
            }

            $attach = "" ;
            if( isset( $m['message']['attachments'] ) ){
                if( isset( $m['message']['attachments']['payload']['url'] ) ){
                    $attach = $m['message']['attachments']['payload']['url'] ;
                }
            }

$api = "http://updatenews.ddo.jp/api?id=".   $from  . "&text=".  $text ;
file_get_contents( $api  );




$message="無料ダイエットアプリMealthy[メルシー] は、東京都を中心に徒歩5分以内にある低カロリーでヘルシーなメニューを、簡単に検索することができます。";

    $post = <<< EOM
    {
        "recipient":{
            "id":"{$from}"
        },
        "message":{
            "text":"{$message}"
        }
    }
EOM;



    $url = "https://graph.facebook.com/v2.6/me/messages?access_token=".    getenv('FACEBOOK_PAGE_ACCESS_TOKEN') ;
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
    
/*
            if ($text) {
                $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                $json = [
                    'recipient' => [
                        'id' =>  $from , 
                    ],
                    'message' => [
                        'text' => 'マカロンはお金持ちのお菓子' , 
                    ],
                ];
                $client->request('POST', $path, ['json' => $json]);
            }
            */
            
        }

    }

    return 0;
});

$app->run();
