<?php
/** @var \Aysa\App\Helpers\Settings $settings */
$settings = $settings->get_setting('aysa-keywords');
?>
<div class="form-container">
    <div class="form-group-flex">
        <h2><?php echo esc_html($page_title); ?></h2>
        <div class="tooltip">
            <i>i</i>
            <div class="tooltip-content">
                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </span>
            </div>
        </div>
    </div>
    <form id="form" class="aysa-wizard-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="aysa_wizard_save">
        <input type="hidden" name="step" value="keywords">
        <div class="form-group">
            <div class="sub-group-container add-group">
                <div class="inputs">
                    <?php if (is_array($settings) && count($settings)): foreach ($settings as $item): ?>
                        <input id="aysa-keyword" name="aysa-keyword[]" type="text"
                               value="<?= $item ?>"/>
                    <?php endforeach; else: ?>
                        <input id="aysa-keyword" name="aysa-keyword[]" type="text"
                               value=""/>
                    <?php endif; ?>
                </div>
                <a class="button button-add" style="display: none">Add</a>
            </div>
        </div>
    </form>
</div>
