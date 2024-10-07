<?php
/** @var \Aysa\App\Helpers\Settings $settings */
?>
<div class="form-container">
    <h2><?php echo esc_html( $page_title ); ?></h2>

    <form id="form" class="aysa-wizard-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
        <input type="hidden" name="action" value="aysa_wizard_save">
        <input type="hidden" name="step" value="integrations">
        <div class="form-group">
            <div class="form-group-flex">
                <label><?= __('AYSA', Aysa::PLUGIN_ID) ?></label>
                <div class="tooltip">
                    <i>i</i>
                    <div class="tooltip-content">
                        <a href="https://app.aysa.ai" target="_blank">
                            <?= __('Please click here to register or login into your account', Aysa::PLUGIN_ID) ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="sub-form-group">
               <div class="form-group">
                   <label for="aysa-account-id"><?= __('Account Id', Aysa::PLUGIN_ID) ?></label>
                   <input id="aysa-account-id" name="aysa-account-id" type="text"
                          value="<?= $settings->get_setting('aysa-account-id') ?>">
               </div>
                <div class="form-group">
                    <label for="aysa-project-id"><?= __('Project Id', Aysa::PLUGIN_ID) ?></label>
                    <input id="aysa-project-id" name="aysa-project-id" type="text"
                           value="<?= $settings->get_setting('aysa-project-id') ?>">
                </div>
                <div class="form-group">
                    <label for="aysa-secret"><?= __('Secret', Aysa::PLUGIN_ID) ?></label>
                    <input id="aysa-secret" name="aysa-secret" type="text"
                           value="<?= $settings->get_setting('aysa-secret') ?>">
                </div>
            </div>
        </div>
    </form>
</div>
