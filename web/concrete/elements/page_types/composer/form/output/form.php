<?
defined('C5_EXECUTE') or die("Access Denied.");
use \Concrete\Core\Page\Type\Composer\FormLayoutSet as PageTypeComposerFormLayoutSet;
use \Concrete\Core\Page\Type\Composer\FormLayoutSetControl as PageTypeComposerFormLayoutSetControl;
$fieldsets = PageTypeComposerFormLayoutSet::getList($pagetype);
$cmp = new Permissions($pagetype);
?>

<div class="ccm-ui">

<div class="alert alert-info" style="display: none" id="ccm-page-type-composer-form-save-status"></div>

<? foreach($fieldsets as $cfl) { ?>
	<fieldset>
		<? if ($cfl->getPageTypeComposerFormLayoutSetDisplayName()) { ?>
			<legend><?=$cfl->getPageTypeComposerFormLayoutSetDisplayName()?></legend>
		<? } ?>
		<? $controls = PageTypeComposerFormLayoutSetControl::getList($cfl);

		foreach($controls as $con) { 
			if (is_object($page)) { // we are loading content in
				$con->setPageObject($page);
			}
            ?>
			<? $con->render(); ?>
		<? } ?>

	</fieldset>

<? } ?>

</div>