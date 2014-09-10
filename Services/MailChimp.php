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

        $key = preg_split("/-/", $this->apiKey);
        
        if($ssl) {
            $this->dataCenter ='https://' . $key[1] . '.api.mailchimp.com/';
        }else {
            $this->dataCenter ='http://' . $key[1] . '.api.mailchimp.com/';
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
     * get datacenter
     *
     * @return string $datacenter
     */
    public function getDatacenter()
    {
        return $this->dataCenter;
    }

    /**
     * Get List Methods
     *
     * @return Methods\MCList
     */
    public function getList()
    {
        return new Methods\MCList($this->apiKey, $this->listId, $this->dataCenter);
    }

    /**
     * Get List Methods
     *
     * @return Methods\MCCampaign
     */
    public function getCampaign()
    {
        return new Methods\MCCampaign($this->apiKey, $this->listId, $this->dataCenter);
    }

    /**
     * Get Export API
     *
     * @return Methods\MCExport
     */
    public function getExport()
    {
        return new Methods\MCExport($this->apiKey, $this->listId, $this->dataCenter);
    }
    
    /**
     * Get Ecommerce Methods
     *
     * @return Methods\MCEcommerce
     */
    public function getEcommerce()
    {
        return new Methods\MCEcommerce($this->apiKey, $this->listId, $this->dataCenter);
    }
}
