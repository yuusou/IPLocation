<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use \IPLocation\Tools\ProviderPicker;

$providerName = filter_input(INPUT_GET, 'provider');
$ip = filter_input(INPUT_GET, 'ip', FILTER_VALIDATE_IP);
$format = filter_input(INPUT_GET, 'format');
$fields = filter_input(INPUT_GET, 'fields');

if (!empty($fields)) {
    $fields = explode(',', $fields);
}

$provider = (new ProviderPicker($providerName))->getProvider($ip);

switch ($format) {
    case 'xml':
        header('Content-Type: application/xml');
        break;
    case 'json':
        header('Content-Type: application/json');
        break;
    default:
        header('Content-Type: text/html');
        break;
}

if(is_array($fields)) {
    echo $provider->getResultFields($fields, $format);
} else {
    echo $provider->getResults($format);
}

?>
