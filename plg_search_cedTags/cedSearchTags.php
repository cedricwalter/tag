<?php
/**
 * @package Plugin cedSearchTags for Joomla! 2.5
 * @author waltercedric.com
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_SITE . '/components/com_content/router.php';
require_once JPATH_SITE . '/components/com_cedtag/helper/helper.php';

class plgCedSearchTags extends JPlugin
{
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    /**
     * @return array An array of search areas
     */
    function onContentSearchAreas()
    {
        static $areas = array(
            'tags' => 'Tags'
        );
        return $areas;
    }

    /**
     * Tags Search method
     *
     * The sql must return the following fields that are
     * used in a common display routine: href, title, section, created, text,
     * browsernav
     * @param string Target search string
     * @param string mathcing option, exact|any|all
     * @param string ordering option, newest|oldest|popular|alpha|category
     * @param mixed An array if restricted to areas, null if search all
     */
    function onContentSearch($text, $phrase = '', $ordering = '', $areas = null)
    {
        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        $searchText = $text;
        if (is_array($areas)) {
            if (!array_intersect($areas, array_keys(plgSearchTagsAreas()))) {
                return array();
            }
        }

        // load plugin params info
        $plugin =& JPluginHelper::getPlugin('search', 'cedtags');
        $pluginParams = new JParameter($plugin->params);

        $limit = $pluginParams->def('search_limit', 50);

        $text = trim($text);
        if ($text == '') {
            return array();
        }

        $text = $db->Quote('%' . $db->escape($text, true) . '%', false);
        $query = 'select name,name as title,description as text from #__cedtag_term  where name like ' . $text . ' order by weight desc,name';

        $db->setQuery($query, 0, $limit);
        $rows = $db->loadObjectList();

        $count = count($rows);
        $i = 0;
        for ($i = 0; $i < $count; $i++) {


            //$link='index.php?option=com_cedtag&task=tag&tag='.urlencode($rows[$i]->name);
            $link = 'index.php?option=com_cedtag&task=tag&tag=' . CedTagsHelper::urlTagname($rows[$i]->name);
            $rows[$i]->href = JRoute::_($link);
            //print_r($rows[i]);
            $rows[$i]->section = JText::_('TAG');
        }

        $return = array();
        foreach ($rows AS $key => $tag) {
            if (searchHelper::checkNoHTML($tag, $searchText, array('name', 'title', 'text'))) {
                $return[] = $tag;
            }

        }

        return $return;
    }
}