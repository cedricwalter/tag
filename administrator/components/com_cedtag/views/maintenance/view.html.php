<?php
/**
 * @package Component Tag for Joomla! 2.5
 * @author waltercedric.com
 * @copyright (C) 2012 http://www.waltercedric.com 2010
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/

defined('_JEXEC') or die();
jimport('joomla.application.component.view');

// userhelper for acl
require_once JPATH_SITE . '/administrator/components/com_users/helpers/users.php';

class CedTagViewMaintenance extends JView
{

    function display($tpl = null)
    {
        $this->defaultTpl($tpl);
    }

    function defaultTpl($tpl = null)
    {
        $this->addToolbar();

        $editor = JFactory::getEditor();
        $this->assignRef('editor', $editor);

        parent::display($tpl);
    }

    function addToolbar()
    {
        JToolBarHelper::title(JText::_('Maintenance'), 'tag.png');

        $canDo = UsersHelper::getActions();
        /*
         if ($canDo->get('core.create')) {
            $bar = JToolBar::getInstance('toolbar');
            $bar->appendButton('Confirm', JText::_('Are you sure?'), 'execute', JText::_('Execute'), 'execute', false);
            JToolBarHelper::spacer();
            JToolBarHelper::divider();
        }
        */
        JToolBarHelper::back(JText::_('CEDTAG_CONTROL_PANEL'), 'index.php?option=com_cedtag');

    }


}
