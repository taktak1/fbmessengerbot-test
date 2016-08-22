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
    
    $answers = "よくわかりません" . "\n";
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

            if(    $from    == '1464024910511356'  ){  continue;  }
            
            if ($attachment) {
                
                $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));

    $data = file_get_contents($attachment);
    file_put_contents('/tmp/temp.jpg',$data);




$docomo["image"]="@/tmp/temp.jpg";
$docomo["modelName"]="food";

$curl = curl_init("https://api.apigw.smt.docomo.ne.jp/imageRecognition/v1/concept/classify/?APIKEY=".   getenv('docomo_key')    );

curl_setopt($curl, CURLOPT_HEADER, true); 
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS,$docomo);

curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, true);

$response = curl_exec($curl);
$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE); 
$header = substr($response, 0, $header_size); 
$body = substr($response, $header_size); 
$result = json_decode($body, true); 
curl_close($curl);

                       $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
                               'text' =>  $response . " ".  $header_size    .  $body    ,
                               ],
                      ];
                      $client->request('POST', $path, ['json' => $json]);


            }

            
            
            if ($text) {
                $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));

//$api = "http://updatenews.ddo.jp/api?id=".   $from  . "&text=".  $text ;
//file_get_contents( $api  );

$url = 'https://adg.alt.ai:443/api/rmr_single';
$message = get_rmr_single($url,     getenv('rmr_key')    , $text);

                      $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
                               'text' =>  $message ,
                          ],
                      ];
                      $client->request('POST', $path, ['json' => $json]);
            }
        }
    }
    return 0;
});
$app->run();
