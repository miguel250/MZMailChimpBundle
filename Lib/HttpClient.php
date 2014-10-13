<?php

/*
 * This file is part of the MZ\MailChimpBundle
 *
 * (c) Miguel Perez <miguel@mlpz.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MZ\MailChimpBundle\Lib;

Use \Curl;

/**
 * HTTP Client
 *
 * @author Miguel Perez <miguel@mlpz.mp>
 */
class HttpClient
{
    protected $dataCenter;
    protected $apiKey;
    protected $listId;

    /**
     * Initializes Http client
     *
     * @param string $apiKey     mailchimp api key
     * @param string $listId     mailing list id
     * @param string $dataCenter mailchimp datacenter
     */
    public function __construct($apiKey, $listId, $dataCenter)
    {
        $this->apiKey = $apiKey;
        $this->listId = $listId;
        $this->dataCenter = $dataCenter;
    }

    /**
     * Send API request to mailchimp
     * 
     * @param string  $apiCall mailchimp method
     * @param string  $payload Request information
     * @param boolean $export  mailchimp export api
     * 
     * @return json
     */
    protected function makeRequest($apiCall, $payload, $export = false)
    {
        $payload['apikey'] = $this->apiKey;
        $payload['id'] = $this->listId;

        if ($export) {
            $url = $this->dataCenter . $apiCall;
        } else {
            $url = $this->dataCenter . '1.3/?method=' . $apiCall;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "MZMailChimpBundle");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        
        $result = curl_exec($ch);
        curl_close($ch);

        var_dump($result);

        return $result;
    }

}
