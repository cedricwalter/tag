<?php

/**
 * @package Component cedTag for Joomla! 2.5
 * @author waltercedric.com
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/
defined('_JEXEC') or die('Restricted access');

$firstWarning = JRequest::getVar('FirstWarning', true);
$warning = JRequest::getVar('tagsWarning', 'FIRST_SAVE_WARNING');
if ($firstWarning) {
    $document =& JFactory::getDocument();
    $document->addStyleSheet(JURI::base() . 'media/com_cedtag/css/tagcloud.css');
    ?>

<div class="warning">
    <h1><?php echo JText::_('WARNING');?></h1>

    <h2><?php echo JText::_($warning);?></h2>

</div>
<!-- Tags for Joomla by www.waltercedric.com -->

<?php
}
;
JFactory::getApplication()->input->set('FirstWarning', false);
?>
