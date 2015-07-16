<?php
/*
 * Copyright © 2015 Klaas Van Parys
 * 
 * This file is part of OGetIt.
 * 
 * OGetIt is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * OGetIt is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with OGetIt.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace OGetIt;

use OGetIt\Http\OGetIt_HttpRequest;
use OGetIt\CombatReport\OGetIt_CombatReport;
use OGetIt\HarvestReport\OGetIt_HarvestReport;
use OGetIt\SpyReport\OGetIt_SpyReport;

class OGetIt { 
	
	/**
	 * @var integer
	 */
	private $_universeID;
	
	/**
	 * @var string
	 */
	private $_community;
	
	/**
	 * @var string
	 * 
	 */
	private $_apikey;
	
	/**
	 * @var string
	 */
	private $_version;
	
	/**
	 * @var boolean
	 */
	private $_https = false;
	
	/**
	 * @param integer $universeID
	 * @param string $community
	 * @param string $version (optional)
	 */
	public function __construct($universeID, $community, $apikey, $version = 'v1') {
		
		$this->_universeID 	= $universeID;
		$this->_community 	= $community;
		$this->_apikey 		= $apikey;
		$this->_version 	= $version;
		
	}
	
	/**
	 * Use https to connect to the API
	 */
	public function useHttps() {
		
		$this->_https = true;
		
	}
	
	private function getApiData($type, $label, $key, $username = false, $password = false) {
		
		$url = OGetIt_Api::constructUrl($type, $this, array(
			'api_key' => $this->_apikey,
			$label => $key
		));
		
		return OGetIt_Api::getData($url, $username, $password); 
		
	}
	
	/**
	 * @param string $cr_api_key
	 */
	public function getCombatReport($cr_api_key, $username = false, $password = false) {
		
		$data = $this->getApiData(OGetIt_Api::TYPE_COMBATREPORT, 'cr_id', $cr_api_key, $username, $password);
				
		return $data === false ? $data : OGetIt_CombatReport::createCombatReport($data);
		
	}
	
	/**
	 * @param string $rr_api_key
	 */
	public function getHarvestReport($rr_api_key, $username = false, $password = false) {
		
		$data = $this->getApiData(OGetIt_Api::TYPE_HARVESTREPORT, 'rr_id', $rr_api_key, $username, $password);
		
		return $data === false ? $data : OGetIt_HarvestReport::createHarvestReport($data);
		
	}
	
	/**
	 * @param string $sr_api_key
	 */
	public function getSpyReport($sr_api_key, $username = false, $password = false) {
		
		$data = $this->getApiData(OGetIt_Api::TYPE_SPYREPORT, 'sr_id', $sr_api_key, $username, $password);
				
		return $data === false ? $data : OGetIt_SpyReport::createSpyReport($data);
		
	}
	
	/**
	 * @return integer
	 */
	public function getUniverseID() {
		
		return $this->_universeID;
		
	}
	
	/**
	 * @return string
	 */
	public function getCommunity() {
		
		return $this->_community;
		
	}
	
	/**
	 * @return string
	 */
	public function getApiVersion() {
		
		return $this->_version;
		
	}
	
	/**
	 * @return boolean
	 */
	public function usesHttps() {
		
		return $this->_https;
		
	}
		
}