<?php

namespace SocialDataPool\Infrastructure\Api\Instagram;

use SocialDataPool\Infrastructure\Api\Instagram\Exception\InstagramException;

class Client
{
    const API_URL             = 'https://api.instagram.com/v1/';
    const API_OAUTH_URL       = 'https://api.instagram.com/oauth/authorize';
    const API_OAUTH_TOKEN_URL = 'https://api.instagram.com/oauth/access_token';

    /** @var string */
    private $api_key;

    /** @var string */
    private $api_secret;

    /** @var string */
    private $callback_url;

    /** @var string */
    private $access_token;

    /** @var array string */
    private $all_scopes = array('basic', 'likes', 'comments', 'relationships', 'public_content');

    public function __construct($an_api_key, $an_api_secret, $an_api_callback)
    {
        $this->api_key      = $an_api_key;
        $this->api_secret   = $an_api_secret;
        $this->callback_url = $an_api_callback;
    }

    /**
     * Generates the OAuth login URL.
     *
     * @param string[] $scopes Requesting additional permissions
     *
     * @return string Instagram OAuth login URL
     *
     * @throws \SocialDataPool\Infrastructure\Api\Instagram\Exception\InstagramException
     */
    public function getLoginUrl($scopes = array('basic'))
    {
        if (is_array($scopes) && count(array_intersect($scopes, $this->all_scopes)) === count($scopes))
        {
            return self::API_OAUTH_URL . '?client_id=' . $this->getApiKey(
            ) . '&redirect_uri=' . urlencode($this->getApiCallback()) . '&scope=' . implode('+',
                $scopes
            ) . '&response_type=code';
        }

        throw new InstagramException("Error: getLoginUrl() - The parameter isn't an array or invalid scope permissions used."
        );
    }

    /**
     * Get media by its id.
     *
     * @param int $id Instagram media ID
     *
     * @return mixed
     */
    public function getMedia($id)
    {
        return $this->_makeCall('media/' . $id);
    }

    /**
     * Search media by its location.
     *
     * @param float $lat          Latitude of the center search coordinate
     * @param float $lng          Longitude of the center search coordinate
     * @param int   $distance     Distance in metres (default is 1km (distance=1000), max. is 5km)
     * @param long  $minTimestamp Media taken later than this timestamp (default: 5 days ago)
     * @param long  $maxTimestamp Media taken earlier than this timestamp (default: now)
     *
     * @return mixed
     */
    public function searchMedia(
        $lat,
        $lng,
        $distance = 1000,
        $minTimestamp = null,
        $maxTimestamp = null
    )
    {
        return $this->_makeCall('media/search',
            array(
                'lat'           => $lat,
                'lng'           => $lng,
                'distance'      => $distance,
                'min_timestamp' => $minTimestamp,
                'max_timestamp' => $maxTimestamp
            )
        );
    }

    /**
     * Search for tags by name.
     *
     * @param string $name Valid tag name
     *
     * @return mixed
     */
    public function searchTags($name)
    {
        return $this->_makeCall('tags/search', array('q' => $name));
    }

    /**
     * Get info about a tag
     *
     * @param string $name Valid tag name
     *
     * @return mixed
     */
    public function getTag($name)
    {
        return $this->_makeCall('tags/' . $name);
    }

    /**
     * Get a recently tagged media.
     *
     * @param string $name  Valid tag name
     * @param int    $limit Limit of returned results
     *
     * @return mixed
     */
    public function getTagMedia(
        $name,
        $limit = 0
    )
    {
        $params = array();

        if ($limit > 0)
        {
            $params['count'] = $limit;
        }

        return $this->_makeCall('tags/' . $name . '/media/recent', $params);
    }

    /**
     * Get a list of users who have liked this media.
     *
     * @param int $id Instagram media ID
     *
     * @return mixed
     */
    public function getMediaLikes($id)
    {
        return $this->_makeCall('media/' . $id . '/likes');
    }

