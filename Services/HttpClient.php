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

class HttpClient
{
	protected $dataCenter;
	protected $apiKey;
	protected $listId;

	/**
	 * Initializes Http client
	 *
	 * @param string $apiKey
	 * @param string $listId
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
	 * @return string
	 */
	protected function makeRequest($apiCall, $payload, $export = false)
	{
		$payload['apikey'] = $this->apiKey;
		$payload['id'] = $this->listId;

		if($export) {
			$url = 'https://'. $this->dataCenter . '.api.mailchimp.com/' . $apiCall;
		}else {
			$url = 'https://'. $this->dataCenter . '.api.mailchimp.com/1.3/?method=' . $apiCall;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "MZMailChimpBundle");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));

		$result = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($result);

		if (!empty($data->error)) {
			throw new \Exception("$data->code $data->error");
		} else {
			return $result;
		}
	}

}