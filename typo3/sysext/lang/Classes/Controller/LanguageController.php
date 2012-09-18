<?php
namespace TYPO3\CMS\Lang\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Sebastian Fischer <typo3@evoweb.de>
 *      2012 Kai Vogel <kai.vogel@speedprogs.de>
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
 * Language controller handling the selection of available languages and update of extension translations
 *
 * @author Sebastian Fischer <typo3@evoweb.de>
 * @author Kai Vogel <kai.vogel@speedprogs.de>
 * @package lang
 * @subpackage LanguageController
 */
class LanguageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * Status codes for AJAX response
	 */
	const TRANSLATION_NOT_AVAILABLE = 0;
	const TRANSLATION_AVAILABLE = 1;
	const TRANSLATION_FAILED = 2;
	const TRANSLATION_OK = 3;
	const TRANSLATION_INVALID = 4;

	/**
	 * @var \TYPO3\CMS\Lang\Domain\Repository\LanguageRepository
	 */
	protected $languageRepository;

	/**
	 * @var \TYPO3\CMS\Lang\Domain\Repository\ExtensionRepository
	 */
	protected $extensionRepository;

	/**
	 * @var \TYPO3\CMS\Extensionmanager\Utility\Repository\Helper
	 */
	protected $repositoryHelper;

	/**
	 * @var \TYPO3\CMS\Lang\Utility\Connection\Ter
	 */
	protected $terConnection;

	/**
	 * @var \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface
	 */
	protected $cache;

	/**
	 * @var array
	 */
	protected $icons = array();

	/**
	 * Keep cache for one day
	 * @var integer
	 */
	protected $cacheLifetime = 86400;

	/**
	 * JSON actions
	 * @var array
	 */
	protected $jsonActions = array('checkTranslation', 'updateTranslation');

	/**
	 * Inject the language repository
	 *
	 * @param \TYPO3\CMS\Lang\Domain\Repository\LanguageRepository $repository
	 * @return void
	 */
	public function injectLanguageRepository(\TYPO3\CMS\Lang\Domain\Repository\LanguageRepository $repository) {
		$this->languageRepository = $repository;
	}

	/**
	 * Inject the extension repository
	 *
	 * @param \TYPO3\CMS\Lang\Domain\Repository\ExtensionRepository $repository
	 * @return void
	 */
	public function injectExtensionRepository(\TYPO3\CMS\Lang\Domain\Repository\ExtensionRepository $repository) {
		$this->extensionRepository = $repository;
	}

	/**
	 * Inject the repository helper
	 *
	 * @param \TYPO3\CMS\Extensionmanager\Utility\Repository\Helper $repositoryHelper
	 * @return void
	 */
	public function injectRepositoryHelper(\TYPO3\CMS\Extensionmanager\Utility\Repository\Helper $repositoryHelper) {
		$this->repositoryHelper = $repositoryHelper;
	}

	/**
	 * Inject the repository helper
	 *
	 * @param \TYPO3\CMS\Lang\Utility\Connection\Ter $terConnection
	 * @return void
	 */
	public function injectTerConnection(\TYPO3\CMS\Lang\Utility\Connection\Ter $terConnection) {
		$this->terConnection = $terConnection;
	}

	/**
	 * Force JSON output for defined actions
	 *
	 * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view The view to be initialized
	 * @return void
	 */
	protected function initializeView(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view) {
		$actionName = $this->request->getControllerActionName();
		if (in_array($actionName, $this->jsonActions)) {
			$viewObjectName = 'TYPO3\\CMS\\Lang\\View\\Language\\' . ucfirst($actionName) . 'Json';
			$this->view = $this->objectManager->create($viewObjectName);
			$this->view->setControllerContext($this->controllerContext);
			$this->view->initializeView();
		}
	}

	/**
	 * Initialize cache frontend
	 *
	 * @return void
	 */
	public function initializeAction() {
		$cacheIdentifier = $this->request->getControllerExtensionKey();
		$cacheFrontend = $GLOBALS['typo3CacheManager'];
		if (!$cacheFrontend->hasCache($cacheIdentifier)) {
			throw new \Exception('The cache with identifier "' . $cacheIdentifier . '" is not available.', 1341301708);
		}
		$this->cache = $cacheFrontend->getCache($cacheIdentifier);
	}

	/**
	 * Index action
	 *
	 * @param \TYPO3\CMS\Lang\Domain\Model\LanguageSelectionForm $languageSelectionForm
	 * @param mixed $extensions Extensions to show in form
	 * @return void
	 * @dontvalidate $languageSelectionForm
	 * @dontvalidate $extensions
	 */
	public function indexAction(\TYPO3\CMS\Lang\Domain\Model\LanguageSelectionForm $languageSelectionForm = NULL, $extensions = NULL) {
		if ($languageSelectionForm === NULL) {
			$languageSelectionForm = $this->objectManager->create('TYPO3\\CMS\\Lang\\Domain\\Model\\LanguageSelectionForm');
			$languageSelectionForm->setLanguages($this->languageRepository->findAll());
			$languageSelectionForm->setSelectedLanguages($this->languageRepository->findSelected());
		}

		if (empty($extensions)) {
			$extensions = $this->extensionRepository->findAll();
		}

		$this->view->assign('languageSelectionForm', $languageSelectionForm);
		$this->view->assign('extensions', $extensions);
	}

	/**
	 * Update the language selection form
	 *
	 * @param \TYPO3\CMS\Lang\Domain\Model\LanguageSelectionForm $languageSelectionForm
	 * @return void
	 * @dontvalidate $languageSelectionForm
	 */
	public function updateLanguageSelectionAction(\TYPO3\CMS\Lang\Domain\Model\LanguageSelectionForm $languageSelectionForm) {
		if ($languageSelectionForm !== NULL) {
			$this->languageRepository->updateSelectedLanguages($languageSelectionForm->getSelectedLanguages());
		}
		$this->redirect('index');
	}


	/**
	 * Check translation state for one extension
	 *
	 * @param string $extension The extension key
	 * @param string $locale The locale to check
	 * @param boolean $update Update translations if is TRUE
	 * @return void
	 */
	public function checkTranslationAction($extension, $locale, $update = FALSE) {
		$state = static::TRANSLATION_INVALID;
		$error = '';

		try {
			$state = $this->getTranslationStateForExtension($extension, $locale);
			if ($update && $state === static::TRANSLATION_AVAILABLE) {
				$state = $this->updateTranslationForExtension($extension, $locale);
			}
		} catch (\Exception $exception) {
			$error = $exception->getMessage();
		}

		$this->view->assign('extension', $extension);
		$this->view->assign('locale', $locale);
		$this->view->assign('state', $state);
		$this->view->assign('error', $error);
	}

	/**
	 * Update translation for one extension
	 *
	 * @param string $extension The extension key
	 * @param string $locale The locale to update
	 * @return void
	 */
	public function updateTranslationAction($extension, $locale) {
		$this->checkTranslationAction($extension, $locale, TRUE);
	}

	/**
	 * Returns the translation state for an extension
	 *
	 * @param string $extensionKey The extension key
	 * @param string $locale Locale to return
	 * @return integer Translation state
	 */
	protected function getTranslationStateForExtension($extensionKey, $locale) {
		if (empty($extensionKey) || empty($locale)) {
			return static::TRANSLATION_INVALID;
		}

		$identifier = 'translationState-' .  $extensionKey . '-' . $locale;
		if ($this->cache->has($identifier)) {
			return $this->cache->get($identifier);
		}

		$selectedLanguages = $this->languageRepository->findSelected();
		if (empty($selectedLanguages)) {
			return static::TRANSLATION_INVALID;
		}

		$mirrorUrl = $this->repositoryHelper->getMirrors()->getMirrorUrl();
		$status = $this->terConnection->fetchTranslationStatus($extensionKey, $mirrorUrl);
		$states = array();

		foreach ($selectedLanguages as $language) {
			$locale = $language->getLocale();

			if (empty($status[$locale]) || !is_array($status[$locale])) {
				$states[$locale] = static::TRANSLATION_NOT_AVAILABLE;
				continue;
			}

			$md5 = $this->getTranslationFileMd5($extensionKey, $locale);
			if ($md5 !== $status[$locale]['md5']) {
				$states[$locale] = static::TRANSLATION_AVAILABLE;
				continue;
			}

			$states[$locale] = static::TRANSLATION_OK;
		}

		if (!isset($states[$locale])) {
			$states[$locale] = static::TRANSLATION_INVALID;
		}

		foreach ($states as $locale => $state) {
			$identifier = 'translationState-' .  $extensionKey . '-' . $locale;
			$this->cache->set($identifier, $state, array(), $this->cacheLifetime);
		}

		return $states[$locale];
	}

	/**
	 * Returns the md5 of a translation file
	 *
	 * @param string $extensionKey The extension key
	 * @param string $locale The locale
	 * @return string The md5 value
	 */
	protected function getTranslationFileMd5($extensionKey, $locale) {
		if (empty($extensionKey) || empty($locale)) {
			return '';
		}
		$fileName = PATH_site . 'typo3temp' . DIRECTORY_SEPARATOR . $extensionKey . '-l10n-' . $locale . '.zip';
		if (is_file($fileName)) {
			return md5_file($fileName);
		}
		return '';
	}

	/**
	 * Update the translation for an extension
	 *
	 * @param string $extensionKey The extension key
	 * @param string $locale Locale to update
	 * @return integer Translation state
	 */
	protected function updateTranslationForExtension($extensionKey, $locale) {
		if (empty($extensionKey) || empty($locale)) {
			return static::TRANSLATION_INVALID;
		}

		$state = static::TRANSLATION_FAILED;
		$mirrorUrl = $this->repositoryHelper->getMirrors()->getMirrorUrl();
		$updateResult = $this->terConnection->updateTranslation($extensionKey, $locale, $mirrorUrl);
		if ($updateResult === TRUE) {
			$state = static::TRANSLATION_OK;
		}

		$identifier = 'translationState-' .  $extensionKey . '-' . $locale;
		$this->cache->set($identifier, $state, array(), $this->cacheLifetime);

		return $state;
	}

}
?>