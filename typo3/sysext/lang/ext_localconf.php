<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

	// Register cache lang_l10n
if (!is_array($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['lang_l10n'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['lang_l10n'] = array();
}

if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['lang_l10n']['backend'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['lang_l10n']['backend'] = 't3lib_cache_backend_FileBackend';
}

?>