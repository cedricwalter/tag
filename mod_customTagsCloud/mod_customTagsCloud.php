<?php
/**
 * @package module customTagsCloud for Joomla! 2.5
 * @version $Id: mod_customTagsCloud.php 599 2010-06-06 23:26:33Z you $
 * @author waltercedric.com, Joomlatags.org
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/
// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__) . DS . 'helper.php');

$list = modCustomTagsCloudHelper::getList($params);
require(JModuleHelper::getLayoutPath('mod_customTagsCloud'));
