<?php
$t3libClasses = array(
	't3lib_ajax' => PATH_t3lib . 'class.t3lib_ajax.php',
	't3lib_formmail' => PATH_t3lib . 'class.t3lib_formmail.php',
	't3lib_install' => PATH_t3lib . 'class.t3lib_install.php',
	't3lib_readmail' => PATH_t3lib . 'class.t3lib_readmail.php',
	't3lib_syntaxhl' => PATH_t3lib . 'class.t3lib_syntaxhl.php',
	't3lib_userauthgroup' => PATH_t3lib . 'class.t3lib_userauthgroup.php',
	't3lib_xml' => PATH_t3lib . 'class.t3lib_xml.php'
);
$typo3Classes = array(
	'ext_posmap_pages' => PATH_typo3 . 'move_el.php',
	'ext_posmap_tt_content' => PATH_typo3 . 'move_el.php',
	'ext_tsparser' => PATH_typo3 . 'wizard_tsconfig.php',
	'localfoldertree' => PATH_typo3 . 'class.browse_links.php',
	'rtefoldertree' => PATH_typo3 . 'class.browse_links.php',
	'rtepagetree' => PATH_typo3 . 'class.browse_links.php',
	'tbe_foldertree' => PATH_typo3 . 'class.browse_links.php',
	'tbe_pagetree' => PATH_typo3 . 'class.browse_links.php',
	'transferdata' => PATH_typo3 . 'show_item.php',
);
$flowClassesPath = __DIR__ . '/Resources/PHP/TYPO3.Flow/Classes/';
$flowClasses = array(
	'typo3\flow\package\documentation\format' => $flowClassesPath . 'TYPO3/Flow/Package/Documentation/Format.php',
	'typo3\flow\package\documentation' => $flowClassesPath . 'TYPO3/Flow/Package/Documentation.php',
	'typo3\flow\package\exception\corruptpackageexception' => $flowClassesPath . 'TYPO3/Flow/Package/Exception/CorruptPackageException.php',
	'typo3\flow\package\exception\duplicatepackageexception' => $flowClassesPath . 'TYPO3/Flow/Package/Exception/DuplicatePackageException.php',
	'typo3\flow\package\exception\invalidpackagekeyexception' => $flowClassesPath . 'TYPO3/Flow/Package/Exception/InvalidPackageKeyException.php',
	'typo3\flow\package\exception\invalidpackagemanifestexception' => $flowClassesPath . 'TYPO3/Flow/Package/Exception/InvalidPackageManifestException.php',
	'typo3\flow\package\exception\invalidpackagepathexception' => $flowClassesPath . 'TYPO3/Flow/Package/Exception/InvalidPackagePathException.php',
	'typo3\flow\package\exception\invalidpackagestateexception' => $flowClassesPath . 'TYPO3/Flow/Package/Exception/InvalidPackageStateException.php',
	'typo3\flow\package\exception\missingpackagemanifestexception' => $flowClassesPath . 'TYPO3/Flow/Package/Exception/MissingPackageManifestException.php',
	'typo3\flow\package\exception\packagekeyalreadyexistsexception' => $flowClassesPath . 'TYPO3/Flow/Package/Exception/PackageKeyAlreadyExistsException.php',
	'typo3\flow\package\exception\packagerepositoryexception' => $flowClassesPath . 'TYPO3/Flow/Package/Exception/PackageRepositoryException.php',
	'typo3\flow\package\exception\protectedpackagekeyexception' => $flowClassesPath . 'TYPO3/Flow/Package/Exception/ProtectedPackageKeyException.php',
	'typo3\flow\package\exception\unknownpackageexception' => $flowClassesPath . 'TYPO3/Flow/Package/Exception/UnknownPackageException.php',
	'typo3\flow\package\exception' => $flowClassesPath . 'TYPO3/Flow/Package/Exception.php',
	'typo3\flow\package\metadata\abstractconstraint' => $flowClassesPath . 'TYPO3/Flow/Package/MetaData/AbstractConstraint.php',
	'typo3\flow\package\metadata\abstractparty' => $flowClassesPath . 'TYPO3/Flow/Package/MetaData/AbstractParty.php',
	'typo3\flow\package\metadata\company' => $flowClassesPath . 'TYPO3/Flow/Package/MetaData/Company.php',
	'typo3\flow\package\metadata\packageconstraint' => $flowClassesPath . 'TYPO3/Flow/Package/MetaData/PackageConstraint.php',
	'typo3\flow\package\metadata\person' => $flowClassesPath . 'TYPO3/Flow/Package/MetaData/Person.php',
	'typo3\flow\package\metadata\systemconstraint' => $flowClassesPath . 'TYPO3/Flow/Package/MetaData/SystemConstraint.php',
	'typo3\flow\package\metadata' => $flowClassesPath . 'TYPO3/Flow/Package/MetaData.php',
	'typo3\flow\package\metadatainterface' => $flowClassesPath . 'TYPO3/Flow/Package/MetaDataInterface.php',
	'typo3\flow\package\package' => $flowClassesPath . 'TYPO3/Flow/Package/Package.php',
	'typo3\flow\package\packagefactory' => $flowClassesPath . 'TYPO3/Flow/Package/PackageFactory.php',
	'typo3\flow\package\packageinterface' => $flowClassesPath . 'TYPO3/Flow/Package/PackageInterface.php',
	'typo3\flow\package\packagemanager' => $flowClassesPath . 'TYPO3/Flow/Package/PackageManager.php',
	'typo3\flow\utility\files' => $flowClassesPath . 'TYPO3/Flow/Utility/Files.php',
	'typo3\flow\exception' => $flowClassesPath . 'TYPO3/Flow/Exception.php',
);
return array_merge($t3libClasses, $typo3Classes, $flowClasses);
?>