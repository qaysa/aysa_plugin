<?php
/** @var \Aysa\App\Helpers\Settings $settings */
$settings = $settings->get_setting('aysa-main-competitors');
?>
<div class="form-container">
    <h2><?php echo esc_html($page_title); ?></h2>
    <form id="form" class="aysa-wizard-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="aysa_wizard_save">
        <input type="hidden" name="step" value="competition">
        <div class="form-group">
            <label for="aysa-main-competitors"><?= __('Main Competitors', Aysa::PLUGIN_ID) ?></label>
            <div class="sub-group-container add-group">
                <div class="inputs">
                    <?php if (is_array($settings) && count($settings)): foreach ($settings as $item): ?>
                        <input id="aysa-main-competitors" name="aysa-main-competitors[]" type="text"
                               value="<?= $item ?>"/>
                    <?php endforeach; else: ?>
                        <input id="aysa-main-competitors" name="aysa-main-competitors[]" type="text"
                               value=""/>
                    <?php endif; ?>
                </div>
                <a class="button button-add" style="display: none">Add</a>
            </div>

        </div>


    </form>
</div>

