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

class MailChimp
{

    private $apiKey;
    private $listId;

    /**
     * Initializes MailChimp
     *
     * @param string $apiKey
     * @param string $listId
     */
    public function __construct($apiKey, $listId)
    {
        $this->apiKey = $apiKey;
        $this->listId = $listId;

        if (!function_exists('curl_init')) {
            throw new Exception('This bundle needs the cURL PHP extension.');
        }
    }

    /**
     * Set mailing list id
     *
     * @param string $listId
     */
    public function setListID($listId)
    {
        $this->listId = $listId;
    }

    /**
     * Get List Methods
     *
     * @return API\MCList
     */
    public function getList()
    {
        return new Methods\MCList($this->apiKey,  $this->listId);
    }
}