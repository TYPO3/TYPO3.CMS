<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Sebastian Fischer <typo3@evoweb.de>
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
 * Extends of extensionmanager ter connection to enrich with translation related methods
 *
 * @author Sebastian Fischer <typo3@evoweb.de>
 * @package lang
 * @subpackage Connection_Ter
 */
class Tx_Lang_Utility_Connection_Ter extends Tx_Extensionmanager_Utility_Connection_Ter {
	/**
	 * Fetches extensions translation status
	 *
	 * @param string $extensionKey Extension Key
	 * @param string $mirrorUrl URL of mirror to use
	 * @return mixed
	 */
	public function fetchTranslationStatus($extensionKey, $mirrorUrl) {
		$extPath = t3lib_div::strtolower($extensionKey);
		$mirrorUrl .= $extPath{0} . '/' . $extPath{1} . '/' . $extPath . '-l10n/' . $extPath . '-l10n.xml';
		$remote = t3lib_div::getURL($mirrorUrl, 0, array(TYPO3_user_agent));

		if ($remote !== FALSE) {
			$parsed = $this->parseL10nXML($remote);
			return $parsed['languagePackIndex'];
		}

		return FALSE;
	}

	/**
	 * Parses content of *-l10n.xml into a suitable array
	 *
	 * @param string $string: XML data to parse
	 * @return array Array representation of XML data
	 */
	protected function parseL10nXML($string) {
			// Create parser:
		$parser = xml_parser_create();
		$vals = array();
		$index = array();

		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 0);

			// Parse content:
		xml_parse_into_struct($parser, $string, $vals, $index);

			// If error, return error message:
		if (xml_get_error_code($parser)) {
			$line = xml_get_current_line_number($parser);
			$error = xml_error_string(xml_get_error_code($parser));
			xml_parser_free($parser);
			return 'Error in XML parser while decoding l10n XML file. Line ' . $line . ': ' . $error;
		} else {
				// Init vars:
			$stack = array(array());
			$stacktop = 0;
			$current = array();
			$tagName = '';
			$documentTag = '';

				// Traverse the parsed XML structure:
			foreach ($vals as $val) {
					// First, process the tag-name (which is used in both cases, whether "complete" or "close")
				$tagName = ($val['tag'] == 'languagepack' && $val['type'] == 'open') ? $val['attributes']['language'] : $val['tag'];
				if (!$documentTag) {
					$documentTag = $tagName;
				}

					// Setting tag-values, manage stack:
				switch ($val['type']) {
					case 'open': // If open tag it means there is an array stored in sub-elements. Therefore increase the stackpointer and reset the accumulation array:
						$current[$tagName] = array(); // Setting blank place holder
						$stack[$stacktop++] = $current;
						$current = array();
						break;
					case 'close': // If the tag is "close" then it is an array which is closing and we decrease the stack pointer.
						$oldCurrent = $current;
						$current = $stack[--$stacktop];
						end($current); // Going to the end of array to get placeholder key, key($current), and fill in array next:
						$current[key($current)] = $oldCurrent;
						unset($oldCurrent);
						break;
					case 'complete': // If "complete", then it's a value. If the attribute "base64" is set, then decode the value, otherwise just set it.
						$current[$tagName] = (string) $val['value']; // Had to cast it as a string - otherwise it would be evaluate FALSE if tested with isset()!!
						break;
				}
			}
			return $current[$tagName];
		}
	}

	/**
	 * Install translations for all selected languages for an extension
	 *
	 * @param string $extensionKey The extension key to install the translations for
	 * @param string $language Language code of translation to fetch
	 * @param string $mirrorUrl Mirror URL to fetch data from
	 * @return mixed true on success, error string on fauilure
	 */
	public function updateTranslation($extensionKey, $language, $mirrorUrl) {
		$l10n = $this->fetchTranslation($extensionKey, $language, $mirrorUrl);
		if (is_array($l10n)) {
			$file = PATH_site . 'typo3temp' . DIRECTORY_SEPARATOR . $extensionKey . '-l10n-' . $language . '.zip';
			$path = 'l10n' . DIRECTORY_SEPARATOR . $language . DIRECTORY_SEPARATOR;
			if (!is_dir(PATH_typo3conf . $path)) {
				t3lib_div::mkdir_deep(PATH_typo3conf, $path);
			}
			t3lib_div::writeFile($file, $l10n[0]);

			t3lib_div::rmdir(PATH_typo3conf . $path . $extensionKey, TRUE);

			if ($this->unzipTranslationFile($file, PATH_typo3conf . $path)) {
				return TRUE;
			}
		}
		return FALSE;
	}

	/**
	 * Fetches an extensions l10n file from the given mirror
	 *
	 * @param string $extensionKey Extension Key
	 * @param string $language The language code of the translation to fetch
	 * @param string $mirrorUrl URL of mirror to use
	 * @return mixed Array containing l10n data or error message (string)
	 */
	protected function fetchTranslation($extensionKey, $language, $mirrorUrl) {
		$extPath = t3lib_div::strtolower($extensionKey);
		$mirrorUrl .= $extPath{0} . '/' . $extPath{1} . '/' . $extPath . '-l10n/' . $extPath . '-l10n-' . $language . '.zip';
		$l10n = t3lib_div::getURL($mirrorUrl, 0, array(TYPO3_user_agent));

		if ($l10n !== FALSE) {
			return array($l10n);
		} else {
			return 'Error: Translation could not be fetched.';
		}
	}

	/**
	 * Unzip an language.zip.
	 *
	 * @param string $file path to zip file
	 * @param string $path path to extract to
	 * @throws Tx_Lang_Exception_Lang
	 * @return boolean
	 */
	protected function unzipTranslationFile($file, $path) {
		$zip = zip_open($file);
		if (is_resource($zip)) {
			$result = TRUE;

			if (!is_dir($path)) {
				t3lib_div::mkdir_deep($path);
			}

			while (($zipEntry = zip_read($zip)) !== FALSE) {
				if (strpos(zip_entry_name($zipEntry), DIRECTORY_SEPARATOR) !== FALSE) {
					$last = strrpos(zip_entry_name($zipEntry), DIRECTORY_SEPARATOR);
					$dir = substr(zip_entry_name($zipEntry), 0, $last);
					$file = substr(zip_entry_name($zipEntry), strrpos(zip_entry_name($zipEntry), DIRECTORY_SEPARATOR) + 1);
					if (strlen(trim($file)) > 0) {
						$return = t3lib_div::writeFile(
							$path . '/' . $file, zip_entry_read($zipEntry, zip_entry_filesize($zipEntry))
						);
						if ($return === FALSE) {
							throw new Tx_Lang_Exception_Lang('Could not write file ' . $file, 1345304560);
						}
					}
				} else {
					$result = FALSE;
					t3lib_div::writeFile($path . zip_entry_name($zipEntry), zip_entry_read($zipEntry, zip_entry_filesize($zipEntry)));
				}
			}
		} else {
			throw new Tx_Lang_Exception_Lang('Unable to open zip file ' . $file, 1345304561);
		}

		return $result;
	}
}

?>