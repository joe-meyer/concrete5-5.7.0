<?
defined('C5_EXECUTE') or die("Access Denied.");
$cmpp = new Permissions($pagetype);
?>

<? if (!is_object($page) || $page->isPageDraft()) { ?>
	<button type="button" data-page-type-composer-form-btn="publish" class="btn btn-primary pull-right"><?=t('Publish')?></button>
<? } ?>

<? if (!is_object($page) || $page->isPageDraft()) { ?>
<button type="button" data-page-type-composer-form-btn="preview" class="btn btn-success pull-right"><?=t('Edit Mode')?></button>
<? } else { ?>
<button type="button" data-page-type-composer-form-btn="preview" class="btn btn-success pull-right"><?=t('Save')?></button>
<? } ?>

<?
$c = Page::getCurrentPage();
if (is_object($c) && $c->getCollectionPath() == '/dashboard/composer/write') { ?>
<button type="button" data-page-type-composer-form-btn="exit" class="btn btn-default pull-right"><?=t('Back to Drafts')?></button>
<? } ?>

<? if (is_object($page) && $page->isPageDraft()) { ?>
	<button type="button" data-page-type-composer-form-btn="discard" class="btn btn-danger pull-left"><?=t('Discard Draft')?></button>
<? } ?>

<? if (PERMISSIONS_MODEL != 'simple' && $cmpp->canEditPageTypePermissions($pagetype)) { ?>
	<button type="button" data-page-type-composer-form-btn="permissions" class="btn btn-default pull-left"><?=t('Permissions')?></button>
<? } ?>


<style type="text/css">
	button[data-page-type-composer-form-btn=save] {
		margin-left: 10px;
	}
	button[data-page-type-composer-form-btn=permissions] {
		margin-left: 10px;
	}
	button[data-page-type-composer-form-btn=preview] {
		margin-left: 10px;
	}
	button[data-page-type-composer-form-btn=publish] {
		margin-left: 10px;
	}
</style>
