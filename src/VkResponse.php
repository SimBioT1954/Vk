<?php

namespace SimBioT1954\Vk;

/**
 * SimBioT1954\Vk\Vk
 *
 */
class VkResponse
{
    private $data;

    /**
     * VkResponse constructor.
     *
     * @param string $response
     */
    public function __construct ($response)
    {
        $this->data = json_decode($response, true);
    }

    /**
     * @return mixed
     */
    public function getResponse ()
    {
        return $this->data['response'] ?? $this->data;
    }

    /**
     * @return mixed
     */
    public function getError ()
    {
        return $this->data['error'];
    }

    /**
     * @return bool
     */
    public function hasError (): bool
    {
        return isset($this->data['error']);
    }

    /**
     * @return bool
     */
    public function isOk (): bool
    {
        return !isset($this->data['error']);
    }

    /**
     * @return bool
     */
    public function isTrue (): bool
    {
        return $this->data['response'] === 1;
    }

    /**
     * @return mixed
     */
    public function getData ()
    {
        return $this->data;
    }

}