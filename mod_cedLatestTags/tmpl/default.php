<?php
/**
 * @package module cedLatestTags for Joomla! 2.5
 * @author waltercedric.com
 * @copyright (C) 2012 http://www.waltercedric.com 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 **/
// no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?php if (isset($list) && !empty($list)) { ?>
<div class="tagCloud<?php echo $moduleclass_sfx; ?>">

    <?php    foreach ($list as $item) { ?> <a
    href="<?php echo $item->link; ?>" rel="tag"
    style="font-size: <?php echo $item->size; ?>%;"
    class="<?php echo $item->class; ?>"
    title="<?php echo $item->ct; ?> items tagged with <?php echo $item->name; ?> | <?php echo $item->created; ?> | <?php echo $item->hits; ?> hits">
    <?php echo $item->name; ?></a> <?php }?>

    <div style="text-align: center;">
     <a href="http://www.waltercedric.com" style="font: normal normal normal 10px/normal arial; color: rgb(187, 187, 187); border-bottom-style: none; border-bottom-width: initial; border-bottom-color: initial; text-decoration: none; " onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'" target="_blank"><b>cedTag</b></a>
    </div>
</div><?php } ?>