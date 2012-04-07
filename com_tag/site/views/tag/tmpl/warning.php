<?php

/**
 * @package Component Tag for Joomla! 2.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author waltercedric.com, Joomlatags.org
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/
defined('_JEXEC') or die('Restricted access');

$firstWarning = JRequest::getVar('FirstWarning', true);
$warning = JRequest::getVar('tagsWarning', 'FIRST_SAVE_WARNING');
if ($firstWarning) {
    $document =& JFactory::getDocument();
    $document->addStyleSheet(JURI::base() . 'media/com_tag/css/tagcloud.css');
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
