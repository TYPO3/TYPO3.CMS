<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011-2012 Steffen Ritter <steffen.ritter@typo3.org>
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
 * Pad represents an collection of ClipBoard entries which might be records of several types.
 * Also the mode of each Pad is stored here
 *
 * @author Steffen Ritter <steffen.ritter@typo3.org>
 * @package TYPO3
 * @subpackage typo3
 */
class Typo3_Clipboard_Pad implements t3lib_collection_Collection, t3lib_collection_Persistable {

	/**
	 * @var string
	 */
	const SPLIT_CHAR = '|';

	/**
	 * Constants for Clipboard Modes
	 * @var integer
	 */
	const MODE_CUT  = 0;
	const MODE_COPY = 1;

	/**
	 * Instance Cache for ClipBoard Pads
	 *
	 * @var array
	 */
	protected static $instances = array();

	/**
	 * Reference to the Parent clipboard
	 * @var Typo3_Clipboard_Clipboard
	 */
	protected $clipboard = NULL;

	/**
	 * The actual clipboard data
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * The id
	 * will always match "padNumber"
	 *
	 * @var integer
	 */
	protected $identifier;

	/**
	 * Mode of the ClipBoard
	 *
	 * @var integer
	 */
	protected $mode = self::MODE_CUT;

	/**
	 * Constructor
	 *
	 * Has to be protected. Only called by ::load
	 * to ensure only one object per Pad ID can
	 * be created
	 *
	 */
	protected function __construct(Typo3_Clipboard_Clipboard $clipboard) {
		$this->clipboard = $clipboard;
	}

	/**
	 * Return the current element
	 *
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 */
	public function current() {
		return key($this->data);
	}

	/**
	 * Move forward to next element
	 *
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next() {
		next($this->data);
	}

	/**
	 * Return the key of the current element
	 *
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return integer
	 * 0 on failure.
	 */
	public function key() {
		return key($this->data);
	}

	/**
	 * Checks if current position is valid
	 *
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 */
	public function valid() {
		return current($this->data) !== FALSE;
	}

	/**
	 * Rewind the Iterator to the first element
	 *
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind() {
		reset($this->data);
	}

	/**
	 * String representation of object
	 *
	 * @link http://php.net/manual/en/serializable.serialize.php
	 * @return string the string representation of the object or &null;
	 */
	public function serialize() {
		throw new RuntimeException('A clipboard pad cannot be serialized', 1340539347);
	}

	/**
	 * Constructs the object
	 * @link http://php.net/manual/en/serializable.unserialize.php
	 * @param string $serialized <p>
	 * The string representation of the object.
	 * </p>
	 * @return mixed the original value unserialized.
	 */
	public function unserialize($serialized) {
		throw new RuntimeException('A clipboard pad cannot be unserialized', 1340539348);
	}

	/**
	 * Count elements of an object
	 * @link http://php.net/manual/en/countable.count.php
	 * @return integer The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 */
	public function count() {
		return count($this->data);
	}

	/**
	 * Returns the Pad Id
	 *
	 * @return integer
	 */
	public function getIdentifier() {
		return $this->identifier;
	}

	/**
	 * Sets the Pad Identifier
	 *
	 * @param integer $id
	 */
	public function setIdentifier($id) {
		$this->identifier = intval($id);
	}

	/**
	 * Static Factory function to create an pad for $id
	 *
	 * @param string $id
	 * @param boolean $fillItems does not apply for ClipBoardPads, data always needed
	 * @return t3lib_collection_Collection
	 */
	public static function load($id, $fillItems = FALSE) {
		$id = intval($id);
		if (!array_key_exists($id, self::$instances)) {
			/** @var t3lib_clipboard_Pad $instance */
			$instance = new self(t3lib_div::makeInstance('TYPO3_Clipboard_Clipboard'));
			$instance->setIdentifier($id);
			$instance->loadContents();

			self::$instances[$id] = $instance;
		}
		return self::$instances[$id];
	}

	/**
	 * Creates an array representation of this clipboard pad
	 *
	 * @return array
	 */
	protected function toArray() {
		return array(
			'mode' => $this->getMode(),
			'elements' => $this->data
		);
	}

	/**
	 * Persist the clipboard to the underlying storage
	 *
	 * @return void
	 */
	public function persist() {
		$this->setData($this->toArray());
	}

