<?php
namespace IPLocation\Tools;

/**
 * This class is used to figure out the client's IP.
 */
class IP
{
    /**
	 * An array of server keys where the client's IP may possibly exist.
     * Possible keys are: HTTP_CLIENT_IP, HTTP_X_FORWARDED_FOR,
     * HTTP_X_FORWARDED, HTTP_X_CLUSTER_CLIENT_IP, HTTP_FORWARDED_FOR,
     * HTTP_FORWARDED and REMOTE_ADDR.
     * TODO: Figure out the order of most-acurate to least-acurate and which
     * are viable. Order of array must be by viability and accuracy.
	 * @var array
	 */
    private $serverIpKeys = array('REMOTE_ADDR', 'HTTP_CLIENT_IP');

    /**
	 * IP address of the client.
	 * @var string
	 */
    private $ip;

    /**
	 * At object creation, the IP is set.
     * @param string
	 */
    public function __construct($inIp = '')
    {
        $this->setIp($inIp);
    }

    /**
	 * Setting the IP either through a paramater passed in, from the server
     * keys or directly from the chosen API.
     * @param string
     * @return bool
	 */
    public function setIp($inIp = '')
    {
        if ($this->validateIp($inIp)) {
            $this->ip = $inIp;
            return true;
        } elseif ($this->setIpFromServerKeys()) {
            return true;
        }

        $this->ip = '';
        return false;
    }

    /**
	 * Cycles through server keys to find a valid IP and sets one as the IP.
     * Some keys such as HTTP_X_FORWARDED_FOR may have multiple results if
     * multiple proxies are used.
     * @return bool
	 */
    public function setIpFromServerKeys()
    {
        foreach ($this->serverIpKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $keyIp) {
                    if ($this->validateIp($keyIp)) {
                        $this->ip = $keyIp;
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
	 * Returns the IP.
     * @return string
	 */
    public function getIp()
    {
        return $this->ip;
    }

    /**
	 * Verifies if the IP is public. Reserved and private ranges aren't allowed.
     * @return bool
	 */
    private function validateIp($inIp)
    {
        if (filter_var($inIp, FILTER_VALIDATE_IP,
                FILTER_FLAG_NO_RES_RANGE |
                FILTER_FLAG_NO_PRIV_RANGE) === false) {
            return false;
        }

        return true;
    }
}
