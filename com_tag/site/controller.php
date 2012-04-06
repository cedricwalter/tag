<?php
/**
 * @package Component Tag for Joomla! 2.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author waltercedric.com, Joomlatags.org
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');


class TagController extends JController
{
    function execute($task)
    {

        switch ($task) {
            case 'tag':
                $this->display();
                break;
            case 'save':
                $this->save();
                break;
            case 'add':
                $this->add();
                break;

            case 'warning':
                $this->warning();
                break;
            case 'tags':
                $this->allTags();
                break;
            default:
                $this->display();
        }

    }

    /**
     * Method to show the search view
     *
     * @access    public
     * @since    1.5
     */
    function display()
    {
        $view = JRequest::getVar('view');
        //Set default view
        if (!isset($view)) {
            JRequest::setVar('view', 'tag');
        }
        parent::display();
    }

    function allTags()
    {
        JRequest::setVar('view', 'alltags');
        parent::display();
    }

    function warning()
    {
        JRequest::setVar('view', 'tag');
        JRequest::setVar('layout', 'warning');
        parent::display();
    }

    function add()
    {
        JRequest::setVar('view', 'tag');
        JRequest::setVar('layout', 'add');
        JRequest::setVar('tmpl', 'component');
        $document = & JFactory::getDocument();
        parent::display();
    }

    function save()
    {

        $id = JRequest::getVar('cid');
        $tags = JRequest::getVar('tags');
        $combined = array();
        $combined[$id] = $tags;


        $message = "";
        JModel::addIncludePath(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_tag' . DS . 'models');
        $model = $this->getModel('tag');
        $ok = $model->batchUpdate($combined);
        if ($ok) {
            $message = JText::_('Tags could not be Saved, please check!');
        } else {
            $message = JText::_('Tags successfully saved!');
        }

        // echo('<script> alert("'.$msg.'"); window.history.go(-1); </script>');
        $refresh = JRequest::getVar('refresh');
        $script = "<script>window.parent.document.getElementById('sbox-window').close();";
        if ($refresh) {
            $script .= "window.parent.location.reload();";
        }
        $script .= "</script>";
        echo $script;
        exit();
        //parent::display();
        //$this->setRedirect( "index2.php?option=com_content&sectionid=-1&task=edit&cid[]=".$id,$msg );
    }
}
