<?php
/**
 * @package Component Tag for Joomla! 2.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author waltercedric.com, Joomlatags.org
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/


defined('_JEXEC') or die();

class TagControllerCss extends JController
{

    function execute($task)
    {
        switch ($task) {
            case 'save':
                $this->save();
                break;
            case 'restore':
                $this->restore();
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
        JRequest::setVar('view', 'css');
        parent::display();
    }


    function save()
    {

        $updatedCss = $_POST['csscontent'];
        $tagCssFile = JPATH_SITE.'media/com_tag/css/tagcloud.css';
        file_put_contents($tagCssFile, $updatedCss);

        JRequest::setVar('view', 'css');
        parent::display();

    }

    function restore()
    {
        $tagCssFile = JPATH_SITE.'media/com_tag/css/tagcloud.css';
        $defaultCssFile = JPATH_SITE . '/media/com_tag/css/tagcloud.default.css';
        $defaultCssFileContent = file_get_contents($defaultCssFile);
        file_put_contents($tagCssFile, $defaultCssFileContent);

        JRequest::setVar('view', 'css');
        parent::display();
    }

}

?>
