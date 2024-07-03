<?php
require '/xampp/htdocs/guvi_in/vendor/autoload.php';
use Predis\Client;

$redis = new Client([
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379,
]);

function getSession($sessionID) {
    global $redis;
    $userID = $redis->get($sessionID);
    return $userID ? $userID : false;
}

?>
