<?php
/**
 * @package Component cedTag for Joomla! 2.5
 * @author waltercedric.com
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/
defined('_JEXEC') or die('Restricted access');

$editor =& JFactory::getEditor();
$createdate =& JFactory::getDate();
$limitstart =
    JRequest::getVar('limitstart', '0', '', 'int');


$mainframe =& JFactory::getApplication();

// Initialize variables
$db = &JFactory::getDBO();

// Get some variables from the request
$catid = $mainframe->getUserStateFromRequest('articleelement.catid', 'catid', 0, 'int');
$search = $mainframe->getUserStateFromRequest('articleelement.search', 'search', '', 'string');
$search = JString::strtolower($search);

// get list of categories for dropdown filter
$categoryQuery = 'SELECT cc.id AS value, cc.title AS text' .
    ' FROM #__categories AS cc';
$categories[] = JHTML::_('select.option', '0', '- ' . JText::_('Select Category') . ' -');
$db->setQuery($categoryQuery);
$categories = array_merge($categories, $db->loadObjectList());
$catidFilter = JHTML::_('select.genericlist', $categories, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $catid);

$javascript = 'onchange="document.adminForm.submit();"';

?>
<script type="text/javascript">
    function autofill(tag) {
        //alert(tag.style);
    }
</script>
<form action="index.php?controller=tag&option=com_cedtag"
      method="post"
      name="adminForm"
      id="adminForm"
      class="adminForm"
      autocomplete="off">

    <table>
        <tr>
            <td width="100%"><?php echo JText::_('Filter'); ?>: <input
                type="text" name="search" id="search" value="<?php echo($search);?>"
                class="text_area" onchange="document.adminForm.submit();"/>
                <button onclick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
                <button
                    onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
            </td>
            <td nowrap="nowrap"><?php
                echo $catidFilter;
                ?></td>
        </tr>
    </table>
    <table class="adminlist">
        <thead>
        <tr>
            <th width="10" align="left"><?php echo JText::_('Num'); ?></th>
            <th class="title" width="20%"><?php echo JText::_('ARTICLE');?></th>
            <th class="title" width="10%"><?php echo JText::_('CATEGORY');?></th>
            <th><?php echo JText::_('TAGS');?></th>
        </tr>
        </thead>

        <tbody>
        <?php
        $k = 0;
        $rows = $this->tagList->list;
        if (count($rows)) {
            $combined = array();
            for ($i = 0, $n = count($rows); $i < $n; $i++) {
                $row = &$rows[$i];
                if (isset($combined[$row->cid])) {
                    $combined[$row->cid]->tag .= ',' . $row->name;
                } else {
                    if (isset($row->name)) {
                        $obj->tag = $row->name;
                    } else {
                        $obj->tag = '';
                    }
                    $obj->title = $row->title;
                    $obj->id = $row->cid;
                    $obj->category = $row->category;
                    $combined[$row->cid] = $obj;
                }
                unset($obj);
            }
            unset($rows);
            $rows = array_values($combined);
            for ($i = 0, $n = count($rows); $i < $n; $i++) {
                $row = &$rows[$i];
                JFilterOutput::objectHtmlSafe($row);
                ?>
		<tr class="<?php echo "row$k"; ?>">
			<td><?php echo  $limitstart + $i + 1  ?></td>
                <td><?php echo $row->title; ?></td>
                <td><?php echo $row->category; ?></td>

                <!-- TODO cedric size 400px css driven -->
                <td class="order">
                    <span>
                        <input type="hidden" name="id[]"
                               value="<?php echo $row->id;?>"/>
                        <input name="tag[]"
                               value="<?php echo $row->tag; ?>"
                               id="<?php echo 'tag_' . $row->id;?>"
                               type="text" size="100"
                               style="width: 400px;"
                               onclick="autofill(<?php echo 'tag_' . $row->id;?>)"/>
                    </span>
                </td>
                <?php
            }
            $k = 1 - $k;
            ?>
		</tr>

		<?php
        } else {
            ?>
        <tr>
            <td colspan="8"><?php echo JText::_('There are no Articles'); ?></td>
        </tr>
            <?php
        }

        ?>
        </tbody>

        <tfoot>
        <tr>
            <td colspan="13">
                <p class="counter">
                            <?php echo $this->pagination->getPagesCounter(); ?>
                        </p>
                <?php echo $this->pagination->getListFooter(); ?>
            </td>
        </tr>
        </tfoot>

    </table>



    <input type="hidden" name="currenttag" id="currenttag"/>
    <input type="hidden" name="boxchecked" value="0"/>
    <input type="hidden" name="task" value="">
    <input type="hidden" name="controller" value="tag">
    <?php echo JHTML::_('form.token'); ?>
    <input type="hidden" name="limitstart"/>
</form>