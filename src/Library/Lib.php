<?php

namespace Library;

class Library
{

    /**
     * @var string Base URL of all API requests
     */
    protected $baseUrl = 'https://request-website-url';

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var string
     */
    protected $redirectUri;

    /**
     * @var array Cache for services so they aren't created multiple times
     */
    protected $apis = array();

    /**
     * @var boolean Determines if API calls should be logged
     */
    protected $debug = false;

    /**
     * @var Http\ClientInterface
     */
    protected $httpClient;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $httpLogAdapter;

    /**
     * @var boolean
     */
    public $needsEmptyKey = true;

    /**
     * @var Token
     */
    protected $token;

    /**
     * @param array $config
     */
    public function __construct($config = array())
    {
        if (isset($config['apiKey'])) {
            $this->apiKey = $config['apiKey'];
        }

        if (isset($config['secretKey'])) {
            $this->secretKey = $config['secretKey'];
        }

        if (isset($config['redirectUri'])) {
            $this->redirectUri = $config['redirectUri'];
        }

        if (isset($config['debug'])) {
            $this->debug = $config['debug'];
        }
    }


    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     *
     * @return string
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array  $params
     *
     * @throws LibraryException
     * @return mixed
     */
    public function restfulRequest($method, $url, $params = array())
    {
        $client = new Http\CurlClient;
        $full_params = [];
        $full_params['body'] = json_encode($params);
        $full_params['headers'] = array(
            'Content-Type' => 'application/json',
            'apiKey' => $this->getApiKey(),
            'secretKey' => $this->getSecretKey(),
        );
        $response = $client->request($method, $url, $full_params);
        return json_decode($response, true);
    }

    /**
     * @param $name
     *
     * @throws \UnexpectedValueException
     * @return mixed
     */
    public function __get($name)
    {
        $services = array(
            'customers',
            'profiles',
        );

        if (method_exists($this, $name) and in_array($name, $services)) {
            return $this->{$name}();
        }

        throw new \UnexpectedValueException(sprintf('Invalid service: %s', $name));
    }

    /**
     * @return \Library\Api\TaxSchemesService
     */
    public function taxSchemes()
    {
        return $this->getRestApi('TaxSchemesService');
    }

    /**
     * @return \Library\Api\TaxKeysService
     */
    public function taxKeys()
    {
        return $this->getRestApi('TaxKeysService');
    }

    /**
     * @return \Library\Api\CustomersService
     */
    public function customers()
    {
        return $this->getRestApi('CustomersService');
    }

    /**
     * @return \Library\Api\CurrencyService
     */
    public function currencies()
    {
        return $this->getRestApi('CurrencyService');
    }

    /**
     * @return \Library\Api\LanguagesService
     */
    public function languages()
    {
        return $this->getRestApi('LanguagesService');
    }

    /**
     * @return \Library\Api\VatService
     */
    public function vat()
    {
        return $this->getRestApi('VatService');
    }

    /**
     * @return \Library\Api\ProfessionsService
     */
    public function professions()
    {
        return $this->getRestApi('ProfessionsService');
    }

    /**
     * @return \Library\Api\ProfileService
     */
    public function profiles()
    {
        return $this->getRestApi('ProfileService');
    }

    /**
     * @return \Library\Api\OrderService
     */
    public function orders()
    {
        return $this->getRestApi('OrderService');
    }

    /**
     * @return \Library\Api\CalculationsService
     */
    public function calculations()
    {
        return $this->getRestApi('CalculationsService');
    }

    /**
     * Returns the requested class name, optionally using a cached array so no
     * object is instantiated more than once during a request.
     *
     * @param string $class
     *
     * @return mixed
     */
    public function getRestApi($class)
    {
        $class = '\Library\Api\\' . $class;

        return new $class($this);
    }

}
