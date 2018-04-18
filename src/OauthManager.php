<?php

namespace SimBioT1954\Vk;

use SimBioT1954\Vk\Vk as VkApi;
use SimBioT1954\Vk\VkResponse as ApiResponse;
use Phalcon\Config;

/**
 * Class OauthManager
 * @package SimBioT1954\Vk
 */
class OauthManager
{
    private const ACCESS_TOKEN_URL = 'https://oauth.vk.com/access_token';
    private const AUTHORIZE_URL = 'https://oauth.vk.com/authorize';

    public const GROUP_REDIRECT_URL = '/oauth/vk/group';
    public const USER_REDIRECT_URL = '/oauth/vk';
    public const CONNECT_PROFILE_REDIRECT_URL = '/profiles/oauth/vk';


    /**
     * @var VkApi
     */
    private $vk;

    /**
     * @param Config $config
     *
     * @return string
     */
    public function getConnectProfileRedirectUrl (Config $config): string
    {
        return self::AUTHORIZE_URL .
            '?client_id=' . $config->vk->app_id .
            '&scope=audio,wall,info,pages,offline,groups,stats,docs,market,photos,video' .
            '&redirect_uri=' . urldecode($config->application->host . self::CONNECT_PROFILE_REDIRECT_URL) .
            '&response_type=code';
    }

    /**
     * @param Config $config
     * @param string $url
     *
     * @return string
     */
    public function getUserRedirectUrl (Config $config, string $url): string
    {
        return self::AUTHORIZE_URL .
            '?client_id=' . $config->vk->app_id .
            '&scope=audio,wall,info,pages,offline,groups,stats,docs,market,photos,video' .
            '&redirect_uri=' . $this->getUrl($config, $url) .
            '&response_type=code';
    }

    /**
     * @param array  $group_ids
     * @param Config $config
     *
     * @return string
     */
    public function getGroupRedirectUrl (array $group_ids, Config $config): string
    {
        return self::AUTHORIZE_URL .
            '?client_id=' . $config->vk->app_id .
            '&scope=stories,manage,messages,photos,docs' .
            '&redirect_uri=' . $this->getUrl($config, self::GROUP_REDIRECT_URL) .
            '&group_ids=' . implode(',', $group_ids) .
            '&response_type=code&v=' . VkApi::API_VERSION;
    }

    /**
     * @param string $code
     * @param Config $config
     * @param string $url
     *
     * @return VkResponse
     */
    public function getAccessToken (string $code, Config $config, string $url): ApiResponse
    {
        return $this->getVk()->rawRequest(self::ACCESS_TOKEN_URL .
            '?client_id=' . $config->vk->app_id .
            '&client_secret=' . $config->vk->secret_key .
            '&code=' . $code .
            '&redirect_uri=' . $this->getUrl($config, $url));
    }

    /**
     * @param Config $config
     * @param string $url
     *
     * @return string
     */
    public function getUrl (Config $config, string $url): string
    {
        return urldecode($config->application->host . $url);
    }


    /**
     * @return VkApi
     */
    public function getVk (): VkApi
    {
        if (!$this->vk) {

            return $this->vk = new VkApi();

        }

        return $this->vk;
    }

}