	/**
	 * Loads the clipboard data from its underlying storage
	 *
	 * @return void
	 */
	public function loadContents() {
		$data = $this->getData();
		$this->clear();
		$this->mode = $data['mode'] == 1 ? self::MODE_COPY : self::MODE_CUT;

			// Check if the clipboard entry still exists
		foreach ((array)$data['elements'] AS $element => $selected) {
			list($type, $elementIdentifier) = t3lib_div::trimExplode(self::SPLIT_CHAR, $element, FALSE, 2);
			switch ($type) {
				case '_FILE':
					$valid = t3lib_div::makeInstance('t3lib_file_Factory')
								->retrieveFileOrFolderObject($elementIdentifier) !== NULL;
					break;
				default:
					$valid = is_array(t3lib_BEfunc::getRecord($type, $elementIdentifier));
			}
			if ($valid) {
				$this->add($type, $elementIdentifier, $selected);
			}
		}
	}

	/**
	 * @param integer $mode should only be self::MODE_COPY or self::MODE_MOVE
	 * @return void
	 */
	public function setMode($mode) {
		$this->mode = $mode;
	}

	/**
	 * Returns the mode of the clipboard pad
	 * should be COPY or MOVE
	 *
	 * @return integer
	 */
	public function getMode() {
		return $this->mode;
	}

	/**
	 * Adds an entry to the clipboard pad
	 *
	 * @param string $type either _FILE or TCA-tableName
	 * @param string|integer $identifier the id, for _FILE combined Identifier, else uid
	 * @param boolean $selectionStatus if the checkbox is checked
	 * @return boolean
	 */
	public function add($type, $identifier, $selectionStatus = FALSE) {
		if (!$this->has($type, $identifier)) {
			$this->data[$type . self::SPLIT_CHAR . $identifier] = $selectionStatus;
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Checks if an entry is present in this clipboard pad
	 *
	 * @param string $type either _FILE or TCA-tableName
	 * @param string|integer $identifier the id, for _FILE combined Identifier, else uid
	 *
	 * @return boolean
	 */
	public function has($type, $identifier) {
		$entry = $type . self::SPLIT_CHAR . $identifier;
		return array_key_exists($entry, $this->data);
	}

	/**
	 * returns the selection status of
	 *
	 * @param string $type Either _FILE or TCA-tableName
	 * @param string|integer $identifier The id, for _FILE combined Identifier, else uid
	 * @return boolean
	 */
	public function isSelected($type, $identifier) {
		return $this->data[$type . self::SPLIT_CHAR . $identifier] === TRUE;
	}

	/**
	 * Removes an entry of this clipboard pad
	 *
	 * @param string $type Either _FILE or TCA-tableName
	 * @param string|inteager $identifier The id, for _FILE combined Identifier, else uid
	 * @return boolean Success
	 */
	public function remove($type, $identifier) {
		if ($this->has($type, $identifier)) {
			unset($this->data[$type . self::SPLIT_CHAR . $identifier]);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Returns array of all entries which are selected
	 *
	 * @return array
	 */
	public function getSelected() {
		return array_keys(array_filter(
			$this->data,
			function($entry){
				return $entry == TRUE;
			}
		));
	}

	/**
	 * Reset the current Pad
	 *
	 * @return void
	 */
	public function clear() {
		$this->data = array();
	}

	/**
	 * Loads the ClipBoard Contents from the persistence
	 * Takes care of crossSessionPersistence.
	 *
	 * @return array
	 */
	protected function getData() {
		if ($this->clipboard->getDoCrossSessionPersistence()) {
			return (array)$GLOBALS['BE_USER']->uc['moduleData']['clipboard']['pads'][$this->getIdentifier()];
		} else {
			$sessionData = $GLOBALS['BE_USER']->getSessionData('clipboard');
			return (array)$sessionData['pads'][$this->getIdentifier()];
		}
	}

	/**
	 * Persists the ClipboardData-Array
	 * Takes care of crossSessionPersistence.
	 *
	 * @param array $array
	 * @return void
	 */
	protected function setData(array $array) {
		if ($this->clipboard->getDoCrossSessionPersistence()) {
			$GLOBALS['BE_USER']->uc['moduleData']['clipboard']['pads'][$this->getIdentifier()] = $array;
		} else {
			$sessionData = $GLOBALS['BE_USER']->getSessionData('clipboard');
			$sessionData['pads'][$this->getIdentifier()] = $array;
			$GLOBALS['BE_USER']->setAndSaveSessionData('clipboard', $sessionData);
		}
	}
}
?>