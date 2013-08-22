<?php
namespace TYPO3\CMS\Core\Tests;

/***************************************************************
 * Copyright notice
 *
 * (c) 2013 Christian Kuhn <lolli@schwarzbu.ch>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Base test case class for functional tests, all TYPO3 CMS
 * functional tests should extend from this class!
 *
 * If functional tests need additional setUp() and tearDown() code,
 * they *must* call parent::setUp() and parent::tearDown() to properly
 * set up and destroy the test system.
 *
 * The functional test system creates a full new TYPO3 CMS instance
 * within typo3temp/ of the base system and then bootstraps this TYPO3 instance.
 * This abstract class takes care of creating this instance with its
 * folder structure and a LocalConfiguration, creates an own database
 * for each test run and imports tables of loaded extensions.
 *
 * Functional tests must be run standalone (calling native phpunit
 * directly) and can not be executed by eg. the ext:phpunit backend module.
 * Additionally, the script must be called from the document root
 * of the instance, otherwise path calculation is not successful.
 *
 * Call whole functional test suite, example:
 * - cd /var/www/t3master/foo  # Document root of CMS instance, here is index.php of frontend
 * - ./typo3conf/ext/phpunit/Composer/vendor/bin/phpunit -c typo3/sysext/core/Build/FunctionalTests.xml
 *
 * Call single test case, example:
 * - cd /var/www/t3master/foo  # Document root of CMS instance, here is index.php of frontend
 * - ./typo3conf/ext/phpunit/Composer/vendor/bin/phpunit \
 *     --process-isolation \
 *     --bootstrap typo3/sysext/core/Build/FunctionalTestsBootstrap.php \
 *     typo3/sysext/core/Tests/Functional/Functional/FunctionalTestCaseTest.php
 */
abstract class FunctionalTestCase extends BaseTestCase {

	/**
	 * This influences the bootstrap that is done.
	 *
	 * @var string "frontend", "backend" or "cli"
	 */
	protected $environment = 'backend';

	/**
	 * Core extensions to load.
	 *
	 * If the test case needs additional core extensions as requirement,
	 * they can be noted here and will be added to LocalConfiguration
	 * extension list and ext_tables.sql of those extensions will be applied.
	 *
	 * This property will stay empty in this abstract, so it is possible
	 * to just overwrite it in extending classes. Extensions noted here will
	 * be loaded for every test of a test case and it is not possible to change
	 * the list of loaded extensions between single tests of a test case.
	 *
	 * Required core extensions like core, cms, extbase and so on are loaded
	 * automatically, so there is no need to add them here. See constant
	 * REQUIRED_EXTENSIONS for a list of automatically loaded extensions.
	 *
	 * @var array
	 */
	protected $coreExtensionsToLoad = array();

	/**
	 * Array of test/fixture extensions paths that should be loaded for a test.
	 *
	 * This property will stay empty in this abstract, so it is possible
	 * to just overwrite it in extending classes. Extensions noted here will
	 * be loaded for every test of a test case and it is not possible to change
	 * the list of loaded extensions between single tests of a test case.
	 *
	 * Given path is expected to be relative to your document root, example:
	 *
	 * array(
	 *   'typo3conf/ext/some_extension/Tests/Functional/Fixtures/Extensions/test_extension',
	 *   'typo3conf/ext/base_extension',
	 * );
	 *
	 * Extensions in this array are linked to the test instance, loaded
	 * and their ext_tables.sql will be applied.
	 *
	 * @var array
	 */
	protected $testExtensionsToLoad = array();

	/**
	 * Private utility class used in setUp() and tearDown(). Do NOT use in test cases!
	 *
	 * @var \TYPO3\CMS\Core\Tests\FunctionalTestCaseBootstrapUtility
	 */
	private $bootstrapUtility = NULL;

	/**
	 * Set up creates a test instance and database.
	 *
	 * This method should be called with parent::setUp() in your test cases!
	 *
	 * @return void
	 */
	public function setUp() {
		if (!defined('ORIGINAL_ROOT')) {
			$this->markTestSkipped('Functional tests must be called through phpunit on CLI');
		}
		$this->defineEnvironmentConstants();
		$this->bootstrapUtility = new FunctionalTestCaseBootstrapUtility();
		$this->bootstrapUtility->setUp(
			get_class($this),
			$this->coreExtensionsToLoad,
			$this->testExtensionsToLoad
		);
	}

	/**
	 * Tear down destroys the instance and database.
	 *
	 * This method should be called with parent::tearDown() in your test cases!
	 *
	 * @throws Exception
	 * @return void
	 */
	public function tearDown() {
		if (!($this->bootstrapUtility instanceof FunctionalTestCaseBootstrapUtility)) {
			throw new Exception(
				'Bootstrap utility not set. Is parent::setUp() called in setUp()?',
				1376826527
			);
		}
		$this->bootstrapUtility->tearDown();
	}

	/**
	 * Get DatabaseConnection instance - $GLOBALS['TYPO3_DB']
	 *
	 * This method should be used instead of direct access to
	 * $GLOBALS['TYPO3_DB'] for easy IDE auto completion.
	 *
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	protected function getDatabase() {
		return $GLOBALS['TYPO3_DB'];
	}

	/**
	 * Imports a data set represented as XML into the test database,
	 *
	 * @param string $path Absolute path to the XML file containing the data set to load
	 * @return void
	 * @throws Exception
	 */
	protected function importDataSet($path) {
		if (!is_file($path)) {
			throw new Exception(
				'Fixture file ' . $path . ' not found',
				1376746261
			);
		}

		$database = $this->getDatabase();

		$xml = simplexml_load_file($path);
		$foreignKeys = array();

		/** @var $table \SimpleXMLElement */
		foreach ($xml->children() as $table) {
			$insertArray = array();

			/** @var $column \SimpleXMLElement */
			foreach ($table->children() as $column) {
				$columnName = $column->getName();
				$columnValue = NULL;

				if (isset($column['ref'])) {
					list($tableName, $elementId) = explode('#', $column['ref']);
					$columnValue = $foreignKeys[$tableName][$elementId];
				} elseif (isset($column['is-NULL']) && ($column['is-NULL'] === 'yes')) {
					$columnValue = NULL;
				} else {
					$columnValue = $table->$columnName;
				}

				$insertArray[$columnName] = $columnValue;
			}

			$tableName = $table->getName();
			$database->exec_INSERTquery($tableName, $insertArray);

			if (isset($table['id'])) {
				$elementId = (string) $table['id'];
				$foreignKeys[$tableName][$elementId] = $database->sql_insert_id();
			}
		}
	}

	/**
	 * Define constants based on environment that should be bootstrapped.
	 *
	 * @return void
	 * @throws Exception
	 */
	private function defineEnvironmentConstants() {
		switch ($this->environment) {
			case 'frontend':
				define('TYPO3_MODE', 'FE');
				break;
			case 'backend':
				define('TYPO3_MODE', 'BE');
				break;
			case 'cli':
				define('TYPO3_MODE', 'BE');
				define('TYPO3_cliMode', TRUE);
				break;
			default:
				throw new Exception(
					'Environment must be set to "frontend", "backend" or "cli"',
					1376852297
				);
		}
	}
}
?>