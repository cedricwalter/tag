<?php
/**
 * @package Component cedTag for Joomla! 2.5
 * @author waltercedric.com
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/
defined('_JEXEC') or die();

jimport('joomla.application.controller');
jimport( 'joomla.application.input' );

class CedTagControllerTerm extends JController
{
    function __construct()
    {
        parent::__construct();
    }

    public function execute($task)
    {
        switch ($task) {
            case 'save':
                $this->save();
                break;
            case 'edit':
            case 'add':
                $this->edit();
                break;
            case 'remove':
                $this->remove();
                break;
            case 'batchadd':
                $this->batchAdd();
                break;
            case 'batchsave':
                $this->batchSave();
                break;
            default:
                $this->display();
        }
    }

    /**
     * display the form
     * @return void
     */
    public function display($cachable = false, $urlparams = false)
    {
        JFactory::getApplication()->input->set('view', 'term');
        parent::display();
    }


    /**
     * save categories
     */
    function save()
    {
        $input = JFactory::getApplication()->input;
        $id = $input->get('cid', 0, 'POST');
        $name = $input->get('name', '', 'POST');
        $description = $input->get('description', '', 'POST', 'string', JREQUEST_ALLOWHTML);
        $weight = $input->get('weight', '', 'POST');
        $model = $this->getModel('term');
        $isOk = true;
        if (isset($id[0]) && $id[0]) {
            $isOk = $model->update($id[0], $name, $description, $weight);
        } else {
            $isOk = $model->store($name, $description, $weight);
        }
        if (!$isOk) {
            $msg = JText::_('TERM COULD NOT BE CREATED PLEASE CHECK');
        } else {
            $msg = JText::_('TERM SUCCESSFULLY CREATED');
        }
        $this->setRedirect("index.php?option=com_cedtag&controller=term", $msg);

        //$this->getEditor()->save($this->description);
    }

    function edit()
    {
        JFactory::getApplication()->input->set('view', 'term');
        JFactory::getApplication()->input->set('layout', 'edit');
        parent::display();
    }

    function remove()
    {
        $input = JFactory::getApplication()->input;
        $ids = $input->get('cid', 0, 'POST');
        $model = $this->getModel('term');
        if (!$model->remove($ids)) {
            $msg = JText::_('TERM COULD NOT BE REMOVED PLEASE CHECK');
        } else {
            $msg = JText::_('TERM SUCCESSFULLY REMOVED');
        }
        $this->setRedirect("index.php?option=com_cedtag&controller=term", $msg);
    }

    function batchAdd()
    {
        JFactory::getApplication()->input->set('view', 'term');
        JFactory::getApplication()->input->set('layout', 'batchadd');
        parent::display();

    }

    function batchSave()
    {
        $input = JFactory::getApplication()->input;
        $terms = $input->get('names', '', 'POST');
        $msg = null;
        $terms = trim($terms);
        if (isset($terms) && $terms) {
            $model = $this->getModel('term');
            $isOk = $model->insertTerms($terms);

            if (!$isOk) {
                $msg = JText::_('TERMS COULD NOT BE CREATED PLEASE CHECK, Tems <').$terms.JText::_('> IS/ARE INVALID OR IN EXCLUDED LIST');
            } else {
                $msg = JText::_('TERMS <').$terms.JText::_('> SUCCESSFULLY CREATED');
            }
        } else {
            $msg = JText::_('TERMS CAN NOT BE BLANK');
        }
        $this->setRedirect("index.php?option=com_cedtag&controller=term", $msg);

    }
}

?>
