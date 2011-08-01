<?php

########################################################################
# Extension Manager/Repository config file for ext "form".
#
# Auto generated 01-08-2011 19:23
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Form',
	'description' => 'Form Library, Plugin and Wizard',
	'category' => 'plugin',
	'shy' => 0,
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author' => 'Patrick Broens',
	'author_email' => 'patrick@patrickbroens.nl',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'version' => '0.9.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.3.0-0.0.0',
			'typo3' => '4.6.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:388:{s:9:"ChangeLog";s:4:"c5b1";s:16:"ext_autoload.php";s:4:"3d25";s:12:"ext_icon.gif";s:4:"e6ba";s:17:"ext_localconf.php";s:4:"783b";s:14:"ext_tables.php";s:4:"bfce";s:27:"Classes/Controller/Form.php";s:4:"915f";s:29:"Classes/Controller/Wizard.php";s:4:"e558";s:43:"Classes/Domain/Factory/JsonToTyposcript.php";s:4:"78cd";s:37:"Classes/Domain/Factory/Typoscript.php";s:4:"0199";s:43:"Classes/Domain/Factory/TyposcriptToJson.php";s:4:"becf";s:32:"Classes/Domain/Model/Content.php";s:4:"6cac";s:29:"Classes/Domain/Model/Form.php";s:4:"9a2d";s:44:"Classes/Domain/Model/Additional/Abstract.php";s:4:"a053";s:46:"Classes/Domain/Model/Additional/Additional.php";s:4:"220c";s:41:"Classes/Domain/Model/Additional/Error.php";s:4:"8acd";s:45:"Classes/Domain/Model/Additional/Interface.php";s:4:"6918";s:41:"Classes/Domain/Model/Additional/Label.php";s:4:"2c72";s:42:"Classes/Domain/Model/Additional/Legend.php";s:4:"39a9";s:45:"Classes/Domain/Model/Additional/Mandatory.php";s:4:"07ac";s:44:"Classes/Domain/Model/Attributes/Abstract.php";s:4:"bdfe";s:42:"Classes/Domain/Model/Attributes/Accept.php";s:4:"c653";s:49:"Classes/Domain/Model/Attributes/Acceptcharset.php";s:4:"1322";s:45:"Classes/Domain/Model/Attributes/Accesskey.php";s:4:"1bda";s:42:"Classes/Domain/Model/Attributes/Action.php";s:4:"1a44";s:39:"Classes/Domain/Model/Attributes/Alt.php";s:4:"2c09";s:46:"Classes/Domain/Model/Attributes/Attributes.php";s:4:"155f";s:43:"Classes/Domain/Model/Attributes/Checked.php";s:4:"5ff8";s:41:"Classes/Domain/Model/Attributes/Class.php";s:4:"b4cc";s:40:"Classes/Domain/Model/Attributes/Cols.php";s:4:"fd08";s:39:"Classes/Domain/Model/Attributes/Dir.php";s:4:"9b89";s:44:"Classes/Domain/Model/Attributes/Disabled.php";s:4:"6ef1";s:43:"Classes/Domain/Model/Attributes/Enctype.php";s:4:"254e";s:38:"Classes/Domain/Model/Attributes/Id.php";s:4:"d3f2";s:45:"Classes/Domain/Model/Attributes/Interface.php";s:4:"076d";s:41:"Classes/Domain/Model/Attributes/Label.php";s:4:"e2c2";s:40:"Classes/Domain/Model/Attributes/Lang.php";s:4:"06ac";s:45:"Classes/Domain/Model/Attributes/Maxlength.php";s:4:"dc20";s:42:"Classes/Domain/Model/Attributes/Method.php";s:4:"30e3";s:44:"Classes/Domain/Model/Attributes/Multiple.php";s:4:"975d";s:40:"Classes/Domain/Model/Attributes/Name.php";s:4:"8127";s:44:"Classes/Domain/Model/Attributes/Readonly.php";s:4:"2ce5";s:40:"Classes/Domain/Model/Attributes/Rows.php";s:4:"3289";s:44:"Classes/Domain/Model/Attributes/Selected.php";s:4:"3b64";s:40:"Classes/Domain/Model/Attributes/Size.php";s:4:"bdf2";s:39:"Classes/Domain/Model/Attributes/Src.php";s:4:"106b";s:41:"Classes/Domain/Model/Attributes/Style.php";s:4:"b215";s:44:"Classes/Domain/Model/Attributes/Tabindex.php";s:4:"8d1b";s:41:"Classes/Domain/Model/Attributes/Title.php";s:4:"399c";s:40:"Classes/Domain/Model/Attributes/Type.php";s:4:"b361";s:41:"Classes/Domain/Model/Attributes/Value.php";s:4:"eeb7";s:41:"Classes/Domain/Model/Element/Abstract.php";s:4:"c476";s:39:"Classes/Domain/Model/Element/Button.php";s:4:"69e6";s:41:"Classes/Domain/Model/Element/Checkbox.php";s:4:"829c";s:46:"Classes/Domain/Model/Element/Checkboxgroup.php";s:4:"3b18";s:42:"Classes/Domain/Model/Element/Container.php";s:4:"3d2c";s:40:"Classes/Domain/Model/Element/Content.php";s:4:"3f55";s:41:"Classes/Domain/Model/Element/Fieldset.php";s:4:"40b2";s:43:"Classes/Domain/Model/Element/Fileupload.php";s:4:"c9b2";s:39:"Classes/Domain/Model/Element/Hidden.php";s:4:"d948";s:44:"Classes/Domain/Model/Element/Imagebutton.php";s:4:"8761";s:41:"Classes/Domain/Model/Element/Optgroup.php";s:4:"c7b2";s:39:"Classes/Domain/Model/Element/Option.php";s:4:"c6f8";s:41:"Classes/Domain/Model/Element/Password.php";s:4:"63ac";s:38:"Classes/Domain/Model/Element/Radio.php";s:4:"62c8";s:43:"Classes/Domain/Model/Element/Radiogroup.php";s:4:"169f";s:38:"Classes/Domain/Model/Element/Reset.php";s:4:"e93d";s:39:"Classes/Domain/Model/Element/Select.php";s:4:"af80";s:39:"Classes/Domain/Model/Element/Submit.php";s:4:"3b71";s:41:"Classes/Domain/Model/Element/Textarea.php";s:4:"6862";s:41:"Classes/Domain/Model/Element/Textline.php";s:4:"df78";s:36:"Classes/Domain/Model/JSON/Button.php";s:4:"4f0e";s:38:"Classes/Domain/Model/JSON/Checkbox.php";s:4:"7643";s:43:"Classes/Domain/Model/JSON/Checkboxgroup.php";s:4:"8a83";s:39:"Classes/Domain/Model/JSON/Container.php";s:4:"f705";s:37:"Classes/Domain/Model/JSON/Element.php";s:4:"26de";s:38:"Classes/Domain/Model/JSON/Fieldset.php";s:4:"28b3";s:40:"Classes/Domain/Model/JSON/Fileupload.php";s:4:"3c2d";s:34:"Classes/Domain/Model/JSON/Form.php";s:4:"89a4";s:36:"Classes/Domain/Model/JSON/Header.php";s:4:"d7f5";s:36:"Classes/Domain/Model/JSON/Hidden.php";s:4:"1267";s:34:"Classes/Domain/Model/JSON/Name.php";s:4:"5ab3";s:38:"Classes/Domain/Model/JSON/Password.php";s:4:"e629";s:35:"Classes/Domain/Model/JSON/Radio.php";s:4:"83e0";s:40:"Classes/Domain/Model/JSON/Radiogroup.php";s:4:"6360";s:35:"Classes/Domain/Model/JSON/Reset.php";s:4:"c3d8";s:36:"Classes/Domain/Model/JSON/Select.php";s:4:"e700";s:36:"Classes/Domain/Model/JSON/Submit.php";s:4:"3f3d";s:38:"Classes/Domain/Model/JSON/Textarea.php";s:4:"d9b9";s:38:"Classes/Domain/Model/JSON/Textline.php";s:4:"01b3";s:37:"Classes/Domain/Repository/Content.php";s:4:"cb3f";s:53:"Classes/Exception/class.tx_form_exception_general.php";s:4:"fe70";s:52:"Classes/Exception/class.tx_form_exception_loader.php";s:4:"5fb0";s:48:"Classes/System/Elementcounter/Elementcounter.php";s:4:"5405";s:36:"Classes/System/Filter/Alphabetic.php";s:4:"bada";s:38:"Classes/System/Filter/Alphanumeric.php";s:4:"cb93";s:34:"Classes/System/Filter/Currency.php";s:4:"1300";s:31:"Classes/System/Filter/Digit.php";s:4:"20f8";s:32:"Classes/System/Filter/Filter.php";s:4:"e4b4";s:33:"Classes/System/Filter/Integer.php";s:4:"bbf5";s:35:"Classes/System/Filter/Interface.php";s:4:"c83e";s:35:"Classes/System/Filter/Lowercase.php";s:4:"6940";s:32:"Classes/System/Filter/Regexp.php";s:4:"c824";s:35:"Classes/System/Filter/Removexss.php";s:4:"9d39";s:39:"Classes/System/Filter/Stripnewlines.php";s:4:"5687";s:35:"Classes/System/Filter/Titlecase.php";s:4:"74eb";s:30:"Classes/System/Filter/Trim.php";s:4:"a39d";s:35:"Classes/System/Filter/Uppercase.php";s:4:"68aa";s:32:"Classes/System/Layout/Layout.php";s:4:"27fa";s:32:"Classes/System/Loader/Loader.php";s:4:"4f25";s:44:"Classes/System/Localization/Localization.php";s:4:"de46";s:37:"Classes/System/Postprocessor/Mail.php";s:4:"8078";s:46:"Classes/System/Postprocessor/Postprocessor.php";s:4:"c617";s:34:"Classes/System/Request/Request.php";s:4:"778d";s:36:"Classes/System/Validate/Abstract.php";s:4:"f5de";s:38:"Classes/System/Validate/Alphabetic.php";s:4:"424f";s:40:"Classes/System/Validate/Alphanumeric.php";s:4:"479a";s:35:"Classes/System/Validate/Between.php";s:4:"e75f";s:32:"Classes/System/Validate/Date.php";s:4:"4842";s:33:"Classes/System/Validate/Digit.php";s:4:"1bea";s:33:"Classes/System/Validate/Email.php";s:4:"d45a";s:34:"Classes/System/Validate/Equals.php";s:4:"1cc7";s:44:"Classes/System/Validate/Fileallowedtypes.php";s:4:"0eec";s:43:"Classes/System/Validate/Filemaximumsize.php";s:4:"43da";s:43:"Classes/System/Validate/Fileminimumsize.php";s:4:"3983";s:33:"Classes/System/Validate/Float.php";s:4:"189a";s:39:"Classes/System/Validate/Greaterthan.php";s:4:"5bfa";s:35:"Classes/System/Validate/Inarray.php";s:4:"2086";s:35:"Classes/System/Validate/Integer.php";s:4:"d83c";s:37:"Classes/System/Validate/Interface.php";s:4:"ca3c";s:30:"Classes/System/Validate/Ip.php";s:4:"1b86";s:34:"Classes/System/Validate/Length.php";s:4:"5e5c";s:36:"Classes/System/Validate/Lessthan.php";s:4:"c213";s:34:"Classes/System/Validate/Regexp.php";s:4:"ec03";s:36:"Classes/System/Validate/Required.php";s:4:"5601";s:31:"Classes/System/Validate/Uri.php";s:4:"1d46";s:36:"Classes/System/Validate/Validate.php";s:4:"af75";s:42:"Classes/View/Confirmation/Confirmation.php";s:4:"217c";s:51:"Classes/View/Confirmation/Additional/Additional.php";s:4:"9bdf";s:46:"Classes/View/Confirmation/Additional/Label.php";s:4:"5431";s:47:"Classes/View/Confirmation/Additional/Legend.php";s:4:"f520";s:46:"Classes/View/Confirmation/Element/Abstract.php";s:4:"82e1";s:46:"Classes/View/Confirmation/Element/Checkbox.php";s:4:"41e9";s:51:"Classes/View/Confirmation/Element/Checkboxgroup.php";s:4:"76a0";s:47:"Classes/View/Confirmation/Element/Container.php";s:4:"e199";s:46:"Classes/View/Confirmation/Element/Fieldset.php";s:4:"8168";s:48:"Classes/View/Confirmation/Element/Fileupload.php";s:4:"6fed";s:46:"Classes/View/Confirmation/Element/Optgroup.php";s:4:"b0d5";s:44:"Classes/View/Confirmation/Element/Option.php";s:4:"4357";s:43:"Classes/View/Confirmation/Element/Radio.php";s:4:"0315";s:48:"Classes/View/Confirmation/Element/Radiogroup.php";s:4:"154f";s:44:"Classes/View/Confirmation/Element/Select.php";s:4:"deac";s:46:"Classes/View/Confirmation/Element/Textarea.php";s:4:"6dc5";s:46:"Classes/View/Confirmation/Element/Textline.php";s:4:"9538";s:26:"Classes/View/Form/Form.php";s:4:"a0a8";s:43:"Classes/View/Form/Additional/Additional.php";s:4:"51ed";s:38:"Classes/View/Form/Additional/Error.php";s:4:"bc87";s:38:"Classes/View/Form/Additional/Label.php";s:4:"fa8c";s:39:"Classes/View/Form/Additional/Legend.php";s:4:"fbd0";s:42:"Classes/View/Form/Additional/Mandatory.php";s:4:"5073";s:38:"Classes/View/Form/Element/Abstract.php";s:4:"adcf";s:36:"Classes/View/Form/Element/Button.php";s:4:"0043";s:38:"Classes/View/Form/Element/Checkbox.php";s:4:"8adb";s:43:"Classes/View/Form/Element/Checkboxgroup.php";s:4:"39d1";s:39:"Classes/View/Form/Element/Container.php";s:4:"56e0";s:37:"Classes/View/Form/Element/Content.php";s:4:"ac8d";s:38:"Classes/View/Form/Element/Fieldset.php";s:4:"9e81";s:40:"Classes/View/Form/Element/Fileupload.php";s:4:"4da3";s:36:"Classes/View/Form/Element/Hidden.php";s:4:"cf94";s:41:"Classes/View/Form/Element/Imagebutton.php";s:4:"3a61";s:38:"Classes/View/Form/Element/Optgroup.php";s:4:"4905";s:36:"Classes/View/Form/Element/Option.php";s:4:"21a4";s:38:"Classes/View/Form/Element/Password.php";s:4:"4531";s:35:"Classes/View/Form/Element/Radio.php";s:4:"d739";s:40:"Classes/View/Form/Element/Radiogroup.php";s:4:"09cd";s:35:"Classes/View/Form/Element/Reset.php";s:4:"6d31";s:36:"Classes/View/Form/Element/Select.php";s:4:"a221";s:36:"Classes/View/Form/Element/Submit.php";s:4:"cf71";s:38:"Classes/View/Form/Element/Textarea.php";s:4:"6ad0";s:38:"Classes/View/Form/Element/Textline.php";s:4:"db57";s:26:"Classes/View/Mail/Mail.php";s:4:"b43e";s:31:"Classes/View/Mail/Html/Html.php";s:4:"e6b9";s:48:"Classes/View/Mail/Html/Additional/Additional.php";s:4:"fb18";s:43:"Classes/View/Mail/Html/Additional/Label.php";s:4:"e068";s:44:"Classes/View/Mail/Html/Additional/Legend.php";s:4:"ce96";s:43:"Classes/View/Mail/Html/Element/Abstract.php";s:4:"672a";s:43:"Classes/View/Mail/Html/Element/Checkbox.php";s:4:"4459";s:48:"Classes/View/Mail/Html/Element/Checkboxgroup.php";s:4:"3460";s:44:"Classes/View/Mail/Html/Element/Container.php";s:4:"a0ce";s:43:"Classes/View/Mail/Html/Element/Fieldset.php";s:4:"1916";s:45:"Classes/View/Mail/Html/Element/Fileupload.php";s:4:"21b0";s:41:"Classes/View/Mail/Html/Element/Hidden.php";s:4:"a048";s:43:"Classes/View/Mail/Html/Element/Optgroup.php";s:4:"3c06";s:41:"Classes/View/Mail/Html/Element/Option.php";s:4:"f4ce";s:40:"Classes/View/Mail/Html/Element/Radio.php";s:4:"661d";s:45:"Classes/View/Mail/Html/Element/Radiogroup.php";s:4:"1f5e";s:41:"Classes/View/Mail/Html/Element/Select.php";s:4:"ad75";s:43:"Classes/View/Mail/Html/Element/Textarea.php";s:4:"3600";s:43:"Classes/View/Mail/Html/Element/Textline.php";s:4:"b159";s:33:"Classes/View/Mail/Plain/Plain.php";s:4:"ef4d";s:44:"Classes/View/Mail/Plain/Element/Checkbox.php";s:4:"31a7";s:49:"Classes/View/Mail/Plain/Element/Checkboxgroup.php";s:4:"1dbb";s:45:"Classes/View/Mail/Plain/Element/Container.php";s:4:"90b9";s:43:"Classes/View/Mail/Plain/Element/Element.php";s:4:"70b8";s:44:"Classes/View/Mail/Plain/Element/Fieldset.php";s:4:"0dd9";s:46:"Classes/View/Mail/Plain/Element/Fileupload.php";s:4:"6577";s:42:"Classes/View/Mail/Plain/Element/Hidden.php";s:4:"087b";s:44:"Classes/View/Mail/Plain/Element/Optgroup.php";s:4:"f154";s:42:"Classes/View/Mail/Plain/Element/Option.php";s:4:"bdd3";s:41:"Classes/View/Mail/Plain/Element/Radio.php";s:4:"74f7";s:46:"Classes/View/Mail/Plain/Element/Radiogroup.php";s:4:"4e2f";s:42:"Classes/View/Mail/Plain/Element/Select.php";s:4:"1431";s:44:"Classes/View/Mail/Plain/Element/Textarea.php";s:4:"4493";s:44:"Classes/View/Mail/Plain/Element/Textline.php";s:4:"433a";s:28:"Classes/View/Wizard/Load.php";s:4:"e5f9";s:28:"Classes/View/Wizard/Save.php";s:4:"fcc4";s:30:"Classes/View/Wizard/Wizard.php";s:4:"e875";s:34:"Configuration/TypoScript/setup.txt";s:4:"697f";s:34:"Documentation/Manual/en/manual.sxw";s:4:"4fa9";s:41:"Documentation/Tests/Attributes/button.txt";s:4:"f82d";s:43:"Documentation/Tests/Attributes/checkbox.txt";s:4:"2175";s:48:"Documentation/Tests/Attributes/checkboxgroup.txt";s:4:"17a2";s:43:"Documentation/Tests/Attributes/fieldset.txt";s:4:"49ea";s:41:"Documentation/Tests/Attributes/hidden.txt";s:4:"45f6";s:46:"Documentation/Tests/Attributes/imagebutton.txt";s:4:"5d24";s:43:"Documentation/Tests/Attributes/optgroup.txt";s:4:"73f6";s:41:"Documentation/Tests/Attributes/option.txt";s:4:"9929";s:43:"Documentation/Tests/Attributes/password.txt";s:4:"aac8";s:40:"Documentation/Tests/Attributes/radio.txt";s:4:"ca33";s:45:"Documentation/Tests/Attributes/radiogroup.txt";s:4:"8880";s:40:"Documentation/Tests/Attributes/reset.txt";s:4:"e5fb";s:41:"Documentation/Tests/Attributes/select.txt";s:4:"7dad";s:41:"Documentation/Tests/Attributes/submit.txt";s:4:"e7be";s:43:"Documentation/Tests/Attributes/textarea.txt";s:4:"4d20";s:43:"Documentation/Tests/Attributes/textline.txt";s:4:"1596";s:41:"Documentation/Tests/Filter/alphabetic.txt";s:4:"8d74";s:43:"Documentation/Tests/Filter/alphanumeric.txt";s:4:"26e8";s:39:"Documentation/Tests/Filter/currency.txt";s:4:"b9e1";s:36:"Documentation/Tests/Filter/digit.txt";s:4:"bf81";s:38:"Documentation/Tests/Filter/integer.txt";s:4:"67bd";s:40:"Documentation/Tests/Filter/lowercase.txt";s:4:"8ff1";s:37:"Documentation/Tests/Filter/regexp.txt";s:4:"caa7";s:44:"Documentation/Tests/Filter/stripnewlines.txt";s:4:"4764";s:40:"Documentation/Tests/Filter/titlecase.txt";s:4:"ad50";s:35:"Documentation/Tests/Filter/trim.txt";s:4:"1ee7";s:40:"Documentation/Tests/Filter/uppercase.txt";s:4:"614c";s:40:"Documentation/Tests/Request/checkbox.txt";s:4:"edf2";s:38:"Documentation/Tests/Request/option.txt";s:4:"4c3e";s:37:"Documentation/Tests/Request/radio.txt";s:4:"e3ec";s:45:"Documentation/Tests/Validation/alphabetic.txt";s:4:"20d1";s:47:"Documentation/Tests/Validation/alphanumeric.txt";s:4:"670b";s:42:"Documentation/Tests/Validation/between.txt";s:4:"875e";s:43:"Documentation/Tests/Validation/combined.txt";s:4:"49e4";s:39:"Documentation/Tests/Validation/date.txt";s:4:"3e82";s:40:"Documentation/Tests/Validation/digit.txt";s:4:"0094";s:40:"Documentation/Tests/Validation/email.txt";s:4:"17c6";s:41:"Documentation/Tests/Validation/equals.txt";s:4:"1287";s:40:"Documentation/Tests/Validation/float.txt";s:4:"1369";s:46:"Documentation/Tests/Validation/greaterthan.txt";s:4:"ab77";s:42:"Documentation/Tests/Validation/inarray.txt";s:4:"b495";s:42:"Documentation/Tests/Validation/integer.txt";s:4:"a45d";s:37:"Documentation/Tests/Validation/ip.txt";s:4:"4770";s:41:"Documentation/Tests/Validation/length.txt";s:4:"2f6c";s:43:"Documentation/Tests/Validation/lessthan.txt";s:4:"b021";s:41:"Documentation/Tests/Validation/regexp.txt";s:4:"27de";s:43:"Documentation/Tests/Validation/required.txt";s:4:"8e1d";s:38:"Documentation/Tests/Validation/uri.txt";s:4:"8d88";s:51:"Resources/Private/Language/locallang_controller.xml";s:4:"2e36";s:47:"Resources/Private/Language/locallang_wizard.xml";s:4:"837a";s:39:"Resources/Private/Templates/Wizard.html";s:4:"de9a";s:29:"Resources/Public/CSS/Form.css";s:4:"6ddc";s:38:"Resources/Public/CSS/Wizard/Wizard.css";s:4:"726d";s:33:"Resources/Public/Images/broom.png";s:4:"b8fd";s:35:"Resources/Public/Images/captcha.jpg";s:4:"afd5";s:39:"Resources/Public/Images/cursor-move.png";s:4:"ce49";s:40:"Resources/Public/Images/drive-upload.png";s:4:"5369";s:40:"Resources/Public/Images/edit-heading.png";s:4:"7e0b";s:32:"Resources/Public/Images/mail.png";s:4:"0937";s:34:"Resources/Public/Images/remove.gif";s:4:"b34a";s:42:"Resources/Public/Images/submit-trigger.gif";s:4:"9adf";s:35:"Resources/Public/Images/tooltip.png";s:4:"b7ad";s:45:"Resources/Public/Images/ui-button-default.png";s:4:"14db";s:37:"Resources/Public/Images/ui-button.png";s:4:"b05b";s:40:"Resources/Public/Images/ui-check-box.png";s:4:"6d09";s:42:"Resources/Public/Images/ui-check-boxes.png";s:4:"712d";s:40:"Resources/Public/Images/ui-combo-box.png";s:4:"9319";s:40:"Resources/Public/Images/ui-group-box.png";s:4:"5f53";s:37:"Resources/Public/Images/ui-labels.png";s:4:"7d07";s:43:"Resources/Public/Images/ui-radio-button.png";s:4:"4577";s:44:"Resources/Public/Images/ui-radio-buttons.png";s:4:"06e7";s:47:"Resources/Public/Images/ui-scroll-pane-text.png";s:4:"b2fa";s:48:"Resources/Public/Images/ui-text-field-hidden.png";s:4:"15f3";s:50:"Resources/Public/Images/ui-text-field-password.png";s:4:"ceca";s:41:"Resources/Public/Images/ui-text-field.png";s:4:"13ae";s:43:"Resources/Public/Images/user-silhouette.png";s:4:"0fde";s:48:"Resources/Public/JavaScript/Wizard/Initialize.js";s:4:"8500";s:46:"Resources/Public/JavaScript/Wizard/Viewport.js";s:4:"fa42";s:58:"Resources/Public/JavaScript/Wizard/Elements/ButtonGroup.js";s:4:"5b57";s:56:"Resources/Public/JavaScript/Wizard/Elements/Container.js";s:4:"655e";s:52:"Resources/Public/JavaScript/Wizard/Elements/Dummy.js";s:4:"2b22";s:55:"Resources/Public/JavaScript/Wizard/Elements/Elements.js";s:4:"2ac3";s:59:"Resources/Public/JavaScript/Wizard/Elements/Basic/Button.js";s:4:"17ba";s:61:"Resources/Public/JavaScript/Wizard/Elements/Basic/Checkbox.js";s:4:"ee22";s:61:"Resources/Public/JavaScript/Wizard/Elements/Basic/Fieldset.js";s:4:"eacb";s:63:"Resources/Public/JavaScript/Wizard/Elements/Basic/Fileupload.js";s:4:"7998";s:57:"Resources/Public/JavaScript/Wizard/Elements/Basic/Form.js";s:4:"c20f";s:59:"Resources/Public/JavaScript/Wizard/Elements/Basic/Hidden.js";s:4:"f152";s:61:"Resources/Public/JavaScript/Wizard/Elements/Basic/Password.js";s:4:"d841";s:58:"Resources/Public/JavaScript/Wizard/Elements/Basic/Radio.js";s:4:"7f94";s:58:"Resources/Public/JavaScript/Wizard/Elements/Basic/Reset.js";s:4:"9697";s:59:"Resources/Public/JavaScript/Wizard/Elements/Basic/Select.js";s:4:"1cb5";s:59:"Resources/Public/JavaScript/Wizard/Elements/Basic/Submit.js";s:4:"adad";s:61:"Resources/Public/JavaScript/Wizard/Elements/Basic/Textarea.js";s:4:"00f6";s:61:"Resources/Public/JavaScript/Wizard/Elements/Basic/Textline.js";s:4:"1130";s:61:"Resources/Public/JavaScript/Wizard/Elements/Content/Header.js";s:4:"9c5b";s:71:"Resources/Public/JavaScript/Wizard/Elements/Predefined/CheckboxGroup.js";s:4:"3746";s:63:"Resources/Public/JavaScript/Wizard/Elements/Predefined/Email.js";s:4:"94f2";s:62:"Resources/Public/JavaScript/Wizard/Elements/Predefined/Name.js";s:4:"2af3";s:68:"Resources/Public/JavaScript/Wizard/Elements/Predefined/RadioGroup.js";s:4:"1233";s:53:"Resources/Public/JavaScript/Wizard/Helpers/Element.js";s:4:"903f";s:53:"Resources/Public/JavaScript/Wizard/Helpers/History.js";s:4:"3b58";s:65:"Resources/Public/JavaScript/Wizard/Ux/Ext.ux.form.spinnerfield.js";s:4:"a9fb";s:68:"Resources/Public/JavaScript/Wizard/Ux/Ext.ux.form.textfieldsubmit.js";s:4:"89be";s:64:"Resources/Public/JavaScript/Wizard/Ux/Ext.ux.grid.CheckColumn.js";s:4:"aeeb";s:64:"Resources/Public/JavaScript/Wizard/Ux/Ext.ux.grid.ItemDeleter.js";s:4:"3b01";s:76:"Resources/Public/JavaScript/Wizard/Ux/Ext.ux.grid.SingleSelectCheckColumn.js";s:4:"f629";s:61:"Resources/Public/JavaScript/Wizard/Ux/Ext.ux.isemptyobject.js";s:4:"5c21";s:53:"Resources/Public/JavaScript/Wizard/Ux/Ext.ux.merge.js";s:4:"bbb5";s:55:"Resources/Public/JavaScript/Wizard/Ux/Ext.ux.spinner.js";s:4:"92fa";s:51:"Resources/Public/JavaScript/Wizard/Viewport/Left.js";s:4:"4e0f";s:52:"Resources/Public/JavaScript/Wizard/Viewport/Right.js";s:4:"c664";s:60:"Resources/Public/JavaScript/Wizard/Viewport/Left/Elements.js";s:4:"b3fe";s:56:"Resources/Public/JavaScript/Wizard/Viewport/Left/Form.js";s:4:"8b59";s:59:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options.js";s:4:"dce9";s:66:"Resources/Public/JavaScript/Wizard/Viewport/Left/Elements/Basic.js";s:4:"905b";s:72:"Resources/Public/JavaScript/Wizard/Viewport/Left/Elements/ButtonGroup.js";s:4:"384b";s:68:"Resources/Public/JavaScript/Wizard/Viewport/Left/Elements/Content.js";s:4:"d02e";s:71:"Resources/Public/JavaScript/Wizard/Viewport/Left/Elements/Predefined.js";s:4:"e409";s:67:"Resources/Public/JavaScript/Wizard/Viewport/Left/Form/Attributes.js";s:4:"af07";s:70:"Resources/Public/JavaScript/Wizard/Viewport/Left/Form/PostProcessor.js";s:4:"a9ec";s:63:"Resources/Public/JavaScript/Wizard/Viewport/Left/Form/Prefix.js";s:4:"2cde";s:77:"Resources/Public/JavaScript/Wizard/Viewport/Left/Form/PostProcessors/Dummy.js";s:4:"b954";s:76:"Resources/Public/JavaScript/Wizard/Viewport/Left/Form/PostProcessors/Mail.js";s:4:"87c3";s:85:"Resources/Public/JavaScript/Wizard/Viewport/Left/Form/PostProcessors/PostProcessor.js";s:4:"f15f";s:65:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Dummy.js";s:4:"8ed4";s:65:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Panel.js";s:4:"2590";s:76:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Attributes.js";s:4:"d5c3";s:73:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters.js";s:4:"c774";s:71:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Label.js";s:4:"be8f";s:72:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Legend.js";s:4:"e13d";s:73:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Options.js";s:4:"87be";s:76:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation.js";s:4:"fb1e";s:73:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Various.js";s:4:"f829";s:84:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/Alphabetic.js";s:4:"fdfc";s:86:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/Alphanumeric.js";s:4:"edac";s:82:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/Currency.js";s:4:"7a03";s:79:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/Digit.js";s:4:"3b60";s:79:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/Dummy.js";s:4:"b654";s:80:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/Filter.js";s:4:"2e93";s:81:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/Integer.js";s:4:"2e0a";s:83:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/LowerCase.js";s:4:"285a";s:80:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/RegExp.js";s:4:"42a9";s:83:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/RemoveXSS.js";s:4:"3afe";s:87:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/StripNewLines.js";s:4:"f708";s:83:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/TitleCase.js";s:4:"29b1";s:78:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/Trim.js";s:4:"82c7";s:83:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Filters/UpperCase.js";s:4:"f301";s:87:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Alphabetic.js";s:4:"558b";s:89:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Alphanumeric.js";s:4:"47a9";s:84:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Between.js";s:4:"753f";s:81:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Date.js";s:4:"0452";s:82:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Digit.js";s:4:"9c7d";s:82:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Dummy.js";s:4:"6b63";s:82:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Email.js";s:4:"72c6";s:83:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Equals.js";s:4:"443b";s:93:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/FileAllowedTypes.js";s:4:"781a";s:92:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/FileMaximumSize.js";s:4:"6c3f";s:92:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/FileMinimumSize.js";s:4:"255e";s:82:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Float.js";s:4:"0b40";s:88:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/GreaterThan.js";s:4:"323a";s:84:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/InArray.js";s:4:"664d";s:84:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Integer.js";s:4:"0c75";s:79:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Ip.js";s:4:"87eb";s:83:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Length.js";s:4:"5390";s:85:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/LessThan.js";s:4:"4e6f";s:83:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/RegExp.js";s:4:"5939";s:85:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Required.js";s:4:"67b5";s:81:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Rule.js";s:4:"82da";s:80:"Resources/Public/JavaScript/Wizard/Viewport/Left/Options/Forms/Validation/Uri.js";s:4:"3b14";}',
	'suggests' => array(
	),
);

?>