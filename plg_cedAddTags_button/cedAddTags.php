<?php
/**
 * @package Plugin cedAddTags for Joomla! 2.5
 * @author waltercedric.com
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.event.plugin');

class plgButtonCedAddTags extends JPlugin
{

    function plgCedAddTags(& $subject, $config)
    {
        parent::__construct($subject, $config);
    }

    /**
     * Add Attachment button
     *
     * @return a button
     */
    function onDisplay($name)
    {
        // Avoid displaying the button for anything except content articles
        $option = JRequest::getVar('option');
        if ($option != 'com_content') {
            return new JObject();
        }

        // Get the article ID
        $cid = JRequest::getVar('cid', array(0), '', 'array');
        $id = 0;
        if (count($cid) > 0) {
            $id = intval($cid[0]);
        }
        if ($id == 0) {
            $nid = JRequest::getVar('id', null);
            if (!is_null($nid)) {
                $id = intval($nid);
            }
        }

        JHtml::_('behavior.modal');

        // Create the button object
        $button = new JObject();

        // Figure out where we are and construct the right link and set
        // up the style sheet (to get the visual for the button working)
        $document = & JFactory::getDocument();
        $app = JFactory::getApplication();
        if ($app->isAdmin()) {
            $document->addStyleSheet(JURI::base() . 'components/com_cedtag/css/tag.css');

            if ($id == 0) {
                $button->set('options', "{handler: 'iframe', size: {x: 400, y: 300}}");
                $link = "index.php?option=com_cedtag&controller=tag&task=warning&tmpl=component&tagsWarning=FIRST_SAVE_WARNING";
            }
            else {
                $button->set('options', "{handler: 'iframe', size: {x: 500, y: 300}}");
                $link = "index.php?option=com_cedtag&controller=tag&task=add&article_id=" . $id . "&tmpl=component";
            }
        }
        else {
            $document->addStyleSheet(JURI::base() . 'components/com_cedtag/css/tagcloud.css');

            //return $button;
            if ($id == 0) {
                $button->set('options', "{handler: 'iframe', size: {x: 400, y: 300}}");
                $msg = JText::_('SAVE ARTICLE BEFORE ADD TAGS');
                $link = "index.php?option=com_cedtag&task=warning&tmpl=component&tagsWarning=FIRST_SAVE_WARNING";
            }
            else {
                $button->set('options', "{handler: 'iframe', size: {x: 500, y: 300}}");
                $link = "index.php?option=com_cedtag&task=add&article_id=" . $id;
            }
        }

        //JRequest::setVar('tagsWarning','FIRST_SAVE_WARNING');

        $button->set('modal', true);
        $button->set('class', 'modal');
        $button->set('text', JText::_('Add Tags'));
        $button->set('name', 'add_Tags');
        $button->set('link', $link);
        //$button->set('image', '');

        return $button;
    }
}

?>