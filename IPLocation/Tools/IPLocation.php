<?php
namespace IPLocation\Tools;

use IPLocation\Tools\ProviderPicker;

class IPLocation
{
    public function getIp()
    {
        //return (new ProviderPicker())->getProvider()->getResultField('ip');
        return '8.8.4.4';
    }
}
