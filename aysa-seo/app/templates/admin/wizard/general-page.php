<?php
/** @var \Aysa\App\Helpers\Settings $settings */
?>

<div class="form-container">
    <div>
        <h2><?php echo esc_html($page_title); ?></h2>
    </div>
    <form id="form" class="aysa-wizard-form general-step" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
          method="post">
        <input type="hidden" name="action" value="aysa_wizard_save">
        <input type="hidden" name="step"
               value="<?= \Aysa\App\Controllers\Admin\Wizard\General_Information::STEP_NAME ?>">
        <div class="form-group">
            <label for="aysa-company-name" class="required"><?= __('Company Name', Aysa::PLUGIN_ID) ?></label>
            <input id="aysa-company-name" name="aysa-company-name" type="text" required
                   value="<?= $settings->get_setting('aysa-company-name') ?? get_bloginfo('name')  ?>"/>
        </div>
        <div class="form-group">
            <label for="aysa-telephone" class="required"><?= __('Support Telephone', Aysa::PLUGIN_ID) ?></label>
            <input id="aysa-telephone" name="aysa-telephone" type="tel" required
                   value="<?= $settings->get_setting('aysa-telephone') ?>"/>
        </div>
        <div class="form-group">
            <label for="aysa-email" class="required"><?= __('Support Email', Aysa::PLUGIN_ID) ?></label>
            <input id="aysa-email" name='aysa-email' type="email" required
                   value="<?= $settings->get_setting('aysa-email') ?? get_bloginfo('admin_email') ?>"/>
        </div>
        <div class="form-group">
            <label for="aysa-website" class="required"><?= __('Website', Aysa::PLUGIN_ID) ?></label>
            <input id="aysa-website" name="aysa-website" type="text" required
                   value="<?= $settings->get_setting('aysa-website') ?? get_bloginfo('url') ?>"/>
        </div>
        <div class="form-group">
            <label for="aysa-website-type" class="required"><?= __('Website type', Aysa::PLUGIN_ID) ?> </label>
            <div class="sub-group-container">

                <?php if ( class_exists( 'woocommerce' ) ):?>
                    <?php $settings->load_template_part(plugin_dir_path(__FILE__) . 'components/dropdown-select.php', array(
                        'name' => 'aysa-website-type',
                        'options' => $settings->get_website_types(),
                        'class' => '',
                        'selected_value' => $settings->get_setting('aysa-website-type') ?? 'online_store'
                    )); ?>
                    <div id="online_store" class="collapsable-group">
                        <div class="form-group">
                            <label for="aysa-store-shipping" class="required"><?= __('Shipping', Aysa::PLUGIN_ID) ?></label>
                            <input id="aysa-store-shipping" name="aysa-store-shipping" type="text"
                                   value="<?= $settings->get_setting('aysa-store-shipping') ?? $shipping_methods ?>"/>
                            <div class="tooltip">
                                <i>i</i>
                                <div class="tooltip-content">
                                    <?= __('Shipping methods used to create personalized suggestions.', Aysa::PLUGIN_ID)?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="aysa-store-payment" class="required"><?= __('Payment method', Aysa::PLUGIN_ID) ?></label>
                            <input id="aysa-store-payment" name="aysa-store-payment" type="text"
                                   value="<?= $settings->get_setting('aysa-store-payment') ?? $payment_methods?>"/>
                            <div class="tooltip">
                                <i>i</i>
                                <div class="tooltip-content">
                                    <?= __('Payment methods used to create personalized suggestions.', Aysa::PLUGIN_ID)?>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php else:?>
                <div class="woocommerce-notice">
                    <?= __('This plugin depends on WooCommerce', Aysa::PLUGIN_ID) ?>
                </div>
                <?php endif;?>
            </div>
        </div>
        <div class="form-group">
            <label for="aysa-industry" class="required"><?= __('Industry', Aysa::PLUGIN_ID) ?> </label>
            <div class="sub-group-container">
                <?php $settings->load_template_part(plugin_dir_path(__FILE__) . 'components/dropdown-select.php', array(
                    'name' => 'aysa-industry',
                    'options' => $settings->get_industries(),
                    'class' => '',
                    'default' => '...Select an Industry',
                    'selected_value' => $settings->get_setting('aysa-industry'),
                    'required' => true
                )); ?>
            </div>
        </div>
        <div class="form-group">
            <label><?= __('Company Information', Aysa::PLUGIN_ID) ?></label>
            <div class="sub-form-group">
                <div class="form-group">
                    <label for="aysa-company-description"><?= __('Company Description', Aysa::PLUGIN_ID) ?></label>
                    <textarea id="aysa-company-description" name="aysa-company-description" rows="4" cols="50"><?=
                        $settings->get_setting('aysa-company-description')
                        ?></textarea>
                </div>
            </div>
        </div>
    </form>
</div>
