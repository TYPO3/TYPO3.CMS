<?php
namespace TYPO3\CMS\Form\Tests\Unit\Filter;

/***************************************************************
*  Copyright notice
*
*  (c) 2012 Andreas Lappe <nd@kaeufli.ch>, kaeufli.ch
*
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
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Test case for CurrencyFilter
 *
 * @author Andreas Lappe <nd@kaeufli.ch>
 */
class CurrencyFilterTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	/**
	 * @var \TYPO3\CMS\Form\Filter\CurrencyFilter
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \TYPO3\CMS\Form\Filter\CurrencyFilter();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	public function validDataProvider() {
		return array(
			'1200 => 1.200,00' => array(array(1200, '.', ','), '1.200,00'),
			'0 => 0,00' => array(array(0, NULL, ','), '0,00'),
			'3333.33 => 3,333.33' => array(array(3333.33, ',', '.'), '3,333.33'),
			'1099.33 => 1 099,33' => array(array(1099.33, ' ', ','), '1 099,33')
		);
	}

	/**
	 * @test
	 * @dataProvider validDataProvider
	 */
	public function filterForVariousIntegerInputsReturnsFormattedCurrencyNotation($input, $expected) {
		$this->fixture->setThousandSeparator($input[1]);
		$this->fixture->setDecimalsPoint($input[2]);

		$this->assertSame(
			$expected,
			$this->fixture->filter($input[0])
		);
	}
}
?>