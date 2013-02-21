<?php

/*
 * This file is part of the MZ\MailChimpBundle
 *
 * (c) Joona Savolainen <joona.savolainen@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MZ\MailChimpBundle\Services\Methods;

use MZ\MailChimpBundle\Services\HttpClient;

/**
 * Mailchimp Ecommerce methods
 *
 * @author Joona Savolainen <joona.savolainen@gmail.com>
 * @link   http://apidocs.mailchimp.com/api/1.3/#ecommerce
 */
class MCEcommerce extends HttpClient
{
    private $order_id;
    private $total = 0;
    private $order_date;
    private $shipping;
    private $tax;
    private $store_id;
    private $store_name;
    private $campaign_id;
    private $items = array();
    
    /**
     * Set Order Id
     * 
     * @param integer $order_id 
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * Get Order Id
     * 
     * @return integer
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set total value of the Order
     * 
     * @param double $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * Get total value of the Order
     * 
     * @return double
     */
    public function getTotal()
    {
        return $this->total;
    }
    
    /**
     * Set date of the Order (optional)
     * 
     * @param string $date 
     */
    public function setOrderDate($date)
    {
        $this->order_date = $date;
    }
    
    /**
     * Get date of the Order
     * 
     * @return string
     */
    public function getOrderDate()
    {
        return $this->order_date;
    }
    
    /**
     * Set amount of shipping fees (optional)
     * 
     * @param double $shipping 
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }
    
    /**
     * Get amount of shipping fees
     * 
     * @return double
     */
    public function getShipping()
    {
        return $this->shipping;
    }
    
    /**
     * Set amount of taxes (optional)
     * 
     * @param double $tax 
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }
    
    /**
     * Get amount of taxes
     * 
     * @return double
     */
    public function getTax()
    {
        return $this->tax;
    }
    
    /**
     * Set Store Id of the Order
     * 
     * @param string $id 
     */
    public function setStoreId($id)
    {
        $this->store_id = $id;
    }

    /**
     * Get Store Id of the Order
     * 
     * @return double
     */
    public function getStoreId()
    {
        return $this->store_id;
    }
    
    /**
     * Set Store name of the Order (optional)
     * 
     * @param string $name 
     */
    public function setStoreName($name)
    {
        $this->store_name = $name;
    }

    /**
     * Get Store name of the Order
     * 
     * @return string
     */
    public function getStoreName()
    {
        return $this->store_name;
    }
    
    /**
     * Set MailChimp Campaign Id (mc_cid) of the Order (optional)
     * 
     * @param string $campaign_id 
     */
    public function setCampaignId($campaign_id)
    {
        $this->campaign_id = $campaign_id;
    }
    
    /**
     * Get MailChimp Campaign Id of the Order
     * 
     * @return type 
     */
    public function getCampaignId()
    {
        return $this->campaign_id;
    }

    /**
     * Adds item to the Order
     *
     * @param integer $product_id Id Of the item
     * @param string $product_name Name of the item
     * @param integer $category_id Category Id of the item
     * @param string $category_name Category Name of the item
     * @param integer $qty Item quantity
     * @param double $cost Price of the Item
     * @param string|null $sku SKU of the Item (optional)
     */
    public function addItem($product_id, $product_name, $category_id, $category_name, $qty, $cost, $sku = null)
    {
        $item = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'category_id' => $category_id,
            'category_name' => $category_name,
            'qty' => $qty,
            'cost' => $cost
        );
        
        if($sku) {
            $item['sku'] = $sku;
        }
        
        $this->items[] = $item;
    }
    
    /**
     * Adds new Ecommerce Order
     * 
     * @param string|null $email Email of the subscriber
     * @param string|null $email_id Email Id of the subscriber
     * @return mixed 
     */
    public function addOrder($email = null, $email_id = null)
    {
        $order = array(
            'id' => $this->order_id,
            'total' => $this->total,
            'store_id' => $this->store_id,
            'items' => $this->items
        );
        
        if($email_id) {
            $order['email_id'] = $email_id;            
        }
        else if($email) {
            $order['email'] = $email;            
        }
        else {
            throw new \Exception("Either email_id or email must be provided");
        }
        
        if($this->order_date) {
            $order['order_date'] = $this->order_date;
        }
        if($this->shipping) {
            $order['shipping'] = $this->shipping;
        }
        if($this->tax) {
            $order['tax'] = $this->tax;
        }
        if($this->store_name) {
            $order['store_name'] = $this->store_name;
        }
        if($this->campaign_id) {
            $order['campaign_id'] = $this->campaign_id;
        }

        $payload = array('order' => $order);
        
        $apiCall = 'ecommOrderAdd';
        $data = $this->makeRequest($apiCall, $payload);
        $data = json_decode($data);

        return $data;
    }
    
    /**
     * Deletes Ecommerge Order
     * 
     * @param string $store_id
     * @param string $order_id
     * @return mixed
     */
    public function deleteOrder($store_id, $order_id)
    {
        $payload = array('store_id' => $store_id, 'order_id' => $order_id);
        
        $apiCall = 'ecommOrderDel';
        $data = $this->makeRequest($apiCall, $payload);
        $data = json_decode($data);

        return $data;        
    }
    
    /**
     * Retrieves Ecommerce Orders for the account
     * 
     * @param integer $start The page number to start at
     * @param integer $limit Result limit (max. 500)
     * @param \DateTime|null $since Get orders since this time
     * @return mixed
     */
    public function getOrders($start = 0, $limit = 100, \DateTime $since = null)
    {
        $payload = array('start' => $start, 'limit' => $limit);
        
        if($since) {
            $since->setTimezone(new \DateTimeZone('Etc/GMT'));
            $payload['since'] = $since->format('Y-m-d H:i:s');
        }
        
        $apiCall = 'ecommOrders';
        $data = $this->makeRequest($apiCall, $payload);
        $data = json_decode($data);

        return $data;        
    }
}
