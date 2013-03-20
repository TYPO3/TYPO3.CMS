<?php
namespace TYPO3\CMS\Backend\Form;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 1999-2013 Kasper Skårhøj (kasperYYYY@typo3.com)
 *  (c) 2013 Sebastian Michaelsen (michaelsen@t3seo.de)
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
 * Class ElementConditionMatcher
 * It implements the TCA 'displayCond' option.
 * The display condition is a colon separated string which describes the condition to decide whether a form field
 * should be displayed or not.
 *
 * @package TYPO3\CMS\Backend\Form
 */
class ElementConditionMatcher {

	/**
	 * @var string
	 */
	protected $flexformValueKey = '';

	/**
	 * @var array
	 */
	protected $record;

	/**
	 * @param string $flexformValueKey
	 */
	public function setFlexformValueKey($flexformValueKey) {
		$this->flexformValueKey = $flexformValueKey;
	}

	/**
	 * @param array $record
	 */
	public function setRecord($record) {
		$this->record = $record;
	}

	/**
	 * Evaluates the provided condition and returns TRUE if the form element should be displayed
	 *
	 * The condition string is separated by colons and the first part indicates what type of evaluation should be
	 * performed.
	 *
	 * @param string $displayCondition
	 * @return bool
	 */
	public function match($displayCondition) {
		$result = FALSE;
		list($matchType, $condition) = explode(':', $displayCondition, 2);
		switch ($matchType) {
			case 'EXT':
				$result = $this->matchExtensionCondition($condition);
				break;
			case 'FIELD':
				$result = $this->matchFieldCondition($condition);
				break;
			case 'HIDE_FOR_NON_ADMINS':
				$result = $this->matchHideForNonAdminsCondition();
				break;
			case 'HIDE_L10N_SIBLINGS':
				$result = $this->matchHideL10nSiblingsCondition($condition);
				break;
			case 'REC':
				$result = $this->matchRecordCondition($condition);
				break;
			case 'VERSION':
				$result = $this->matchVersionCondition($condition);
				break;
		}
		return $result;
	}

	/**
	 * Evaluates conditions concerning extensions
	 *
	 * Example:
	 * "EXT:saltedpasswords:LOADED:TRUE" => TRUE, if the extension saltedpasswords is loaded.
	 *
	 * @param string $condition
	 * @return bool
	 */
	protected function matchExtensionCondition($condition) {
		$result = FALSE;
		list($extensionKey, $operator, $operand) = explode(':', $condition, 3);
		if ($operator === 'LOADED') {
			if (strtoupper($operand) == 'TRUE') {
				$result = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded($extensionKey);
			} elseif (strtoupper($operand) == 'FALSE') {
				$result = !\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded($extensionKey);
			}
		}
		return $result;
	}

	/**
	 * Evaluates conditions concerning a field of the current record (requires a record set via ->setRecord())
	 *
	 * Example:
	 * "FIELD:sys_language_uid:>:0" => TRUE, if the field 'sys_language_uid' is greater than 0
	 *
	 * @param string $condition
	 * @return bool
	 */
	protected function matchFieldCondition($condition) {
		$result = FALSE;
		if (is_array($this->record)) {
			list($fieldName, $operator, $operand) = explode(':', $condition, 3);
			if ($this->flexformValueKey) {
				if (strpos($fieldName, 'parentRec.') !== FALSE) {
					$fieldNameParts = explode('.', $fieldName, 2);
					$fieldValue = $this->record['parentRec'][$fieldNameParts[1]];
				} else {
					$fieldValue = $this->record[$fieldName][$this->flexformValueKey];
				}
			} else {
				$fieldValue = $this->record[$fieldName];
			}
			switch ($operator) {
				case 'REQ':
					if (strtoupper($operand) === 'TRUE') {
						$result = (bool) $fieldValue;
					} else {
						$result = !$fieldValue;
					}
					break;
				case '>':
					$result = $fieldValue > $operand;
					break;
				case '<':
					$result = $fieldValue < $operand;
					break;
				case '>=':
					$result = $fieldValue >= $operand;
					break;
				case '<=':
					$result = $fieldValue <= $operand;
					break;
				case '-':
				case '!-':
					list($minimum, $maximum) = explode('-', $operand);
					$result = $fieldValue >= $minimum && $fieldValue <= $maximum;
					if ($operator{0} === '!') {
						$result = !$result;
					}
					break;
				case 'IN':
				case '!IN':
				case '=':
				case '!=':
					$result = \TYPO3\CMS\Core\Utility\GeneralUtility::inList($operator, $fieldValue);
					if ($operator{0} === '!') {
						$result = !$result;
					}
					break;
			}
		}
		return $result;
	}

	/**
	 * Evaluates whether the is backend user is not an admin.
	 *
	 * @return bool
	 */
	protected function matchHideForNonAdminsCondition() {
		return (bool) $GLOBALS['BE_USER']->isAdmin();
	}

	/**
	 * Evaluates whether the field is a value for the default language.
	 * Works only for <langChildren>=1, otherwise it has no effect.
	 *
	 * @param string $condition
	 * @return bool
	 */
	protected function matchHideL10nSiblingsCondition($condition) {
		$result = FALSE;
		if ($this->flexformValueKey === 'vDEF') {
			$result = TRUE;
		} elseif ($condition === 'except_admin' && $GLOBALS['BE_USER']->isAdmin()) {
			$result = TRUE;
		}
		return $result;
	}

	/**
	 * Evaluates conditions concerning the status of the current record (requires a record set via ->setRecord())
	 *
	 * Example:
	 * "REC:NEW:FALSE" => TRUE, if the record is already persisted (has a uid > 0)
	 *
	 * @param string $condition
	 * @return bool
	 */
	protected function matchRecordCondition($condition) {
		$result = FALSE;
		if (is_array($this->record)) {
			list($operator, $operand) = explode(':', $condition, 2);
			if ($operator === 'NEW') {
				if (strtoupper($operand) == 'TRUE') {
					$result = !(intval($this->record['uid']) > 0);
				} elseif (strtoupper($operand) == 'FALSE') {
					$result = (intval($this->record['uid']) > 0);
				}
			}
		}
		return $result;
	}

	/**
	 * Evaluates whether the current record is versioned (requires a record set via ->setRecord())
	 *
	 * @param string $condition
	 * @return bool
	 */
	protected function matchVersionCondition($condition) {
		$result = FALSE;
		if (is_array($this->record)) {
			list($operator, $operand) = explode(':', $condition, 2);
			if ($operator === 'IS') {
				$isNewRecord = !(intval($this->record['uid']) > 0);
				// Detection of version can be done be detecting the workspace of the user
				$isUserInWorkspace = $GLOBALS['BE_USER']->workspace > 0;
				if (intval($this->record['pid']) == -1 || intval($this->record['_ORIG_pid']) == -1) {
					$isRecordDetectedAsVersion = TRUE;
				} else {
					$isRecordDetectedAsVersion = FALSE;
				}
				// New records in a workspace are not handled as a version record
				// if it's no new version, we detect versions like this:
				// -- if user is in workspace: always TRUE
				// -- if editor is in live ws: only TRUE if pid == -1
				$isVersion = ($isUserInWorkspace || $isRecordDetectedAsVersion) && !$isNewRecord;
				if (strtoupper($operand) === 'TRUE') {
					$result = $isVersion;
				} elseif (strtoupper($operand) === 'FALSE') {
					$result = !$isVersion;
				}
			}
		}
		return $result;
	}

}

?>