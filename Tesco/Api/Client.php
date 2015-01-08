<?php
/**
 * PHP wrapper for the Tesco API.
 * 
 * @author   Colin Oakley <hello@htmlandbacon.com>
 * @license  MIT License
 * @version  0.1
 */

namespace Tesco\Api;

/**
 * The core Tesco API PHP wrapper class.
 */
class Client
{
    /**
     * Default options for cURL requests.
     *
     * @var array
     */
    public static $CURL_OPTS = array(
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_USERAGENT      => 'tesco-api-php-wrapper'
    );
    
    /**
     * The API endpoints.
     *
     * @var string
     */
    protected $api_url = 'https://secure.techfortesco.com/tescolabsapi/restservice.aspx?command=';

    /**
     * Makes a HTTP request.
     * This method can be overriden by extending classes if required.
     *
     * @param  string $command
     * @param  array  $params
     * @param  array $keys
     * @return object
     * @throws Exception
     */
    public function makeRequest($command, $params = array(),$keys = array())
    {
        $ch = curl_init();
        $options = self::$CURL_OPTS;
        $options[CURLOPT_URL] = $this->api_url.$command."&email=&password=";
        if (!empty($keys)) {
            $options[CURLOPT_URL].= '&' . http_build_query($keys, null, '&');
        }
        if (!empty($params)) {
            $options[CURLOPT_URL].= '&' . http_build_query($params, null, '&');
        }
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($result === false) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }
        $result = json_decode($result);
        if (isset($result->message)) {
            throw new Exception($result->message, $status);
        }
        return $result;
    }
}