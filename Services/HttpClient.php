<?php

/*
 * This file is part of the MZ\MailChimpBundle
 *
 * (c) Miguel Perez <miguel@mlpz.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MZ\MailChimpBundle\Services;

use  Buzz\Browser,
     Buzz\Client\Curl;

/**
 * HTTP client
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
        $curl = new Curl();
        $curl->setOption(CURLOPT_USERAGENT, 'MZMailChimpBundle');
        $browser = new Browser($curl);
        $response = $browser->post($url, array(), http_build_query($payload));

        return $response->getContent();
    }

}
