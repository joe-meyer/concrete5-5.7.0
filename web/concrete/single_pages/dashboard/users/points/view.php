<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<form class="form-inline" action="<?php echo $view->action('view')?>" method="get">
    <div class="ccm-dashboard-header-buttons">
	    <a href="<?=View::url('/dashboard/users/points/assign')?>" class="btn btn-primary"><?=t('Add Points')?></a>
	</div>
	
    <div class="ccm-pane-options">
        <div class="ccm-pane-options-permanent-search">
            <?=$form->label('uName', t('User'))?>
            <?php echo $form_user_selector->quickSelect('uName',$_GET['uName'],array('form-control'));?>
            <input type="submit" value="<?=t('Search')?>" class="btn" />


        </div>
    </div>
</form>
<br />
<?
if (!$mode) {
	$mode = $_REQUEST['mode'];
}
$txt = Loader::helper('text');
$keywords = $_REQUEST['keywords'];

if (count($entries) > 0) { ?>	
	<table border="0" cellspacing="0" cellpadding="0" id="ccm-product-list" class="table table-striped">
	<tr>
		<th class="<?=$upEntryList->getSearchResultsClass('uName')?>"><a href="<?=$upEntryList->getSortByURL('uName', 'asc')?>"><?=t('User')?></a></th>
		<th class="<?=$upEntryList->getSearchResultsClass('upaName')?>"><a href="<?=$upEntryList->getSortByURL('upaName', 'asc')?>"><?=t('Action')?></a></th>
		<th class="<?=$upEntryList->getSearchResultsClass('upPoints')?>"><a href="<?=$upEntryList->getSortByURL('upPoints', 'asc')?>"><?=t('Points')?></a></th>
		<th class="<?=$upEntryList->getSearchResultsClass('timestamp')?>"><a href="<?=$upEntryList->getSortByURL('timestamp', 'asc')?>"><?=t('Date Assigned')?></a></th>
		<th><?=t("Details")?></th>
		<th></th>
	</tr>
    <?php 
    foreach($entries as $up) { ?>
    	<tr>
    		<?
        		$ui = $up->getUserPointEntryUserObject();
        		$action = $up->getUserPointEntryActionObject();
    		?>
    		<td><? if (is_object($ui)) { ?><?php echo $ui->getUserName()?><? } ?></td>
    		<td><? if (is_object($action)) { ?><?=$action->getUserPointActionName()?><? } ?></td>
    		<td><?php echo number_format($up->getUserPointEntryValue())?></td>
    		<td><?php echo date(DATE_APP_GENERIC_MDYT, strtotime($up->getUserPointEntryTimestamp()));?></td>
    		<td><?=$up->getUserPointEntryDescription()?></td>
    		<td style="Text-align: right">
    		    <a href="<?=$view->action('deleteEntry', $up->getUserPointEntryID())?>" class="btn btn-sm btn-danger"><?=t('Delete')?></a>
    		</td>
    	</tr>
    <?php } ?>
</table>
<? } else { ?>
	<div id="ccm-list-none"><?=t('No entries found.')?></div>
<? } 
$upEntryList->displayPaging(); ?>