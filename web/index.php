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
            $quick_reply = $m['message']['quick_reply']['payload'];

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
            
            
               if ($quick_reply) {
               	$text=$quick_reply;
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
	
if(  count(  $items  ) < 16 ){ 
	exit(0); 
}
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
        		"title"=> $items[1]  ,
        		"image_url"=> "http://static.mealthy.me/uploads/menu/image/".  $items[4]  , 
        		"subtitle"=>  $items[2]." ".  $items[3]  ."円    ". $items[0]     ,
        		"buttons"=> [
        			[
        			"type"=> "web_url",
        		    "url"=> "https://itunes.apple.com/jp/app/wai-shi-konbinidedaietto!/id945615907",
		            "title"=> "Mealthyで検索" 
		            ]
        		],
        		],
        		
        		
                    	[
        		"title"=> $items[5]  ,
        		"image_url"=> "http://static.mealthy.me/uploads/menu/image/".  $items[8]  , 
        		"subtitle"=>  $items[6]." ".  $items[7]  ."円    ". $items[0]     ,
        		"buttons"=> [
        			[
        			"type"=> "web_url",
        		    "url"=> "https://itunes.apple.com/jp/app/wai-shi-konbinidedaietto!/id945615907",
		            "title"=> "Mealthyで検索" 
		            ]
        		],
        		],
        		
        		
                    	[
        		"title"=> $items[9]  ,
        		"image_url"=> "http://static.mealthy.me/uploads/menu/image/".  $items[12]  , 
        		"subtitle"=>  $items[10]." ".  $items[11]  ."円    ". $items[0]     ,
        		"buttons"=> [
        			[
        			"type"=> "web_url",
        		    "url"=> "https://itunes.apple.com/jp/app/wai-shi-konbinidedaietto!/id945615907",
		            "title"=> "Mealthyで検索" 
		            ]
        		],
        		],
        		
                    	[
        		"title"=> $items[13]  ,
        		"image_url"=> "http://static.mealthy.me/uploads/menu/image/".  $items[16]  , 
        		"subtitle"=>  $items[14]." ".  $items[15]  ."円    ". $items[0]     ,
        		"buttons"=> [
        			[
        			"type"=> "web_url",
        		    "url"=> "https://itunes.apple.com/jp/app/wai-shi-konbinidedaietto!/id945615907",
		            "title"=> "Mealthyで検索" 
		            ]
        		],
                        ],
	]
                                 ]
                            ]
                       ]
                      ];
	
	
	
for(  $i = 17  ; $i+4 <=  count(  $items  ) ;    $i+= 4   ){ 
	
	$json['message']['attachment']['payload']['elements'][] = 	[
        		"title"=> $items[ $i ]  ,
        		"image_url"=> "http://static.mealthy.me/uploads/menu/image/".  $items[ $i+3 ]  , 
        		"subtitle"=>  $items[ $i+1 ]." ".  $items[ $i+2 ]  ."円    ". $items[0]     ,
        		"buttons"=> [
        			[
        			"type"=> "web_url",
        		    "url"=> "https://itunes.apple.com/jp/app/wai-shi-konbinidedaietto!/id945615907",
		            "title"=> "Mealthyで検索" 
		            ]
        		],
                        ];
	
}
	
	
	
	
	
                      $client->request('POST', $path, ['json' => $json]);
	
	
                      $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
        "text"    =>    "他の用件はありますか？",
        "quick_replies" =>  [
	[
        "content_type"  =>  "text",
        "title" => "メニューを探す"  , 
        "payload" => "menu1"  ,  ] ,
	
	[
        "content_type"  =>  "text",
        "title" => "栄養アドバイス"  , 
        "payload" => "advice2"  ,  ] ,
	
	[
        "content_type"  =>  "text",
        "title" => "Ｑ＆Ａ"  , 
        "payload" => "diagnosis3"  ,  ] ,
	[
        "content_type"  =>  "text",
        "title" => "ニュース"  , 
        "payload" => "news4"  ,  ] ,
	]
                                 ]
                      ];
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}else  if(preg_match("/^*@ /",$message)){
	$message = substr( $message , 3 );
	$items = explode(",", $message);
	
 if(  4 <=  count(  $items  )  ){ 
 	
 	
 	
 	
 	
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
        		"title"=> "title"  ,
        		"image_url"=>   "https://fronteo-kenkojiman.s3.amazonaws.com/uploads/article/image1/1373/thumb_1473408383.jpg"  , 
        		"subtitle"=>  "subtitle"     ,
        		"buttons"=> [
        			[
        			"type"=> "web_url",
        		    "url"=> "https://www.kenkojiman.com/categories/medical/articles/1373/"     ,
		            "title"=> "この記事を読む" 
		            ]
        		],
        		],
        		]
        		]
        		]
        		]
        		];
 	
 	
 	
 	/*
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
        		"title"=> $items[0]  ,
        		"image_url"=>  $items[3]  , 
        		"subtitle"=>  $items[1]     ,
        		"buttons"=> [
        			[
        			"type"=> "web_url",
        		    "url"=> $items[2]     ,
		            "title"=> "この記事を読む" 
		            ]
        		],
        		],
        		]
        		]
        		]
        		]
        		];
        		*/
        		
 	
	/*
for(  $i = 4  ; $i+4 <=  count(  $items  ) ;    $i+= 4   ){ 
	
	$json['message']['attachment']['payload']['elements'][] = [
                    	[
        		"title"=> $items[ $i ]  ,
        		"image_url"=>  $items[ $i+3 ]  , 
        		"subtitle"=>  $items[ $i+1 ]     ,
        		"buttons"=> [
        			[
        			"type"=> "web_url",
        		    "url"=> $items[ $i+2 ]     ,
		            "title"=> "この記事を読む" 
		            ]
        		],
        		]
                        ];
	
}  */
	
	
 	
 }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}else  if(preg_match("/^;@ /",$message)){
	$message = substr( $message , 3 );
	$items = explode(",", $message);
	
 if(  2 <=  count(  $items  )  ){ 
	
                      $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
        "text"    =>    "どの店舗をお探しですか？",
        "quick_replies" =>  [
	[
        "content_type"  =>  "text",
        "title" => $items[1]  , 
        "payload" => $items[0]  ,  ] ,
	]
                                 ]
                      ];
                      
for(  $i = 2  ; $i+2 <=  count(  $items  ) ;    $i+= 2 ){ 
	
	$json['message']['quick_replies'][] = [
        "content_type"  =>  "text",
        "title" => $items[ $i+1 ]  , 
        "payload" => $items[ $i ]  ,
		];
	
}
                      
}



                      



	
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
        "text"    =>    "他の用件はありますか？",
        "quick_replies" =>  [
	[
        "content_type"  =>  "text",
        "title" => "メニューを探す"  , 
        "payload" => "menu1"  ,  ] ,
	
	[
        "content_type"  =>  "text",
        "title" => "栄養アドバイス"  , 
        "payload" => "advice2"  ,  ] ,
	
	[
        "content_type"  =>  "text",
        "title" => "Ｑ＆Ａ"  , 
        "payload" => "diagnosis3"  ,  ] ,
	[
        "content_type"  =>  "text",
        "title" => "ニュース"  , 
        "payload" => "news4"  ,  ] ,
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
