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

/*
    $result = json_decode($body, true); 
    $body  =   $result['candidates'][0]['tag']   ." ".     ( $result['candidates'][0]['score'] *100  )."%   "     ;
    $body  =   $result['candidates'][1]['tag']   ." ".     ( $result['candidates'][1]['score'] *100  )."%   "     ;
    $body  =   $result['candidates'][2]['tag']   ." ".     ( $result['candidates'][2]['score'] *100  )."%"     ;
    */
    
    
    
    
    /*
$con   = (    $body   ) ;
$con = substr(  $con , 0  , 300   );
*/
                       $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
                               'text' => $body ,
                               ],
                      ];
                      $client->request('POST', $path, ['json' => $json]);
                      
                      
                      
                      
	
	
	

                      $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
        "text"    =>    "アドバイスになりましたか？",
        "quick_replies" =>  [
			      	[
        "content_type"  =>  "text",
        "title" => "なるほど！"  , 
        "payload" => "good1"  ,  ] ,
	
	[
        "content_type"  =>  "text",
        "title" => "おしい！"  , 
        "payload" => "ok2"  ,  ] ,
	
	[
        "content_type"  =>  "text",
        "title" => "そもそもメニューが違う"  , 
        "payload" => "ng3"  ,  ] ,

	]
                                 ]
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
	
if(  count(  $items  ) < 5 ){ 
	exit(0); 
}
                      $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
//			      "text"    =>    "OK! ".   $items[0] ."調べます" ,
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
        		    "url"=> "https://bot-sample.mealthy.me/",
		            "title"=> "Mealthyで他を検索する" 
		            ],
        			[
        			"type"=> "web_url",
        		    "url"=> "me.mealthy://",
		            "title"=> "Mealthy起動" 
		            ],
        		],
        		],
        		
	]
                                 ]
                            ]
                       ]
                      ];
	
	
	
for(  $i = 5  ; $i+4 <=  count(  $items  ) ;    $i+= 4   ){ 
	
	$json['message']['attachment']['payload']['elements'][] = 	[
        		"title"=> $items[ $i ]  ,
        		"image_url"=> "http://static.mealthy.me/uploads/menu/image/".  $items[ $i+3 ]  , 
        		"subtitle"=>  $items[ $i+1 ]." ".  $items[ $i+2 ]  ."円    ". $items[0]     ,
        		"buttons"=> [
        			[
        			"type"=> "web_url",
        		    "url"=> "https://bot-sample.mealthy.me/",
		            "title"=> "Mealthyで他を検索する" 
		            ],
        			[
        			"type"=> "web_url",
        		    "url"=> "me.mealthy://",
		            "title"=> "Mealthy起動" 
		            ],
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}else if(preg_match("/^\*@ /",$message)){
	$message = substr( $message , 3 );
	$items = explode(",", $message);
	
 if(  8 <=  count(  $items  )  ){ 
 	
 	
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
        		"title"=> "title"  ,
        		"image_url"=> "http://static.mealthy.me/uploads/menu/image/"  , 
        		"subtitle"=>  "subtitle"   ,
        		"buttons"=> [
        			[
        			"type"=> "web_url",
        		    "url"=> "https://itunes.apple.com/jp/app/wai-shi-konbinidedaietto!/id945615907",
		            "title"=> "Mealthyで検索" 
		            ]
        		],
        		]
        		]
        		]
        		]
        		]
        		];
 	*/
 	
 	
 	
                      $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
			      
//			              "text"    =>    "最新の栄養ニュースはこちらです " ,
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
        		
                    	[
        		"title"=> $items[4]  ,
        		"image_url"=>  $items[7]  , 
        		"subtitle"=>  $items[5]     ,
        		"buttons"=> [
        			[
        			"type"=> "web_url",
        		    "url"=> $items[6]     ,
		            "title"=> "この記事を読む" 
		            ]
        		],
        		],
        		
                    	[
        		"title"=> $items[8]  ,
        		"image_url"=>  $items[11]  , 
        		"subtitle"=>  $items[9]     ,
        		"buttons"=> [
        			[
        			"type"=> "web_url",
        		    "url"=> $items[10]     ,
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
for(  $i = 12  ; $i+4 <=  count(  $items  ) ;    $i+= 4   ){ 
	
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
}
	*/
	
	
	
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
	
	
	
	
	
	
	
 	
 }
	
	
	
	
	
}else if(preg_match("/^;@ /",$message)){
	$message = substr( $message , 3 );
	$items = explode(",", $message);
	
 if(  2 <=  count(  $items  )  ){ 
	
                      $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
        "text"    =>    "いくつかありますが、どちらのお店ですか？",
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
                      
	
	
	if(strpos($message, "店を探すことがことができませんでした") !== false){
	if(strpos($message, "ちらのお店のメニューを") !== false){
}else if(strpos($message, "真を送ってくださ") !== false){
}else if(strpos($message, "問をどうぞ") !== false){
	}else{
                      
	
		
		
		
                      $client->request('POST', $path, ['json' => $json]);
	
                      $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
        "text"    =>    "質問の答えになってましたか？",
        "quick_replies" =>  [
	[
        "content_type"  =>  "text",
        "title" => "なるほど！"  , 
        "payload" => "good1"  ,  ] ,
	
	[
        "content_type"  =>  "text",
        "title" => "おしい！"  , 
        "payload" => "ok2"  ,  ] ,
	
	[
        "content_type"  =>  "text",
        "title" => "ぜんぜんダメ！"  , 
        "payload" => "ng3"  ,  ] ,
			      
	]
                                 ]
                      ];

/*
		
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
	}
	*/
                      
                      
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
