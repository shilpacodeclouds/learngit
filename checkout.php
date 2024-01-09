<?php
require_once ('library' . DIRECTORY_SEPARATOR . 'app.php');
use Application\Session;
use Application\Request;
use Application\Config;

$queryParam = Request::query()->all();

//----------------------------------  Parameter store in url ------------------------------------------//
// if (!empty($_SERVER['QUERY_STRING'])) {
//     Session::set('queryParams', Request::query()->all());
// }
//----------------------------------  /Parameter store in url ------------------------------------------//
//----------------------------------  Parameter store in url ------------------------------------------//
if (!empty($_SERVER['QUERY_STRING'])) {
Session::set('queryParams', Request::query()->all());

$affiliatesMapping = array(
    'afId'    => array('AFID', 'afid'),
    'affId'   => array('AFFID', 'affid'),
    'sId'     => array('SID', 'sid'),
    'c1'      => array('C1'),
    'c2'      => array('C2'),
    'c3'      => array('C3'),
    'c4'      => array('C4'),
    'c5'      => array('C5'),
    'aId'     => array('AID', 'aid'),
    'opt'     => array('OPT', 'opt'),
    'clickId' => array('click_id'),
);
$queryKeys  = array_keys(Request::query()->all());
$affiliates = array();
foreach (array_keys($affiliatesMapping) as $key) {
    if (in_array($key, $queryKeys)) {
        $affiliates[$key] = Request::query()->get($key);
        continue;
    }
    foreach ($affiliatesMapping[$key] as $alias) {
        if (in_array($alias, $queryKeys)) {
            $affiliates[$key] = Request::query()->get($alias);
            break;
        }
    }
}
Session::set('affiliates', $affiliates);
}


$session_data = Session::all();
if (!array_key_exists("affiliates", $session_data))
{
    $affiliates = array();
    Session::set('affiliates', $affiliates);
}


//----------------------------------  /Parameter store in url END------------------------------------------//

App::run(array(
    'config_id'    => 1,
    'step'         => 1,
    'tpl'          => 'checkout',
    'go_to'        => 'verify.php',
    'version'      => 'desktop',
    'tpl_vars'     => array(
        
        'queryParam'=>$queryParam,
       
    ),
    'pageType'     => 'checkoutPage',
    
    
));
