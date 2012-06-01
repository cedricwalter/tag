<?php
/**
 * @package Component cedTag for Joomla! 2.5
 * @author waltercedric.com
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/

defined('_JEXEC') or die();
jimport('joomla.application.input');

class CedTagControllerExport extends JController
{

    function __construct()
    {
        parent::__construct();
    }

    public function execute($task)
    {
        switch ($task) {
            case 'export':
                $this->export();
                break;
            default:
                $this->display();
        }
    }

    /**
     * @param bool $cachable
     * @param bool $urlparams
     */
    public function display($cachable = false, $urlparams = false)
    {
        JFactory::getApplication()->input->set('view', 'export');
        parent::display();
    }

    private function export()
    {
        $model = $this->getModel('export');
        $input = JFactory::getApplication()->input;

        $destination = $input->get('destination', 'meta-keys');
        $exportMessage = "";
        if ($destination == 'meta-keys') {
            $exportMessage = $model->exportTagsToMetaKeys();
        } else if ($destination == 'csv') {
            $exportMessage = $model->exportTagsToCsv();
        }

        if (strlen($exportMessage) != 0) {
            $message = JText::_('We met some problems while importing tags, please check!') . $exportMessage;
        } else {
            $message = JText::_('Tags are successfully exported!');
        }
        $this->setRedirect("index.php?option=com_cedtag&controller=import", $message);
    }

}

