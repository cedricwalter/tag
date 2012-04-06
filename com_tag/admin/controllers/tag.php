<?php
/**
 * @package Component Tag for Joomla! 2.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author waltercedric.com, Joomlatags.org
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/

defined('_JEXEC') or die();

class TagControllerTag extends JController
{

    function execute($task)
    {
        switch ($task) {
            case 'batchsave':
                $this->batchSave();
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
            case 'clearall':
                $this->clearAll();
                break;

            default:
                $this->display();
        }

    }

    /**
     * display the form
     * @return void
     */
    function display()
    {
        JRequest::setVar('view', 'tag');
        parent::display();
    }

    function batchSave()
    {

        $ids = JRequest::getVar('id', array(0), 'POST', 'array');
        $tags = JRequest::getVar('tag', array(0), 'POST', 'array');
        $combined = $this->array_combine($ids, $tags);

        $model = $this->getModel('tag');
        $msg = "";

        $ok = $model->batchUpdate($combined);
        if ($ok) {
            $msg = JText::_('TAGS COULD NOT BE SAVED PLEASE CHECK');
        } else {
            $msg = JText::_('TAGS SUCCESSFULLY SAVED');
        }
        //parent::display();
        $this->setRedirect("index.php?option=com_tag&controller=tag", $msg);
    }

    function clearAll()
    {
        $msg = JText::_('ALL TAGS REMOVED');
        $model = $this->getModel('tag');
        $model->clearAll();

        //parent::display();
        $this->setRedirect("index.php?option=com_tag&controller=tag", $msg);

    }

    function save()
    {

        $id = JRequest::getVar('cid');
        $tags = JRequest::getVar('tags');
        $combined = array();
        $combined[$id] = $tags;


        $model = $this->getModel('tag');
        $msg = "";

        $ok = $model->batchUpdate($combined);
        if ($ok) {
            $msg = JText::_('TAGS COULD NOT BE SAVED PLEASE CHECK');
        } else {
            $msg = JText::_('TAGS SUCCESSFULLY SAVED');
        }

        // echo('<script> alert("'.$msg.'"); window.history.go(-1); </script>');

        echo "<script>window.parent.document.getElementById('sbox-window').close()</script>";
        exit();
        //parent::display();
        //$this->setRedirect( "index.php?option=com_content&sectionid=-1&task=edit&cid[]=".$id,$msg );
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

    function array_combine($keys, $values)
    {
        $result = array();
        foreach (array_map(null, $keys, $values) as $pair) {
            $result[$pair[0]] = $pair[1];
        }
        return $result;
    }


}

?>
