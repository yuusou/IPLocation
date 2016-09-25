<?php
namespace IPLocation\Providers;

use IPLocation\Tools\Provider;

/**
 * Provider "FreeGeoIP", extending the provider class. The field mappings are
 * based on the output from their API.
 */
class Freegeoip extends Provider
{
    /**
     * All the data necessary from the API is stored automatically on the
     * objects' creation.
     */
    public function __construct($inIp = '')
    {
        $this->setName("freegeoip");
        $this->setUrl("http://freegeoip.net/json/");
        $this->setIp($inIp);
        $this->setFields([
            'ip' => 'ip',
            'country' => 'country_name',
            'countryCode' => 'country_code',
            'region' => 'region_name',
            'regionCode' => 'region_code',
            'city' => 'city'
        ]);

        $this->setResults($this->getFromApi());
    }
}
