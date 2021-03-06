<?
defined('C5_EXECUTE') or die("Access Denied.");
?>

<script type="text/javascript">
<? $ci = Loader::helper("concrete/urls"); ?>
<? $url = $ci->getBlockTypeJavaScriptURL($blockType); 
if ($url != '') { ?>
	ccm_addHeaderItem("<?=$url?>", 'JAVASCRIPT');
<? } 
$identifier = strtoupper('BLOCK_CONTROLLER_' . $btHandle);
if (is_array($headerItems[$identifier])) {
	foreach($headerItems[$identifier] as $item) { 
		if ($item instanceof CSSOutputObject) {
			$type = 'CSS';
		} else {
			$type = 'JAVASCRIPT';
		}
		?>
		ccm_addHeaderItem("<?=$item->file?>", '<?=$type?>');
	<?
	}
}
?>
</script>

<?
$hih = Loader::helper("concrete/ui/help");
$blockTypes = $hih->getBlockTypes();
if (isset($blockTypes[$btHandle])) {
	$help = $blockTypes[$btHandle];
} else {
	if ($blockTypeController->getBlockTypeHelp()) {
		$help = $blockTypeController->getBlockTypeHelp();
	}
}
if (isset($help) && !$blockType->supportsInlineAdd()) { ?>
	<div class="dialog-help" id="ccm-menu-help-content"><? 
		if (is_array($help)) { 
			print $help[0] . '<br><br><a href="' . $help[1] . '" class="btn small" target="_blank">' . t('Learn More') . '</a>';
		} else {
			print $help;
		}
	?></div>
<? } ?>

<?
if ($blockType->supportsInlineAdd()) {
    $pt = $c->getCollectionThemeObject();
    if (
        $pt->supportsGridFramework()
        && $area->isGridContainerEnabled()
        && !$blockType->ignorePageThemeGridFrameworkContainer()
    ) {

        $gf = $pt->getThemeGridFrameworkObject();
        print $gf->getPageThemeGridFrameworkContainerStartHTML();
        print $gf->getPageThemeGridFrameworkRowStartHTML();
        printf('<div class="%s">', $gf->getPageThemeGridFrameworkColumnClassForSpan(
                $gf->getPageThemeGridFrameworkNumColumns()
            ));
    }
}
?>

<div <? if (!$blockType->supportsInlineAdd()) { ?>class="ccm-ui"<? } else { ?>data-container="inline-toolbar"<? } ?>>


<form method="post" action="<?=$controller->action('submit')?>" id="ccm-block-form" enctype="multipart/form-data" class="validate">

<input type="hidden" name="btID" value="<?=$blockType->getBlockTypeID()?>">
<input type="hidden" name="arHandle" value="<?=$area->getAreaHandle()?>">
<input type="hidden" name="cID" value="<?=$c->getCollectionID()?>">

<input type="hidden" name="dragAreaBlockID" value="0" />

<? foreach($blockTypeController->getJavaScriptStrings() as $key => $val) { ?>
	<input type="hidden" name="ccm-string-<?=$key?>" value="<?=h($val)?>" />
<? } ?>

<? if (!$blockType->supportsInlineAdd()) { ?>
<div id="ccm-block-fields">
<? } else { ?>
<div>
<? } ?>

<? $blockView->render('add');?>

</div>

<? if (!$blockType->supportsInlineAdd()) { ?>	

	<div class="ccm-buttons dialog-buttons">
	<a href="javascript:void(0)" onclick="jQuery.fn.dialog.closeTop()" class="btn btn-hover-danger btn-default pull-left"><?=t('Cancel')?></a>
	<a href="javascript:void(0)" onclick="$('#ccm-form-submit-button').get(0).click()" class="pull-right btn btn-primary"><?=t('Add')?></a>
	</div>

<? } ?>

	<!-- we do it this way so we still trip javascript validation. stupid javascript. //-->
	<input type="submit" name="ccm-add-block-submit" value="submit" style="display: none" id="ccm-form-submit-button" />
</form>

</div>

<?
if ($blockType->supportsInlineAdd()) {
    $pt = $c->getCollectionThemeObject();
    if (
        $pt->supportsGridFramework()
        && $area->isGridContainerEnabled()
        && !$blockType->ignorePageThemeGridFrameworkContainer()
    ) {
        $gf = $pt->getThemeGridFrameworkObject();
        print '</div>';
        print $gf->getPageThemeGridFrameworkRowEndHTML();
        print $gf->getPageThemeGridFrameworkContainerEndHTML();
    }
}


