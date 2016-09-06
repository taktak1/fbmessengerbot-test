<?php
require('../vendor/autoload.php');
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
function http_get($url, $data) {
    $params = "";
    foreach ($data as $k => $v) {
        $params .= $k . '=' . urlencode($v) . '&';
    }
    $url = $url . "?" . $params;
    $url = rtrim($url, '&');
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
    ));
    $contents = curl_exec($ch);
    return $contents;
}
function get_rmr_single($url, $api_key, $question) {
    $data = array('api_key' => $api_key, 'question' => $question);
    $results = json_decode(http_get($url, $data), true);
    
//    $answers = "よくわかりません" . "\n";
    $answers = "";
            if (count($results) > 0) {
                $order = 0;
                foreach ($results as $result) {
                    $answers = $result['answer'] . "\n";
                    break;
                }
            }
    
    return $answers;
}
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
    // Let's hack from here!
    $body = json_decode($request->getContent(), true);
    $client = new Client(['base_uri' => 'https://graph.facebook.com/v2.6/']);
    foreach ($body['entry'] as $obj) {
        $app['monolog']->addInfo(sprintf('obj: %s', json_encode($obj)));
        foreach ($obj['messaging'] as $m) {
            $app['monolog']->addInfo(sprintf('messaging: %s', json_encode($m)));
            $from = $m['sender']['id'];
            $text = $m['message']['text'];
            $attachment = $m['message']['attachments'][0]['payload']['url'];
            $postback = $m['postback']['payload'];
            if(    $from    == '1464024910511356'  ){  continue;  }
            
            if ($attachment) {
                $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
$attachment = str_replace('\\', '', $attachment );
$attachment = urlencode( $attachment );
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL =>    getenv('docomo_key')   ."?image=" .  $attachment   ,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
    ));
    $body  = curl_exec(  $ch  );
$con   = (    $body   ) ;
$con = substr(  $con , 0  , 300   );
                       $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
                               'text' => $body ,
                               ],
                      ];
                      $client->request('POST', $path, ['json' => $json]);
            }
               if ($postback) {
               	$text=$postback;
               }
            if ($text) {
                $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN') );
$message  = file_get_contents( getenv('rmr_key')    ."?id=".  $from  ."&text=".  urlencode( $text )     );


if(preg_match("/^:@ /",$message)){
	$message = substr( $message , 3 );
	$items = explode(",", $message);
	
	/*
if(  count(  $items  ) <4 ){ 
	echo  "お店を探すことがことができませんでした。もう一度、正確に入力いただけますか？"   ;
	exit(0); 
}*/

                      $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
                               'attachment' =>  [
				      'type'  =>  'template'   ,
				      'payload'  => [
        "template_type" => "generic",
        "elements" =>  [
            
                    	[
        		"title"=> " メニュー名" ,
        		"image_url"=> "http://static.mealthy.me/uploads/menu/image/305.png"  , 
        		"subtitle"=>  "メニュー情報",
        		"buttons"=> [
        			"type"=> "web_url",
        		    "url"=> "https://itunes.apple.com/jp/app/wai-shi-konbinidedaietto!/id945615907",
		            "title"=> "mealthyで検索" 
        		]
        	] ,


           
	]
	
                                 ]
                            ]
                       ]
                      ];
	
	
}else if(  1 <  strlen(  $message )  ){
                      $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
                               'text' =>  $message ,
                          ], 
                      ];
                      
                      
}else{
	
                      $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
                               'attachment' =>  [
				      'type'  =>  'template'   ,
				      'payload'  => [
        "template_type"  =>  "button",
        "text"    =>    "mealthy",
        "buttons" =>  [
	[
        "type"  =>  "postback",
        "title" => "メニューを探す"  , 
        "payload" => "menu1"  ,  ] ,
	[
        "type"  =>  "postback",
        "title" => "栄養アドバイスをもらう"  , 
        "payload" => "advice2"  ,  ] ,
	[
        "type"  =>  "postback",
        "title" => "診断をする"  , 
        "payload" => "diagnosis3"  ,  ] ,
	]
                                 ]
                            ]
                       ]
                      ];
	
	
	
}
                      
                      
                      $client->request('POST', $path, ['json' => $json]);
                      
            }   
        }
    }
    return 0;
});
$app->run();
