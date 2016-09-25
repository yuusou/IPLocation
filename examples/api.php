<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use \IPLocation\Tools\ProviderPicker;

$provider = (new ProviderPicker($_GET['provider']))->getProvider($_GET['ip']);

if (isset($_GET['fields'])) {
    $fields = explode(',', $_GET['fields']);
}

switch ($_GET['format']) {
    case 'xml':
        header('Content-Type: application/xml');
        if(is_array($fields)) {
            echo $provider->getResultFields($fields, 'xml');

        } else {
            echo $provider->getResults('xml');
        }
        break;
    case 'json':
        header('Content-Type: application/json');
        if(is_array($fields)) {
            echo $provider->getResultFields($fields, 'json');

        } else {
            echo $provider->getResults('json');
        }
        break;
    default:
        header('Content-Type: text/html');
        if(is_array($fields)) {
                print_r($provider->getResultFields($fields));

        } else {
            print_r($provider->getResults());
        }
        break;
}

?>
