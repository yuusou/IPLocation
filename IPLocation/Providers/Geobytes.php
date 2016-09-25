<?php
namespace IPLocation\Providers;

use IPLocation\Tools\Provider;

/**
 * Provider "Geobytes", extending the provider class. The field mappings are
 * based on the output from their API.
 */
class Geobytes extends Provider
{
    /**
     * All the data necessary from the API is stored automatically on the
     * objects' creation.
     */
    public function __construct($inIp = '')
    {
        $this->setName("geobytes");
        $this->setUrl("http://getcitydetails.geobytes.com/GetCityDetails?fqcn=");
        $this->setIp($inIp);
        $this->setFields([
            'ip' => 'geobytesipaddress',
            'country' => 'geobytescountry',
            'countryCode' => 'geobytesinternet',
            'region' => 'geobytesregion',
            'regionCode' => 'geobytescode',
            'city' => 'geobytescity'
        ]);

        $this->setResults($this->getFromApi());
    }
}
