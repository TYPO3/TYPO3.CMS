<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Andreas Wolf <andreas.wolf@ikt-werk.de>
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
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * Testcase for the FAL driver registry.
 *
 * @author Andreas Wolf <andreas.wolf@ikt-werk.de>
 * @package TYPO3
 * @subpackage t3lib
 */
class t3lib_file_Driver_DriverRegistryTest extends Tx_Phpunit_TestCase {

	/**
	 * @var boolean Enable backup of global and system variables
	 */
	protected $backupGlobals = TRUE;

	/**
	 * Exclude TYPO3_DB from backup/ restore of $GLOBALS
	 * because resource types cannot be handled during serializing
	 *
	 * @var array
	 */
	protected $backupGlobalsBlacklist = array('TYPO3_DB');

	/**
	 * @var \TYPO3\CMS\Core\Resource\Driver\DriverRegistry
	 */
	private $fixture;

	public function setUp() {
		$this->initializeFixture();
	}

	protected function initializeFixture() {
		$this->fixture = new \TYPO3\CMS\Core\Resource\Driver\DriverRegistry();
	}

	/**
	 * @test
	 */
	public function registeredDriverClassesCanBeRetrieved() {
		$className = $this->getMockClass('TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver');
		$this->fixture->registerDriverClass($className, 'foobar');
		$returnedClassName = $this->fixture->getDriverClass('foobar');
		$this->assertEquals($className, $returnedClassName);
	}

	/**
	 * @test
	 */
	public function registerDriverClassThrowsExceptionIfClassDoesNotExist() {
		$this->setExpectedException('InvalidArgumentException', '', 1314979197);
		$this->fixture->registerDriverClass(uniqid());
	}

	/**
	 * @test
	 */
	public function registerDriverClassThrowsExceptionIfShortnameIsAlreadyTaken() {
		$this->setExpectedException('InvalidArgumentException', '', 1314979451);
		$className = $this->getMockClass('TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver');
		$this->fixture->registerDriverClass($className, 'foobar');
		$this->fixture->registerDriverClass($className, 'foobar');
	}

	/**
	 * @test
	 */
	public function getDriverClassThrowsExceptionIfClassIsNotRegistered() {
		$this->setExpectedException('InvalidArgumentException', '', 1314085990);
		$this->fixture->getDriverClass(uniqid());
	}

	/**
	 * @test
	 */
	public function getDriverClassAcceptsClassNameIfClassIsRegistered() {
		$className = $this->getMockClass('TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver');
		$this->fixture->registerDriverClass($className, 'foobar');
		$this->assertEquals($className, $this->fixture->getDriverClass($className));
	}

	/**
	 * @test
	 */
	public function driverRegistryIsInitializedWithPreconfiguredDrivers() {
		$className = $this->getMockClass('TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver');
		$shortName = uniqid();
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['registeredDrivers'] = array(
			$shortName => array(
				'class' => $className
			)
		);
		$this->initializeFixture();
		$this->assertEquals($className, $this->fixture->getDriverClass($shortName));
	}

	/**
	 * @test
	 */
	public function driverExistsReturnsTrueForAllExistingDrivers() {
		$className = $this->getMockClass('TYPO3\\CMS\\Core\\Resource\\Driver\\AbstractDriver');
		$shortName = uniqid();
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['registeredDrivers'] = array(
			$shortName => array(
				'class' => $className
			)
		);
		$this->initializeFixture();
		$this->assertTrue($this->fixture->driverExists($shortName));
		$this->assertFalse($this->fixture->driverExists(uniqid()));
	}

	/**
	 * @test
	 */
	public function driverExistsReturnsFalseIfDriverDoesNotExist() {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['registeredDrivers'] = array(
		);
		$this->initializeFixture();
		$this->assertFalse($this->fixture->driverExists(uniqid()));
	}

}

?>