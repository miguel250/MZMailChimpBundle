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

class MCCampaign extends HttpClient
{

	private $type;
	private $subject;
	private $fromEmail;
	private $fromName;
	private $html;
	private $text;
	private $toName = null;
	private $templateId = null;
	private $galleryTemplateId = null;
	private $baseTemplateId = null;
	private $folderId = null;
	private $tracking = null;
	private $title = null;
	private $authenticate = false;
	private $analytics = null;
	private $autoFooter = false;
	private $inlineCss = false;
	private $generateText = false;
	private $autoTweet = false;
	private $autoFBPost = null;
	private $fbComments = true;
	private $timeWarp = false;
	private $ecomm360 = false;
	
	/**
	 * The Campaign Type
	 * 
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}
	
	/**
	 * The subject line for your campaign
	 *
	 * @param string $subject
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}
	
	/**
	 * The From email address for your campaign
	 *
	 * @param string $fromEmail
	 */
	Public function setFromEmail($fromEmail)
	{
		$this->fromEmail = $fromEmail;
	}
	
	
	/**
	 * The From name for your campaign
	 *
	 * @param string $fromName
	 */
	public function setFromName($fromName)
	{
		$this->fromName = $fromName;
	}
		
	/**
	 * Campaign html
	 *
	 * @param string $html
	 */
	public function setHTML($html)
	{
		$this->html = $html;
	}
	
	/**
	 * Campaign text
	 *
	 * @param string $text
	 */
	public function setText($text)
	{
		$this->text = $test;
	}

	/**
	 * The to name for your campaign
	 *
	 * @param string $toName
	 */
	Public function setToName($toName)
	{
		$this->toName = $toName;
	}
	
	/**
	 * User created template id
	 *
	 * @param integer $templateId
	 */
	public function setTemplateId($templateId)
	{
		$this->templateId = $templateId;
	}
	
	/**
	 * Gallery template id
	 *
	 * @param integer $galleryTemplateId
	 */
	public function setGalleryTemplateId($galleryTemplateId)
	{
	   $this->galleryTemplateId = $galleryTemplateId;
	}
	
	/**
	 * Base template id
	 *
	 * @param integer $baseTemplateId
	 */
	public function setBaseTemplateId($baseTemplateId)
	{
		$this->baseTemplateId = $baseTemplateId;
	}
	
	/**
	 * Folder id
	 * 
	 * @param integer $folderId
	 */
	public function setFolderId($folderId)
	{
		$this->folderId = $folderId;
	}
	
	
	/**
	 * Which recipient actions will be tracked
	 * 
	 * @param boolean $opens
	 * @param boolean $htmlClicks
	 * @param boolean $textClicks
	 */
	public function setTracking($opens = true, $htmlClicks = false, $textClicks = false )
	{
		$this->tracking['opens'] = $opens;
		$this->tracking['html_clicks'] = $htmlClicks;
		$this->tracking['text_clicks'] = $textClicks;
	}
	
	/**
	 * Internal name to use for this campaign
	 * 
	 * @param string $title
	 */
	public function SetTitle($title)
	{
		$this->title = $title;
	}
	
	/**
	 * Enable authenticate
	 */
	public function setAuthenticate()
	{
		$this->authenticate = true;
	}

	/**
	 * Set analytics
	 * 
	 * @param array $analytics
	 */
	public function setAnalytics($analytics)
	{
		$this->analytics = $analytics;
	}

	/**
	 * Enable auto footer
	 */
	public function SetAutoFooter()
	{
		$this->autoFooter = true;
	}
	
	/**
	 * Enable inlinecss
	 * 
	 * @param boolean $inlineCss
	 */
	public function setInlineCss($inlineCss)
	{
		$this->inlineCss = $inlineCss;
	}
	
	/**
	 * Enable genarate text
	 * 
	 * @param boolean $generateText
	 */
	public function setGenerateText($generateText)
	{
		$this->generateText = $generateText;
	}
	
	/**
	 * Enable auto tweet
	 * 
	 * @param boolean $autoTweet
	 */
	public function setAutoTweet($autoTweet)
	{
		$this->autoTweet = $autoTweet;
	}
	
	/**
	 * Auto post to facebook page
	 * 
	 * @param array $autoFBPost
	 */
	public function setAutoFBPost($autoFBPost)
	{
		$this->autoFBPost = $autoFBPost;
	}
	
	/**
	 * Enable Facebook comments
	 * 
	 * @param boolean $fbComments
	 */
	public function setFbComments($fbComments)
	{
		$this->fbComments = $fbComments;
	}
	
	/**
	 * Enable time warp
	 * 
	 * @param boolean $timeWarp
	 */
	public function setTimeWarp($timeWarp)
	{
		$this->timeWarp = $timeWarp;
	}
	
	/**
	 * Enable Ecommerce360 tracking
	 * 
	 * @param boolean $ecomm360
	 */
	public function setEcomm360($ecomm360)
	{
		$this->ecomm360 = $ecomm360;
	}

	/**
	 * Create options
	 * 
	 * @return array
	 */
	private function Options()
	{
		$option = array('subject' => $this->subject,
				        'list_id' => $this->listId,
				        'from_email' => $this->fromEmail,
				        'from_name'  => $this->fromName,
				        'template_id' => $this->templateId,
				        'gallery_template_id' => $this->galleryTemplateId,
				        'base_template_id'  => $this->baseTemplateId,
				        'folder_id'  => $this->folderId,
				        'tracking'  => $this->tracking,
				        'title'     => $this->title,
				        'authenticate' => $this->authenticate,
				        'analytics' => $this->analytics,
			            'auto_footer' => $this->autoFooter,
				        'inline_css' => $this->inlineCss,
				        'generate_text' => $this->generateText,
				        'auto_tweet' => $this->autoTweet,
				        'auto_fb_post' => $this->autoFBPost,
				        'fb_comments' => $this->fbComments,
				        'timewarp' => $this->timeWarp,
				        'ecomm360' => $this->ecomm360);
		return $option;
	}

	/**
	 * Create content 
	 * 
	 * @return array
	 */
	private function Content()
	{
		$content = array('html' => $this->html, 'text'=> $this->text);
		return $content;
	}
	
	/**
	 * Create campaign
	 * 
	 * @return integer
	 */
	public function Create()
	{
		$payload = array( 'type' => $this->type,
				'options' => $this->Options(),
				'content' => $this->Content());
	
		$apiCall = 'campaignCreate';
		$data = $this->makeRequest($apiCall, $payload);
		$data = json_decode($data);
		return $data;
	}

	/**
	 * Send test compaign
	 *
	 * @param string $campaignId
	 * @param array  $emails
	 * @return boolean
	 */
	public function SendTest($campaignId, $emails)
	{
		$payload = array( 'cid' => $campaignId,
				          'test_emails' => $emails);
		
		$apiCall = 'campaignSendTest';
		$data = $this->makeRequest($apiCall, $payload);
		$data = json_decode($data);
		return $data;
	}
	
	/**
	 * Send compaign
	 * 
	 * @param string $campaignId
	 * @return boolean
	 */
	public function SendNow($campaignId)
	{
		$payload = array( 'cid' => $campaignId);
				
		$apiCall = 'campaignSendNow';
		$data = $this->makeRequest($apiCall, $payload);
		$data = json_decode($data);
		return $data;
	}
}