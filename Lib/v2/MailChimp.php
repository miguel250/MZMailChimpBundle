<?php

/*
 * This file is part of the MZ\MailChimpBundle
 *
 * (c) Miguel Perez <miguel@mlpz.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MZ\MailChimpBundle\Lib\v2;

/**
 * Mailchimp
 *
 * @author Miguel Perez <miguel@mlpz.mp>
 */
class MailChimp 
{

    private $apiKey;
    private $listId;
    private $dataCenter;

    /**
     * Initializes MailChimp
     *
     * @param string $apiKey Mailchimp api key
     * @param string $listId Default mailing list id
     */
    public function __construct($apiKey, $listId, $ssl = true)
    {
        $this->apiKey = $apiKey;
        $this->listId = $listId;

        $key = $this->setDataCenter($apiKey);
        
        if($ssl) {
            $this->dataCenter ='https://' . $key[1] . '.api.mailchimp.com/2.0/';
        }else {
            $this->dataCenter ='http://' . $key[1] . '.api.mailchimp.com/2.0/';
        }

        if (!function_exists('curl_init')) {
            throw new \Exception('This bundle needs the cURL PHP extension.');
        }
    }

    /**
     * Get Mailchimp api key
     *
     * @return string
     */
    public function getAPIkey()
    {
        return $this->apiKey;
    }

    /**
     * Set mailing list id
     *
     * @param string $listId mailing list id
     */
    public function setListID($listId)
    {
        $this->listId = $listId;
    }

    /**
     * get mailing list id
     *
     * @return string $listId
     */
    public function getListID()
    {
        return $this->listId;
    }

    /**
     * Set datacenter
     *
     * @param string $apiKey API key
     */
    private function setDataCenter($apiKey){
        $this->dataCenter = preg_split("/-/", $apiKey);
    }
    
    /**
     * get datacenter
     *
     * @return string $dataCenter
     */
    public function getDataCenter()
    {
        return $this->dataCenter;
    }
}
