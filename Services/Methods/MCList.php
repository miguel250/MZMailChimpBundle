<?php

/*
 * This file is part of the MZ\MailChimpBundle
 *
 * (c) Miguel Perez <miguel@mlpz.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MZ\MailChimpBundle\Services\Methods;

use MZ\MailChimpBundle\Services\HttpClient;

class MCList extends HttpClient
{

    private $merge = null;
    private $emailType = 'html';
    private $doubleOptin = true;
    private $updateExisting = false;
    private $replaceInterests = true;
    private $sendWelcome = false;
    private $email;
    private $mergeVars = array();

    /**
     * Set mailchimp merge
     *
     * @param array $merge
     */
    public function setMerge(array $merge)
    {
        $this->merge = $merge;
    }

    /**
     * Set mailchimp email type
     *
     * @param string $emailType
     */
    public function setEmailType($emailType)
    {
        $this->emailType = $emailType;
    }

    /**
     * Set mailchimp double optin
     *
     * @param boolean $doubleOptin
     */
    public function setDoubleOption($doubleOptin)
    {
        $this->doubleOptin = $doubleOptin;
    }

    /**
     * Set mailchimp update existing
     *
     * @param boolean $updateExisting
     */
    public function setUpdateExisting($updateExisting)
    {
        $this->updateExisting = $updateExisting;
    }

    /**
     * Set mailchimp replace interests
     *
     * @param boolean $replaceInterests
     */
    public function setReplaceInterests($replaceInterests)
    {
        $this->replaceInterests = $replaceInterests;
    }

    /**
     * Set mailchimp send welcome
     *
     * @param boolean $sendWelcome
     */
    public function SendWelcome($sendWelcome)
    {
        $this->sendWelcome = $sendWelcome;
    }

    /**
     * Set mailchimp merge_vars
     * 
     * @param string $email
     * @param string $newEmail
     * @param string $groupings
     * @param string $optionIP
     * @param string $optinTime
     * @param array $mcLocation
     */
    public function MergeVars($email = null, $newEmail = null, $groupings = null, $optionIP = null, $optinTime = null, $mcLocation = null)
    {
    	$this->mergeVars['EMAIL'] = $email;
    	$this->mergeVars['NEW-EMAIL'] = $newEmail;
    	$this->mergeVars['GROUPINGS'] = $groupings;
    	$this->mergeVars['OPTIN_IP'] =  $optionIP;
    	$this->mergeVars['OPTIN_TIME'] = $optinTime;
    	$this->mergeVars['MC_LOCATION'] = $mcLocation;
    }
    
    /**
     * Set user email
     * 
     * @param string $email
     */
    
    public function setEmail($email) 
    {
    	$this->email = $email;
    }
    
    /**
     * Subscribe member to list
     *
     * @param string $email
     *
     * @return boolen
     */
    public function Subscribe($email = null)
    {
    	if(!empty($email)) {
    		$this->email = $email;
    	}
    	
        $payload = array('email_address' => $this->email,
            'merge_vars' => $this->merge,
            'email_type' => $this->emailType,
            'double_optin' => $this->doubleOptin,
            'update_existing' => $this->updateExisting,
            'replace_interests' => $this->replaceInterests,
            'send_welcome' => $this->sendWelcome,
        	 'merge_vars' => $this->mergeVars);

        $apiCall = 'listSubscribe';
        $data = $this->makeRequest($apiCall, $payload);
        $data = json_decode($data);

        return $data;
    }
    
    public function UpdateMember()
    {
    	$payload = array( 'email_address' => $this->email,
    			'merge_vars' => $this->mergeVars,
    			'email_type' => $this->emailType,);
    	
    	$apiCall = 'listUpdateMember';
    	$data = $this->makeRequest($apiCall, $payload);
    	$data = json_decode($data);
    	return $data;
    }

}