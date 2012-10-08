<?php
namespace TYPO3\CMS\Core\Tests\Functional\Resource;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Andreas Wolf <andreas.wolf@typo3.org>
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

require_once 'vfsStream/vfsStream.php';

/**
 * Functional test case for the FAL folder class.
 *
 * @author Andreas Wolf <andreas.wolf@typo3.org>
 * @package TYPO3
 * @subpackage t3lib
 */
class FolderTest extends BaseTestCase {

	/**
	 * Helper method for testing restore of filters in the storage
	 *
	 * @param $filterMode
	 */
	protected function _testFileAndFoldernameFilterRestoreAfterFileList($filterMode) {
		$storageFilter = new \TYPO3\CMS\Core\Resource\Filter\FileExtensionFilter();
		$storageFilter->setAllowedFileExtensions('jpg,png');
		$folderFilter = new \TYPO3\CMS\Core\Resource\Filter\FileExtensionFilter();
		$folderFilter->setAllowedFileExtensions('png');

		$this->addToMount(array('somefile.png' => '', 'somefile.jpg' => '', 'somefile.exe' => ''));
		$storageObject = $this->getStorageObject();
		$storageObject->setFileAndFolderNameFilters(array(array($storageFilter, 'filterFileList')));
		$folder = $storageObject->getRootLevelFolder();
		$folder->setFileAndFolderNameFilters(array(array($storageFilter, 'filterFileList')));

		$filtersBackup = $storageObject->getFileAndFolderNameFilters();
		$folder->getFiles(0, 0, $filterMode);

		$this->assertEquals($filtersBackup, $storageObject->getFileAndFolderNameFilters());
	}

	/**
	 * @test
	 */
	public function getFilesRespectsSetFileAndFoldernameFiltersIfFilterModeIsUseOwnFilters() {
		$filter = new \TYPO3\CMS\Core\Resource\Filter\FileExtensionFilter();
		$filter->setAllowedFileExtensions('jpg,png');

		$this->addToMount(array('somefile.png' => '', 'somefile.jpg' => '', 'somefile.exe' => ''));
		$storageObject = $this->getStorageObject();
		$folder = $storageObject->getRootLevelFolder();
		$folder->setFileAndFolderNameFilters(array(array($filter, 'filterFileList')));

		$fileList = $folder->getFiles(0, 0, \TYPO3\CMS\Core\Resource\Folder::FILTER_MODE_USE_OWN_FILTERS);

		$this->assertArrayNotHasKey('somefile.exe', $fileList);
		$this->assertCount(2, $fileList);
	}

	/**
	 * @test
	 */
	public function getFilesRestoresFileAndFoldernameFiltersOfStorageAfterFetchingFileListIfFilterModeIsUseOwnFilters() {
		$this->_testFileAndFoldernameFilterRestoreAfterFileList(\TYPO3\CMS\Core\Resource\Folder::FILTER_MODE_USE_OWN_FILTERS);
	}

	/**
	 * @test
	 */
	public function getFilesMergesSetFileAndFoldernameFiltersIntoStoragesFiltersIfFilterModeIsUseOwnAndStorageFilters() {
		$foldersFilter = new \TYPO3\CMS\Core\Resource\Filter\FileExtensionFilter();
		$foldersFilter->setAllowedFileExtensions('jpg,png');
		$storagesFilter = new \TYPO3\CMS\Core\Resource\Filter\FileExtensionFilter();
		$storagesFilter->setDisallowedFileExtensions('png');

		$this->addToMount(array('somefile.png' => '', 'somefile.jpg' => '', 'somefile.exe' => ''));
		$storageObject = $this->getStorageObject();
		$storageObject->setFileAndFolderNameFilters(array(array($storagesFilter, 'filterFileList')));
		$folder = $storageObject->getRootLevelFolder();
		$folder->setFileAndFolderNameFilters(array(array($foldersFilter, 'filterFileList')));

		$fileList = $folder->getFiles(0, 0, \TYPO3\CMS\Core\Resource\Folder::FILTER_MODE_USE_OWN_AND_STORAGE_FILTERS);

		$this->assertArrayNotHasKey('somefile.exe', $fileList);
		$this->assertArrayNotHasKey('somefile.png', $fileList);
		$this->assertCount(1, $fileList);
	}

	/**
	 * @test
	 */
	public function getFilesUsesOnlyFileAndFoldernameFiltersOfStorageIfNoFiltersAreSetAndFilterModeIsUseOwnAndStorageFilters() {
		$filter = new \TYPO3\CMS\Core\Resource\Filter\FileExtensionFilter();
		$filter->setAllowedFileExtensions('jpg,png');

		$this->addToMount(array('somefile.png' => '', 'somefile.jpg' => '', 'somefile.exe' => ''));
		$storageObject = $this->getStorageObject();
		$folder = $storageObject->getRootLevelFolder();
		$storageObject->setFileAndFolderNameFilters(array(array($filter, 'filterFileList')));

		$fileList = $folder->getFiles(0, 0, \TYPO3\CMS\Core\Resource\Folder::FILTER_MODE_USE_OWN_AND_STORAGE_FILTERS);

		$this->assertArrayNotHasKey('somefile.exe', $fileList);
		$this->assertCount(2, $fileList);
	}

	/**
	 * @test
	 */
	public function getFilesRestoresFileAndFoldernameFiltersOfStorageAfterFetchingFileListIfFilterModeIsUseOwnAndStorageFiltersAndFiltersHaveBeenSetInFolder() {
		$this->_testFileAndFoldernameFilterRestoreAfterFileList(\TYPO3\CMS\Core\Resource\Folder::FILTER_MODE_USE_OWN_AND_STORAGE_FILTERS);
	}

	/**
	 * @test
	 */
	public function getFilesIgnoresSetFileAndFoldernameFiltersIfFilterModeIsSetToUseStorageFilters() {
		$filter = new \TYPO3\CMS\Core\Resource\Filter\FileExtensionFilter();
		$filter->setAllowedFileExtensions('jpg,png');

		$this->addToMount(array('somefile.png' => '', 'somefile.jpg' => '', 'somefile.exe' => ''));
		$storageObject = $this->getStorageObject();
		$folder = $storageObject->getRootLevelFolder();
		$folder->setFileAndFolderNameFilters(array(array($filter, 'filterFileList')));

		$fileList = $folder->getFiles(0, 0, \TYPO3\CMS\Core\Resource\Folder::FILTER_MODE_USE_STORAGE_FILTERS);

		$this->assertCount(3, $fileList);
	}
}

?>