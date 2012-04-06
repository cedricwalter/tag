<?php
/**
 * @package Component Tag for Joomla! 2.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author waltercedric.com, Joomlatags.org
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/

defined('_JEXEC') or die();

class TagControllerImport extends JController
{

    function __construct()
    {
        parent::__construct();
    }

    function execute($task)
    {
        switch ($task) {
            case 'import':
                $this->import();
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
        JRequest::setVar('view', 'import');
        parent::display();
    }


    function import()
    {
        $model = $this->getModel('import');
        $ok = false;

        $jinput = JFactory::getApplication()->input;
        $source = $jinput->get('source', 'meta-keys');
        if ($source == 'meta-keys') {
            $ok = $model->importTagsFromMetaKeys();
        } else if ($source == 'jtags') {
            $ok = $model->importTagsFromJTags();
        }
        //need specail handle on the msg and method calls when add more sources.
        $msg = "";
        if ($ok) {
            $msg = JText::_('We met some problems while importing tags, please check!');
        } else {
            $msg = JText::_('Tags are successfully imported!');
        }
        //parent::display();
        $this->setRedirect("index.php?option=com_tag&controller=import", $msg);
    }

}

?>
