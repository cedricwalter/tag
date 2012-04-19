<?php
/**
 * @package Component Tag for Joomla! 2.5
 * @author waltercedric.com
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/
defined('_JEXEC') or die();
jimport('joomla.application.component.view');
jimport( 'joomla.filesystem.file' );


class CedTagViewStopWords extends JView
{

    function display($tpl = null)
    {
        $this->defaultTpl($tpl);
    }

    function defaultTpl($tpl = null)
    {
        JToolBarHelper::title(JText::_('STOP WORDS'), 'tag.png');
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::custom('restore', 'default', '', JText::_('RESTORE DEFAULT'), false);
        JToolBarHelper::spacer();
        JToolBarHelper::back(JText::_('CONTROL PANEL'), 'index.php?option=com_cedtag');

        $lang = "".JFactory::getLanguage()->getDefault();

        $file = JPATH_ADMINISTRATOR.'/components/com_cedtag/stopwords/stopwords_'.$lang.'.php';
        if (!is_file($file)) {
            JFile::copy(JPATH_ADMINISTRATOR.'/components/com_cedtag/stopwords/stopwords_en-GB-default.php', $file);
        }

        $isWritable = is_writable($file);

        $FileContent = trim(JFile::read($file));
        $this->assign('isWritable', $isWritable);
        $this->assignRef('FileName', $file);
        $this->assignRef('FileContent', $FileContent);

        parent::display($tpl);
    }


}
