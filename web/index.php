<?php
require('../vendor/autoload.php');
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;




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









$url = 'https://adg.alt.ai:443/api/rmr_single';



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
            
            if(    $from    == '1464024910511356'  ){  continue;  }
            
            if ($text) {
                $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));




//$api = "http://updatenews.ddo.jp/api?id=".   $from  . "&text=".  $text ;
//file_get_contents( $api  );

$message = get_rmr_single($url,     getenv('rmr_key')    , $text);




                      $json = [
                          'recipient' => [
                              'id' => $from,
                          ],
                          'message' => [
                               'text' =>  $message ,
//                              'text' => "無料ダイエットアプリMealthy[メルシー] は、東京都を中心に徒歩5分以内にある低カロリーでヘルシーなメニューを、簡単に検索することができます。" ,
                          ],
                      ];
                      $client->request('POST', $path, ['json' => $json]);


            }
        }
    }
    return 0;
});
$app->run();
