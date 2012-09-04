<?php
namespace TYPO3\CMS\Core\Resource;

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
 * Repository for accessing files
 * it also serves as the public API for the indexing part of files in general
 *
 * @author Andreas Wolf <andreas.wolf@ikt-werk.de>
 * @author Ingmar Schlecht <ingmar@typo3.org>
 * @package 	TYPO3
 * @subpackage 	t3lib
 */
class FileRepository extends \TYPO3\CMS\Core\Resource\AbstractRepository {

	/**
	 * The main object type of this class. In some cases (fileReference) this
	 * repository can also return FileReference objects, implementing the
	 * common FileInterface.
	 *
	 * @var string
	 */
	protected $objectType = 'TYPO3\\CMS\\Core\\Resource\\File';

	/**
	 * Main File object storage table. Note that this repository also works on
	 * the sys_file_reference table when returning FileReference objects.
	 *
	 * @var string
	 */
	protected $table = 'sys_file';

	/**
	 * @var \TYPO3\CMS\Core\Resource\Service\IndexerService
	 */
	protected $indexerService = NULL;

	/**
	 * @var Property\PropertyBagRepository
	 */
	protected $propertyBagRepository;


	public function injectPropertyBagRepository(Property\PropertyBagRepository $propertyBagRepository = NULL) {
		if (!is_null($propertyBagRepository)) {
			$this->propertyBagRepository = $propertyBagRepository;
		} else {
			$this->propertyBagRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\Property\\PropertyBagRepository');
		}
	}

	public function __construct() {
		$this->injectPropertyBagRepository();
	}

	/**
	 * Internal function to retrieve the indexer service,
	 * if it does not exist, an instance will be created
	 *
	 * @return \TYPO3\CMS\Core\Resource\Service\IndexerService
	 */
	protected function getIndexerService() {
		if ($this->indexerService === NULL) {
			$this->indexerService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\Service\\IndexerService');
		}
		return $this->indexerService;
	}

	/**
	 * Creates an object managed by this repository.
	 *
	 * @param array $databaseRow
	 * @return \TYPO3\CMS\Core\Resource\File
	 */
	protected function createDomainObject(array $databaseRow) {
		return $this->factory->getFileObject($databaseRow['uid'], $databaseRow);
	}

	/**
	 * Index a file object given as parameter
	 *
	 * @TODO : Check if the indexing functions really belong into the repository and shouldn't be part of an
	 * @TODO : indexing service, right now it's fine that way as this function will serve as the public API
	 * @param \TYPO3\CMS\Core\Resource\File $fileObject
	 * @return array The indexed file data
	 */
	public function addToIndex(\TYPO3\CMS\Core\Resource\File $fileObject) {
		return $this->getIndexerService()->indexFile($fileObject, FALSE);
	}

	/**
	 * Checks the index status of a file and returns FALSE if the file is not
	 * indexed, the uid otherwise.
	 *
	 * @TODO : Check if the indexing functions really belong into the repository and shouldn't be part of an
	 * @TODO : indexing service, right now it's fine that way as this function will serve as the public API
	 * @TODO : throw an exception if nothing found, for consistent handling as in AbstractRepository?
	 * @param \TYPO3\CMS\Core\Resource\File $fileObject
	 * @return bool|int
	 */
	public function getFileIndexStatus(\TYPO3\CMS\Core\Resource\File $fileObject) {
		$mount = $fileObject->getStorage()->getUid();
		$identifier = $fileObject->getIdentifier();
		$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('uid,storage,identifier', $this->table, sprintf('storage=%u AND identifier=%s', $mount, $GLOBALS['TYPO3_DB']->fullQuoteStr($identifier, $this->table)));
		if (!is_array($row)) {
			return FALSE;
		} else {
			return $row['uid'];
		}
	}

	/**
	 * Returns an index record of a file, or FALSE if the file is not indexed.
	 *
	 * @TODO : throw an exception if nothing found, for consistent handling as in AbstractRepository?
	 * @param \TYPO3\CMS\Core\Resource\File $fileObject
	 * @return bool|array
	 */
	public function getFileIndexRecord(\TYPO3\CMS\Core\Resource\File $fileObject) {
		$mount = $fileObject->getStorage()->getUid();
		$identifier = $fileObject->getIdentifier();
		$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('*', $this->table, sprintf('storage=%u AND identifier=%s', $mount, $GLOBALS['TYPO3_DB']->fullQuoteStr($identifier, $this->table)));
		if (!is_array($row)) {
			return FALSE;
		} else {
			return $row;
		}
	}

