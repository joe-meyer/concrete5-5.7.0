<? defined('C5_EXECUTE') or die("Access Denied."); ?>

<form method="post" id="clear-cache-form" action="<?php echo $view->url('/dashboard/system/optimization/clearcache', 'do_clear')?>">
	<?php echo $this->controller->token->output('clear_cache')?>
    <p><?php echo t('If your site is displaying out-dated information, or behaving unexpectedly, it may help to clear your cache.')?></p>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions ">
        <? print $interface->submit(t('Clear Cache'), 'clear-cache-form', 'left', 'btn-primary'); ?>
        </div>
    </div>
</form>


