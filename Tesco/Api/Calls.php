<?php
/**
 * Example Calls for the Tesco API.
 * 
 * @author   Colin Oakley <hello@htmlandbacon.com>
 * @license  MIT License
 * @version  0.1
 */

namespace Tesco\Api;
include ('Client.php');

/**
 * example set of calls based on current API - 01 December 2014
 */
class Calls extends Client
{
	/**
	 * Find out more about tesco api http://www.tescolabs.com/
	 */
		public $sessionkey = '';
		public $developerkey ='';
		public $applicationkey='';
 
    /**
     * Returns session object - this will let you get the session id for future calls 
     * @return object
     */
	public function getSessionKey()
	{
		$keys = array("developerkey" => $this->developerkey,"applicationkey" => $this->applicationkey);
  		return $this->makeRequest('LOGIN','',$keys);
	}
    
    /**
     * Returns list of product details
     * @param  integer  - 	specifeid page number i.e 
     * @param  integer 	-	page_size 
     * @return object
     */
	public function getProducts($searchtext=null, $page=1)
	{
		$keys = array('sessionkey' => $this->sessionkey);
		$args = array('searchtext' => $searchtext);
		$args['page'] = $page;
  		return $this->makeRequest('PRODUCTSEARCH',$args,$keys);
	}
}