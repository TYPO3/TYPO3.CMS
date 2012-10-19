<?php
namespace TYPO3\CMS\Core\Resource\Processing;

use \TYPO3\CMS\Core\Resource;
use \TYPO3\CMS\Core\Utility;

/**
 * Processes Local Images files
 */
class LocalImageProcessor implements Processor {

	/**
	 * @var \TYPO3\CMS\Core\Log\Logger
	 */
	protected $logger;

	/**
	 * Constructor
	 */
	public function __construct() {
		/** @var $logManager \TYPO3\CMS\Core\Log\LogManager */
		$logManager = Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager');
		$this->logger = $logManager->getLogger(__CLASS__);
	}

	/**
	 * @param Task $task
	 *
	 * @return boolean
	 */
	public function canProcessTask(Task $task) {
		return $task->getType() === 'Image';
	}

	/**
	 * @param Task $task
	 *
	 * @throws \InvalidArgumentException
	 */
	public function processTask(Task $task) {
		if (!$this->canProcessTask($task)) {
			throw new \InvalidArgumentException('Cannot process task of type "' . $task->getType() . '"', 1350570620);
		}

		switch ($task->getName()) {
			case 'Preview':
				$helper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Resource\Processing\LocalPreviewHelper', $this);

				break;
			case 'CropScaleMask':
				$helper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Resource\Processing\LocalCropScaleMaskHelper', $this);

				break;
			default:
				throw new \InvalidArgumentException('Cannot process task of type "' . $task->getType() . '.' . $task->getName() . '"', 1350570621);
		}

		try {
			$result = $helper->process($task);

			if ($result === NULL) {
				$task->getTargetFile()->setUsesOriginalFile();
			} elseif (file_exists($result['filePath'])) {
				$graphicalFunctions = $this->getGraphicalFunctionsObject();
				$imageDimensions = $graphicalFunctions->getImageDimensions($result['filePath']);

				$task->getTargetFile()->setName($task->getTargetFileName());
				$task->getTargetFile()->updateProperties(
					array('width' => $imageDimensions[0], 'height' => $imageDimensions[1], 'size' => filesize($result['filePath']))
				);
				$task->getTargetFile()->updateWithLocalFile($result['filePath']);
			}
		} catch (\Exception $e) {}
	}

	/**
	 * Escapes a file name so it can safely be used on the command line.
	 *
	 * @param string $inputName filename to safeguard, must not be empty
	 * @return string $inputName escaped as needed
	 *
	 * @internal Don't use this method from outside the LocalImageProcessor!
	 */
	public function wrapFileName($inputName) {
		if ($GLOBALS['TYPO3_CONF_VARS']['SYS']['UTF8filesystem']) {
			$currentLocale = setlocale(LC_CTYPE, 0);
			setlocale(LC_CTYPE, $GLOBALS['TYPO3_CONF_VARS']['SYS']['systemLocale']);
			$escapedInputName = escapeshellarg($inputName);
			setlocale(LC_CTYPE, $currentLocale);
		} else {
			$escapedInputName = escapeshellarg($inputName);
		}
		return $escapedInputName;
	}

	/**
	 * Creates error image based on gfx/notfound_thumb.png
	 * Requires GD lib enabled, otherwise it will exit with the three
	 * textstrings outputted as text. Outputs the image stream to browser and exits!
	 *
	 * @param string $filename Name of the file
	 * @param string $textline1 Text line 1
	 * @param string $textline2 Text line 2
	 * @param string $textline3 Text line 3
	 * @return void
	 * @throws \RuntimeException
	 *
	 * @internal Don't use this method from outside the LocalImageProcessor!
	 */
	public function getTemporaryImageWithText($filename, $textline1, $textline2, $textline3) {
		if (!$GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib']) {
			throw new \RuntimeException('TYPO3 Fatal Error: No gdlib. ' . $textline1 . ' ' . $textline2 . ' ' . $textline3, 1270853952);
		}
		// Creates the basis for the error image
		if ($GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib_png']) {
			$im = imagecreatefrompng(PATH_typo3 . 'gfx/notfound_thumb.png');
		} else {
			$im = imagecreatefromgif(PATH_typo3 . 'gfx/notfound_thumb.gif');
		}
		// Sets background color and print color.
		$white = imageColorAllocate($im, 255, 255, 255);
		$black = imageColorAllocate($im, 0, 0, 0);
		// Prints the text strings with the build-in font functions of GD
		$x = 0;
		$font = 0;
		if ($textline1) {
			imagefilledrectangle($im, $x, 9, 56, 16, $white);
			imageString($im, $font, $x, 9, $textline1, $black);
		}
		if ($textline2) {
			imagefilledrectangle($im, $x, 19, 56, 26, $white);
			imageString($im, $font, $x, 19, $textline2, $black);
		}
		if ($textline3) {
			imagefilledrectangle($im, $x, 29, 56, 36, $white);
			imageString($im, $font, $x, 29, substr($textline3, -14), $black);
		}
		// Outputting the image stream and exit
		if ($GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib_png']) {
			imagePng($im, $filename);
		} else {
			imageGif($im, $filename);
		}
	}

	/**
	 * @return \TYPO3\CMS\Core\Imaging\GraphicalFunctions
	 */
	protected function getGraphicalFunctionsObject() {
		static $graphicalFunctionsObject = NULL;

		if ($graphicalFunctionsObject === NULL) {
			$graphicalFunctionsObject = Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Imaging\\GraphicalFunctions');
		}

		return $graphicalFunctionsObject;
	}
}

?>