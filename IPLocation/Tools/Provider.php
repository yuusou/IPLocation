<?php
namespace IPLocation\Tools;

use IPLocation\Tools\IP;

/**
 * An abstract class that contains the underlying structure for providers.
 * Providers extend this class.
 */
abstract class Provider
{
    /**
	 * API name.
	 * @var string
	 */
    private $name;

    /**
	 * API URL.
	 * @var string
	 */
    private $url;

    /**
	 * Client IP passed by the requesting application. May not be the actual
     * clients' IP.
	 * @var string
	 */
    private $ip;

    /**
	 * A mapping of our standard field names to the specific API's names.
	 * @var array
	 */
    private $fields;

    /**
	 * Results from the API go here.
	 * @var array
	 */
    private $results = array();

    /**
	 * Sets the API name, mostly informative.
	 * @param string
	 */
    protected function setName($inName)
    {
        $this->name = $inName;
    }

    /**
	 * Returns the API name.
     * @return string
	 */
    public function getName()
    {
        return $this->name;
    }

    /**
	 * Sets the API URL from which the data is fetched.
	 * @param string
	 */
    protected function setUrl($inUrl)
    {
        $this->url = $inUrl;
    }

    /**
	 * Returns the URL.
     * @return string
	 */
    public function getUrl()
    {
        return $this->url;
    }

    /**
	 * Tries to set passed IP by checking if it's valid. If not, no IP is
     * passed to the API.
     * @param string
	 */
    protected function setIp($inIp = '')
    {
        $this->ip = (new IP($inIp))->getIp();
    }

    /**
	 * Returns the IP set by the requesting application. Not necessarily the
     * client's IP.
     * @return string
	 */
    public function getIp()
    {
        return $this->ip;
    }

    /**
	 * Sets the field mapping from the APIs field names to our standard field
     * names.
     * @param array
	 */
    protected function setFields($inFields)
    {
        $this->fields = $inFields;
    }

    /**
	 * Returns the field mapping.
     * @return array
	 */
    public function getFields()
    {
        return $this->fields;
    }

    /**
	 * Sets an array with the results from the API.
     * @param array
	 */
    protected function setResults($inResults)
    {
        $this->results = $inResults;
    }

    /**
	 * Returns all the results requested from the API in the requested format.
     * @param string
     * @return mixed (XML, JSON, array)
	 */
    public function getResults($inFormat = '')
    {
        $allFields = array_keys($this->fields);
        return $this->getResultFields($allFields, $inFormat);
    }

    /**
     * Returns specified results from the API in the specified format.
     * XML.
     * @param array
     * @param string
     * @return mixed (XML, JSON, array)
     */
    public function getResultFields($inField = array(), $inFormat = '')
    {
        $resultFields = array();

        foreach ($inField as $fieldKey) {
            if (array_key_exists($fieldKey, $this->results) === true) {
                $resultFields[$fieldKey] = $this->results[$fieldKey];
            }
        }

        switch ($inFormat) {
            case 'xml':
                $xml = new \SimpleXMLElement('<root/>');
                array_walk_recursive(array_flip($resultFields), array($xml, 'addChild'));
                return $xml->asXML();
                break;
            case 'json':
                return json_encode($resultFields);
                break;
            default:
                return print_r($resultFields, true);
                break;
        }
        return $this->results[$inField];
    }

    /**
	 * Gets all the data from the API and returns it in an array.
     * @return string
	 */
    protected function getFromApi()
    {
        $apiOutput = file_get_contents("{$this->url}{$this->ip}");
        $apiContents = json_decode($apiOutput, true);

        foreach ($this->fields as $fieldKey => $apiKey) {
			if (array_key_exists($apiKey, $apiContents) === true) {
				$apiResults[$fieldKey] = $apiContents[$apiKey];
			}
		}

        return $apiResults;
    }
}