	/**
	 * Returns the index-data of all files within that folder
	 *
	 * @param \TYPO3\CMS\Core\Resource\Folder $folder
	 * @return array
	 */
	public function getFileIndexRecordsForFolder(\TYPO3\CMS\Core\Resource\Folder $folder) {
		$identifier = $folder->getIdentifier();
		$storage = $folder->getStorage()->getUid();
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', $this->table, sprintf('storage=%u AND identifier LIKE "%s" AND NOT identifier LIKE "%s"', $storage, $GLOBALS['TYPO3_DB']->escapeStrForLike($identifier, $this->table) . '%', $GLOBALS['TYPO3_DB']->escapeStrForLike($identifier, $this->table) . '%/%'), '', '', '', 'identifier');
		return (array) $rows;
	}

	/**
	 * Returns all files with the corresponding SHA-1 hash. This is queried
	 * against the database, so only indexed files will be found
	 *
	 * @param string $hash A SHA1 hash of a file
	 * @return array
	 */
	public function findBySha1Hash($hash) {
		if (preg_match('/[^a-f0-9]*/i', $hash)) {

		}
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', $this->table, 'sha1=' . $GLOBALS['TYPO3_DB']->fullQuoteStr($hash, $this->table));
		$objects = array();
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$objects[] = $this->createDomainObject($row);
		}
		$GLOBALS['TYPO3_DB']->sql_free_result($res);
		return $objects;
	}

	/**
	 * Find FileReference objects by relation to other records
	 *
	 * @param int $tableName Table name of the related record
	 * @param int $fieldName Field name of the related record
	 * @param int $uid The UID of the related record
	 * @return array An array of objects, empty if no objects found
	 * @api
	 */
	public function findByRelation($tableName, $fieldName, $uid) {
		$itemList = array();
		if (!is_numeric($uid)) {
			throw new \InvalidArgumentException('Uid of related record has to be numeric.', 1316789798);
		}
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'sys_file_reference', 'tablenames=' . $GLOBALS['TYPO3_DB']->fullQuoteStr($tableName, 'sys_file_reference') . ' AND deleted=0' . ' AND hidden=0' . ' AND uid_foreign=' . intval($uid) . ' AND fieldname=' . $GLOBALS['TYPO3_DB']->fullQuoteStr($fieldName, 'sys_file_reference'), '', 'sorting_foreign');
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$itemList[] = $this->createFileReferenceObject($row);
		}
		$GLOBALS['TYPO3_DB']->sql_free_result($res);
		return $itemList;
	}

	/**
	 * Find FileReference objects by uid
	 *
	 * @param integer $uid The UID of the sys_file_reference record
	 * @return \TYPO3\CMS\Core\Resource\FileReference|boolean
	 * @api
	 */
	public function findFileReferenceByUid($uid) {
		$fileReferenceObject = FALSE;
		if (!is_numeric($uid)) {
			throw new \InvalidArgumentException('uid of record has to be numeric.', 1316889798);
		}
		$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('*', 'sys_file_reference', 'uid=' . $uid . ' AND deleted=0' . ' AND hidden=0');
		if (is_array($row)) {
			$fileReferenceObject = $this->createFileReferenceObject($row);
		}
		return $fileReferenceObject;
	}

	/**
	 * Updates an existing file object in the database
	 *
	 * @param \TYPO3\CMS\Core\Resource\File $modifiedObject
	 * @return void
	 */
	public function update($modifiedObject) {
		// TODO check if $modifiedObject is an instance of \TYPO3\CMS\Core\Resource\File
		// TODO check if $modifiedObject is indexed
		$changedProperties = $modifiedObject->getUpdatedProperties();
		$properties = $modifiedObject->getProperties();
		$updateFields = array();
		foreach ($changedProperties as $propertyName) {
			$updateFields[$propertyName] = $properties[$propertyName];
		}
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery('sys_file', 'uid=' . intval($modifiedObject->getUid()), $updateFields);
		$this->propertyBagRepository->update($modifiedObject->getPropertyBags());
	}

	/**
	 * Creates a FileReference object
	 *
	 * @param array $databaseRow
	 * @return \TYPO3\CMS\Core\Resource\FileReference
	 */
	protected function createFileReferenceObject(array $databaseRow) {
		return $this->factory->getFileReferenceObject($databaseRow['uid'], $databaseRow);
	}

}


?>