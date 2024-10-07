<?php
/** @var \Aysa\App\Helpers\Settings $settings */

use Aysa\App\Models\Config\Language;
use Aysa\App\Models\Config\Targeted_Country;
use Aysa\App\Models\Config\Targeted_Device;
use Aysa\App\Models\Config\Targeted_Region;
use Aysa\App\Models\Config\Targeted_Se;
use Aysa\App\Models\Config\Update_Frequency;

$storeRawCountry = get_option( 'woocommerce_default_country' );
$storeCountry = null;
$storeState = null;
if($storeRawCountry){
    $splitCountry = explode( ":", $storeRawCountry );

    $storeCountry = $splitCountry[0];
    $storeState   = $splitCountry[1];
}

?>
<div class="form-container">
    <h2><?php echo esc_html($page_title); ?></h2>
    <form id="form" class="aysa-wizard-form seo-settings-step" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="aysa_wizard_save">
        <input type="hidden" name="step" value="seo-settings">
        <div class="form-group">
            <label class="required" for="targeted_se"><?= __('Targeted SE', Aysa::PLUGIN_ID) ?></label>
            <div class="sub-group-container">
                <?php $settings->load_template_part(plugin_dir_path(__FILE__) . 'components/dropdown-select.php', array(
                    'name' => 'targeted_se',
                    'options' => Targeted_Se::get_options(),
                    'class' => '',
                    'default' => 'Search...',
                    'selected_value' => $settings->get_setting('targeted_se') ?? 'google',
                    'required' => true
                )); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="targeted_country" class="required"><?= __('Targeted Country', Aysa::PLUGIN_ID) ?> </label>
            <div class="sub-group-container">
                <?php $settings->load_template_part(plugin_dir_path(__FILE__) . 'components/dropdown-select-optgroup.php', array(
                    'name' => 'targeted_country',
                    'options' => [
                        'Recommended' => Targeted_Country::get_recommended_countries(),
                        'All' => Targeted_Country::get_options()
                    ],
                    'class' => '',
                    'default' => 'Search...',
                    'selected_value' => $settings->get_setting('targeted_country') ?? $storeCountry,
                    'required' => true
                )); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="targeted_region" class="required"><?= __('Targeted Region', Aysa::PLUGIN_ID) ?> </label>
            <div class="sub-group-container">
                <?php $settings->load_template_part(plugin_dir_path(__FILE__) . 'components/dropdown-select-search.php', array(
                    'name' => 'targeted_region',
                    'options' => Targeted_Region::get_options(),
                    'class' => '',
                    'default' => 'Search...',
                    'selected_value' => $settings->get_setting('targeted_region') ?? $storeState,
                    'required' => true
                )); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="targeted_city" class="required"><?= __('Targeted City', Aysa::PLUGIN_ID) ?> </label>
            <input id="targeted_city" name="targeted_city" type="text" required
                   value="<?= $settings->get_setting('targeted_city') ?? get_option('woocommerce_store_city') ?>">
        </div>
        <div class="form-group">
            <label for="targeted_brand" class="required"><?= __('Brand', Aysa::PLUGIN_ID) ?> </label>
            <input id="targeted_brand" name="targeted_brand" type="text" required
                   value="<?= $settings->get_setting('targeted_brand') ?? get_bloginfo('name') ?>">
        </div>
        <div class="form-group">
            <label for="language-optimize" class="required"><?= __('Language Optimize', Aysa::PLUGIN_ID) ?> </label>
            <div class="sub-group-container">
                <?php $settings->load_template_part(plugin_dir_path(__FILE__) . 'components/dropdown-select-optgroup.php', array(
                    'name' => 'language-optimize',
                    'options' =>
                        [
                            'Recommended' => Language::get_recommended_languages(),
                            'All' => Language::get_options()
                        ],
                    'class' => '',
                    'default' => 'Search...',
                    'selected_value' => $settings->get_setting('language-optimize') ?? get_locale(),
                    'required' => true
                )); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="device-optimize" class="required"><?= __('Device Optimize', Aysa::PLUGIN_ID) ?></label>
            <div class="sub-group-container">
                <?php $settings->load_template_part(plugin_dir_path(__FILE__) . 'components/dropdown-select.php', array(
                    'name' => 'device-optimize',
                    'options' => Targeted_Device::get_options(),
                    'class' => '',
                    'default' => 'Search...',
                    'selected_value' => $settings->get_setting('device-optimize') ?? 'mobile',
                    'required' => true
                )); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="update_frequency" class="required"><?= __('Update frequency', Aysa::PLUGIN_ID) ?></label>
            <div class="sub-group-container">
                <?php $settings->load_template_part(plugin_dir_path(__FILE__) . 'components/dropdown-select.php', array(
                    'name' => 'update_frequency',
                    'options' => Update_Frequency::get_options(),
                    'class' => '',
                    'default' => 'Search...',
                    'selected_value' => $settings->get_setting('update_frequency') ?? 'weekly' ,
                    'required' => true
                )); ?>
            </div>
        </div>
    </form>
</div>
