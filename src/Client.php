<?php

namespace SimBioT1954\Vk;

/**
 * Class Client
 * @package SimBioT1954\Vk
 */
class Client
{
    public const API_VERSION = '5.74';

    /**
     * Curl instance.
     * @var Resource
     */
    private $ch;

    /**
     * Client constructor.
     */
    public function __construct ()
    {
        $this->ch = curl_init();
    }

    /**
     * Destructor.
     */
    public function __destruct ()
    {
        curl_close($this->ch);
    }

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @return VkResponse
     */
    public function api (string $method, array $parameters = []): VkResponse
    {
        $parameters['v'] = self::API_VERSION;

        $api_url = $this->getApiUrl($method);
        $response = $this->request($api_url, $parameters);

        return new VkResponse($response);
    }

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @return VkResponse
     */
    public function rawRequest (string $method, array $parameters = []): VkResponse
    {
        return new VkResponse($this->request($method, $parameters));
    }

    /**
     * Returns base API url.
     *
     * @param   string $method
     *
     * @return  string
     */
    private function getApiUrl (string $method): string
    {
        return 'https://api.vk.com/method/' . $method . '.json';
    }

    /**
     * Executes request on link.
     *
     * @param   string $url
     * @param   array  $fields
     *
     * @return  mixed
     */
    private function request ($url, array $fields = [])
    {
        curl_setopt_array($this->ch, [
            CURLOPT_USERAGENT      => '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $fields,
            CURLOPT_URL            => $url
        ]);

        return curl_exec($this->ch);
    }


}