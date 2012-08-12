<?php
/***************************************************************
* Copyright notice
*
* (c) 2012 Steffen Müller (typo3@t3node.com)
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
 * Testcase for the memoryPeakUsage log processor.
 *
 * @author Steffen Müller <typo3@t3node.com>
 * @package TYPO3
 * @subpackage t3lib
 */
class t3lib_log_processor_memoryPeakUsageTest extends tx_phpunit_testcase {

	/**
	 * Tests if memory usage data was added to LogRecord
	 *
	 * @return void
	 * @test
	 */
	public function addsMemoryPeakUsageDataToLogRecord() {
		$logRecord = new t3lib_log_Record('test.core.log', t3lib_log_Level::DEBUG, 'test');
		$processor = new t3lib_log_processor_MemoryPeakUsage();

		$logRecord = $processor->processLogRecord($logRecord);

		$this->assertArrayHasKey('memoryPeakUsage', $logRecord['data']);
	}

}

?>