<?php
namespace IPLocation\Tools;

use IPLocation\Providers\Geobytes;
use IPLocation\Providers\Freegeoip;

/**
 * This class contains a list of available providers and is all that needs to
 * be included in any project.
 */
class ProviderPicker
{
    /**
     * Name of the provider.
     * @var string
     */
    private $providerName;

    /**
     * The provider's name should be paramaterised during creation, although a
     * default provider is defined.
     * @param string
     */
    public function __construct($inName = '')
    {
        $this->setProviderName($inName);
    }

    /**
     * Set the provider's name.
     * @param string
     */
    private function setProviderName($inName)
    {
        $this->providerName = $inName;
    }

    /**
     * Returns a provider object fully populated based on the passed IP.
     * @param string
     * @return object
     */
    public function getProvider($inIp = '')
    {
        switch ($this->providerName) {
            case 'freegeoip':
                return new Freegeoip($inIp);
                break;
            default:
            case 'geobytes':
                return new Geobytes($inIp);
                break;
        }
    }
}