    /**
     * Get a list of comments for this media.
     *
     * @param int $id Instagram media ID
     *
     * @return mixed
     */
    public function getMediaComments($id)
    {
        return $this->_makeCall('media/' . $id . '/comments');
    }

    /**
     * Get information about a location.
     *
     * @param int $id Instagram location ID
     *
     * @return mixed
     */
    public function getLocation($id)
    {
        return $this->_makeCall('locations/' . $id);
    }

    /**
     * Get recent media from a given location.
     *
     * @param int $id Instagram location ID
     *
     * @return mixed
     */
    public function getLocationMedia($id)
    {
        return $this->_makeCall('locations/' . $id . '/media/recent');
    }

    /**
     * Get the OAuth data of a user by the returned callback code.
     *
     * @param string $code  OAuth2 code variable (after a successful login)
     * @param bool   $token If it's true, only the access token will be returned
     *
     * @return mixed
     */
    public function getOAuthToken(
        $code
    )
    {
        $apiData = array(
            'grant_type'    => 'authorization_code',
            'client_id'     => $this->getApiKey(),
            'client_secret' => $this->getApiSecret(),
            'redirect_uri'  => $this->getApiCallback(),
            'code'          => $code
        );

        $result = $this->_makeOAuthCall($apiData);
        
        return $result->access_token;
    }

    /**
     * The call operator.
     *
     * @param string $function API resource path
     * @param bool   $auth     Whether the function requires an access token
     * @param array  $params   Additional request parameters
     * @param string $method   Request type GET|POST
     *
     * @return mixed
     *
     * @throws \SocialDataPool\Infrastructure\Api\Instagram\Exception\InstagramException
     */
    protected function _makeCall(
        $function,
        $params = null,
        $method = 'GET'
    )
    {
        if (!isset($this->access_token))
        {
            throw new InstagramException("Error: _makeCall() | $function - This method requires an authenticated users access token."
            );
        }

        $authMethod = '?access_token=' . $this->getAccessToken();

        $paramString = null;

        if (isset($params) && is_array($params))
        {
            $paramString = '&' . http_build_query($params);
        }

        $apiCall = self::API_URL . $function . $authMethod . (('GET' === $method) ? $paramString : null);

        $headerData = array('Accept: application/json');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiCall);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        switch ($method)
        {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, count($params));
                curl_setopt($ch, CURLOPT_POSTFIELDS, ltrim($paramString, '&'));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        $jsonData = curl_exec($ch);
        if (!$jsonData)
        {
            throw new InstagramException('Error: _makeCall() - cURL error: ' . curl_error($ch));
        }

        curl_close($ch);
        return json_decode($jsonData);
    }

    /**
     * The OAuth call operator.
     *
     * @param array $apiData The post API data
     *
     * @return mixed
     *
     * @throws \SocialDataPool\Infrastructure\Api\Instagram\Exception\InstagramException
     */
    private function _makeOAuthCall($apiData)
    {
        $apiHost = self::API_OAUTH_TOKEN_URL;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiHost);
        curl_setopt($ch, CURLOPT_POST, count($apiData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        $jsonData = curl_exec($ch);

        if (!$jsonData)
        {
            throw new InstagramException('Error: _makeOAuthCall() - cURL error: ' . curl_error($ch));
        }

        curl_close($ch);

        return json_decode($jsonData);
    }

    /**
     * Access Token Setter.
     *
     * @param object|string $data
     *
     * @return void
     */
    public function setAccessToken($data)
    {
        $token = is_object($data) ? $data->access_token : $data;

        $this->access_token = $token;
    }

    /**
     * Access Token Getter.
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * API Key Getter
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->api_key;
    }

    /**
     * API Secret Getter.
     *
     * @return string
     */
    public function getApiSecret()
    {
        return $this->api_secret;
    }

    /**
     * API Callback URL Getter.
     *
     * @return string
     */
    public function getApiCallback()
    {
        return $this->callback_url;
    }
}
