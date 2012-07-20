<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Felix Kopp <felix-source@phorax.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Demand filter for listings
 *
 * @author Felix Kopp <felix-source@phorax.com>
 * @package TYPO3
 * @subpackage beuser
 */
class Tx_Beuser_Domain_Model_Demand extends Tx_Extbase_DomainObject_AbstractEntity {

	const ALL = 0;

	const USERTYPE_ADMINONLY = 1;
	const USERTYPE_USERONLY = 2;

	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;

	const LOGIN_SOME = 1;
	const LOGIN_NONE = 2;

	/**
	 * @var string
	 */
	protected $username = '';

	/**
	 * @var int
	 */
	protected $usertype = Tx_Beuser_Domain_Model_Demand::ALL;

	/**
	 * @var int
	 */
	protected $status = Tx_Beuser_Domain_Model_Demand::ALL;

	/**
	 * @var int
	 */
	protected $logins = 0;

	/**
	 * @param string $username
	 * @return void
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param int $usertype
	 * @return void
	 */
	public function setUsertype($usertype) {
		$this->usertype = $usertype;
	}

	/**
	 * @return int
	 */
	public function getUsertype() {
		return $this->usertype;
	}

	/**
	 * @param int $status
	 * @return void
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * @return int
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param int $logins
	 * @return void
	 */
	public function setLogins($logins) {
		$this->logins = $logins;
	}

	/**
	 * @return int
	 */
	public function getLogins() {
		return $this->logins;
	}

}

?>