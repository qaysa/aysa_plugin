<?php
/** @var \Aysa\App\Helpers\Settings $settings */

use Aysa\App\Models\Config\Language;
use Aysa\App\Models\Config\Targeted_Country;
use Aysa\App\Models\Config\Targeted_Device;
use Aysa\App\Models\Config\Targeted_Region;
use Aysa\App\Models\Config\Targeted_Se;
use Aysa\App\Models\Config\Update_Frequency;

?>
<div class="inner-box">
    <ul class="tabs">
        <li class="active" data-toggle="general">General</li>
        <li data-toggle="seo">Seo Settings</li>
        <li data-toggle="advanced">Advanced</li>
    </ul>
    <button type="button" class="btn btn-universal get-seo"><?= __('Get SEO', Aysa::PLUGIN_ID) ?></button>
</div>
<div class="panel active" data-panel="general">
    <div class="inner-box text-box">
        <h3>Preview</h3>
        <h3>Liknk</h3>
        <h3>WordPress Pennat 5- AYSA</h3>
        <span>This is an external product.</span>
        <button class="btn btn-universal ">Edit Snippet</button>
    </div>
    <div class="inner-box">
        <div class="sub-group">
            <div class="label-group">
                <div class="label-container">
                    <label for="aysa-entity-keyword"><?= __('Keyword', Aysa::PLUGIN_ID) ?></label>
                    <div class="tooltip">
                        <i>i</i>
                        <div class="tooltip-content"></div>
                    </div>
                </div>
                <input type="text" id="aysa-entity-keyword" name="keyword" data-accepted="keyword">
                <div class="bar-container ">
                    <?php $perc = 70;
                    $color = $perc <= 30 ? 'red' : ($perc < 70 ? 'yellow' : 'green') ?>
                    <div class="progress-container no-padding"
                         style="--progress-color: var(--progress-no-padding-<?= $color ?>)">
                        <div class="progress-bar" style="--percentage: <?= $perc ?>%;"></div>
                        <span style="--percentage-color: var(--progress-no-padding-<?= $color ?>)"
                              class="percentage"><?= $perc ?>%</span>
                    </div>
                </div>
            </div>
            <div class="label-group">
                <label for="aysa-entity-suggested-keyword">Suggested keyword</label>
                <input type="text" id="aysa-entity-suggested-keyword" name="suggested-keyword"
                       data-suggested="keyword">
            </div>
            <div class="actions">
                <button type="button"
                        class="btn btn-accept save"
                        data-input-name="keyword"
                ><?php esc_html_e('Accept', Aysa::PLUGIN_ID); ?></button>
                <span class="spinner"></span>
            </div>
        </div>
        <div class="sub-group">
            <div class="label-group">
                <div class="label-container">
                    <label for="aysa-entity-second-keyword"><?= __('Second Keyword', Aysa::PLUGIN_ID) ?></label>
                    <div class="tooltip">
                        <i>i</i>
                        <div class="tooltip-content"></div>
                    </div>
                </div>
                <input type="text" id="aysa-entity-second-keyword" name="second_keyword"
                       data-accepted="second-keyword">
                <div class="bar-container ">
                    <?php $perc = 70;
                    $color = $perc <= 30 ? 'red' : ($perc < 70 ? 'yellow' : 'green') ?>
                    <div class="progress-container no-padding"
                         style="--progress-color: var(--progress-no-padding-<?= $color ?>)">
                        <div class="progress-bar" style="--percentage: <?= $perc ?>%;"></div>
                        <span style="--percentage-color: var(--progress-no-padding-<?= $color ?>)"
                              class="percentage"><?= $perc ?>%</span>
                    </div>
                </div>
            </div>
            <div class="label-group">
                <label for="aysa-entity-suggested-second-keyword">Suggested second keyword</label>
                <input type="text" id="aysa-entity-suggested-second-keyword" name="suggested-second-keyword"
                       data-suggested="second-keyword">
            </div>
            <div class="actions">
                <button type="button"
                        class="btn btn-accept save"
                        data-input-name="second-keyword"
                ><?php esc_html_e('Accept', Aysa::PLUGIN_ID); ?></button>
                <span class="spinner"></span>
            </div>
        </div>
        <div class="meta-group track-keywords">
            <div class="meta-form">
                <input type="checkbox" name="track" id="aysa-track">
                <div class="label-container">
                    <label for="aysa-track"><?= __('Track Keywords', Aysa::PLUGIN_ID) ?></label>
                </div>
            </div>
        </div>
        <div class="sub-group">
            <div class="label-group">
                <div class="label-container">
                    <label for="aysa-entity-meta-title"><?= __('Meta title', Aysa::PLUGIN_ID) ?></label>
                    <div class="tooltip">
                        <i>i</i>
                        <div class="tooltip-content"></div>
                    </div>
                </div>
                <input type="text" id="aysa-entity-meta-title" name="aysa_meta_title" data-accepted="meta-title">
                <div class="bar-container ">
                    <?php $perc = 70;
                    $color = $perc <= 30 ? 'red' : ($perc < 70 ? 'yellow' : 'green') ?>
                    <div class="progress-container no-padding"
                         style="--progress-color: var(--progress-no-padding-<?= $color ?>)">
                        <div class="progress-bar" style="--percentage: <?= $perc ?>%;"></div>
                        <span style="--percentage-color: var(--progress-no-padding-<?= $color ?>)"
                              class="percentage"><?= $perc ?>%</span>
                    </div>
                </div>
            </div>
            <div class="label-group">
                <label for="aysa-entity-suggested-meta-title">Suggested Meta Title</label>
                <input type="text" id="aysa-entity-suggested-meta-title" name="aysa_suggested_meta_title"
                       data-suggested="meta-title">
            </div>
            <div class="actions">
                <button type="button"
                        class="btn btn-accept save"
                        data-input-name="meta-title"
                ><?php esc_html_e('Accept', Aysa::PLUGIN_ID); ?></button>
                <span class="spinner"></span>
            </div>
        </div>
        <div class="sub-group">
            <div class="label-group">
                <div class="label-container">
                    <label for="aysa-entity-meta-description"><?= __('Meta description', Aysa::PLUGIN_ID) ?></label>
                    <div class="tooltip">
                        <i>i</i>
                        <div class="tooltip-content"></div>
                    </div>
                </div>
                <input type="text" id="aysa-entity-meta-description" name="aysa_meta_description"
                       data-accepted="meta-description">
                <div class="bar-container ">
                    <?php $perc = 70;
                    $color = $perc <= 30 ? 'red' : ($perc < 70 ? 'yellow' : 'green') ?>
                    <div class="progress-container no-padding"
                         style="--progress-color: var(--progress-no-padding-<?= $color ?>)">
                        <div class="progress-bar" style="--percentage: <?= $perc ?>%;"></div>
                        <span style="--percentage-color: var(--progress-no-padding-<?= $color ?>)"
                              class="percentage"><?= $perc ?>%</span>
                    </div>
                </div>
            </div>
            <div class="label-group">
                <label for="aysa-entity-suggested-meta-description">Suggested Meta Description</label>
                <input type="text" id="aysa-entity-suggested-meta-description"
                       name="aysa_suggested_meta_description"
                       data-suggested="meta-description"
                >
            </div>
            <div class="actions">
                <button type="button"
                        class="btn btn-accept save"
                        data-input-name="meta-description"
                ><?php esc_html_e('Accept', Aysa::PLUGIN_ID); ?></button>
                <span class="spinner"></span>
            </div>
        </div>
        <div class="sub-group">
            <div class="label-group">
                <div class="label-container">
                    <label for="aysa-entity-meta-keywords"><?= __('Meta keywords', Aysa::PLUGIN_ID) ?></label>
                    <div class="tooltip">
                        <i>i</i>
                        <div class="tooltip-content"></div>
                    </div>
                </div>
                <input type="text" id="aysa-entity-meta-keywords" name="aysa_meta_keywords"
                       data-accepted="meta-keywords">
                <div class="bar-container ">
                    <?php $perc = 70;
                    $color = $perc <= 30 ? 'red' : ($perc < 70 ? 'yellow' : 'green') ?>
                    <div class="progress-container no-padding"
                         style="--progress-color: var(--progress-no-padding-<?= $color ?>)">
                        <div class="progress-bar" style="--percentage: <?= $perc ?>%;"></div>
                        <span style="--percentage-color: var(--progress-no-padding-<?= $color ?>)"
                              class="percentage"><?= $perc ?>%</span>
                    </div>
                </div>
            </div>
            <div class="label-group">
                <label for="aysa-entity-suggested-meta-keywords">Suggested Meta Keywords </label>
                <input type="text" id="aysa-entity-suggested-meta-keywords"
                       name="aysa_suggested_suggested_meta_keywords"
                       data-suggested="meta-keywords"
                >
            </div>
            <div class="actions">
                <button type="button"
                        class="btn btn-accept save"
                        data-input-name="meta-keywords"
                ><?php esc_html_e('Accept', Aysa::PLUGIN_ID); ?></button>
                <span class="spinner"></span>
            </div>
        </div>
    </div>
</div>
<div class="panel" data-panel="seo">
    <div class="inner-box">
        <h3>SEO Settings</h3>
        <div class="seo-settings">
            <div class="form-group">
                <label for="targeted_se"><?= __('TARGETED SE', Aysa::PLUGIN_ID) ?></label>
                <div class="sub-group-container">
                    <?php $settings->load_template_part(plugin_dir_path(__FILE__) . '../wizard/components/dropdown-select.php', array(
                        'name' => 'targeted_se',
                        'options' => Targeted_Se::get_options(),
                        'class' => '',
                        'default' => 'Search...',
                        'selected_value' => $settings->get_setting('targeted_se')
                    )); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="targeted_country"><?= __('Targeted Country', Aysa::PLUGIN_ID) ?> </label>
                <div class="sub-group-container">
                    <?php $settings->load_template_part(plugin_dir_path(__FILE__) . '../wizard/components/dropdown-select-search.php', array(
                        'name' => 'targeted_country',
                        'options' => Targeted_Country::get_options(),
                        'class' => '',
                        'default' => 'Search...',
                        'selected_value' => $settings->get_setting('targeted_country')
                    )); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="targeted_region"><?= __('Targeted Region', Aysa::PLUGIN_ID) ?> </label>
                <div class="sub-group-container">
                    <?php $settings->load_template_part(plugin_dir_path(__FILE__) . '../wizard/components/dropdown-select-search.php', array(
                        'name' => 'targeted_region',
                        'options' => Targeted_Region::get_options(),
                        'class' => '',
                        'default' => 'Search...',
                        'selected_value' => $settings->get_setting('targeted_region')
                    )); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="targeted_city"><?= __('Targeted City', Aysa::PLUGIN_ID) ?> </label>
                <input id="targeted_city" name="targeted_city" type="text"
                       value="<?= $settings->get_setting('targeted_city') ?>">
            </div>
            <div class="form-group">
                <label for="update_frequency"><?= __('Update frequency', Aysa::PLUGIN_ID) ?></label>
                <div class="sub-group-container">
                    <?php $settings->load_template_part(plugin_dir_path(__FILE__) . '../wizard/components/dropdown-select.php', array(
                        'name' => 'update_frequency',
                        'options' => Update_Frequency::get_options(),
                        'class' => '',
                        'default' => 'Search...',
                        'selected_value' => $settings->get_setting('update_frequency')
                    )); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="language-optimize"><?= __('Language Optimize', Aysa::PLUGIN_ID) ?> </label>
                <div class="sub-group-container">
                    <?php $settings->load_template_part(plugin_dir_path(__FILE__) . '../wizard/components/dropdown-select-search.php', array(
                        'name' => 'language-optimize',
                        'options' => Language::get_options(),
                        'class' => '',
                        'default' => 'Search...',
                        'selected_value' => $settings->get_setting('language-optimize')
                    )); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="device-optimize"><?= __('Device Optimize', Aysa::PLUGIN_ID) ?></label>
                <div class="sub-group-container">
                    <?php $settings->load_template_part(plugin_dir_path(__FILE__) . '../wizard/components/dropdown-select.php', array(
                        'name' => 'device-optimize',
                        'options' => Targeted_Device::get_options(),
                        'class' => '',
                        'default' => 'Search...',
                        'selected_value' => $settings->get_setting('device-optimize')
                    )); ?>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="panel" data-panel="advanced">
    <div class="inner-box">
        <div class="group">
            <h3>Robots Meta</h3>
            <div class="meta-group robots-meta">
                <div class="meta-form">
                    <input class="custom-radio" type="radio" id="index" name="index">
                    <div class="label-container">
                        <label for="index">Index</label>
                        <div class="tooltip">
                            <i>i</i>
                            <div class="tooltip-content"></div>
                        </div>
                    </div>
                </div>
                <div class="meta-form">
                    <input class="custom-radio" type="radio" id="noindex" name="index">
                    <div class="label-container">
                        <label for="noindex">No Index</label>
                        <div class="tooltip">
                            <i>i</i>
                            <div class="tooltip-content"></div>
                        </div>
                    </div>
                </div>
                <div class="meta-form">
                    <input type="checkbox" id="nofollow" name="no_follow">
                    <div class="label-container">
                        <label for="nofollow">No follow</label>
                        <div class="tooltip">
                            <i>i</i>
                            <div class="tooltip-content"></div>
                        </div>
                    </div>
                </div>
                <div class="meta-form">
                    <input type="checkbox" id="noarchive" name="noarchive">
                    <div class="label-container">
                        <label for="noarchive">No Archive</label>
                        <div class="tooltip">
                            <i>i</i>
                            <div class="tooltip-content"></div>
                        </div>
                    </div>
                </div>
                <div class="meta-form">
                    <input type="checkbox" id="image-index" name="no_image_index">
                    <div class="label-container">
                        <label for="image-index">No Image Index</label>
                        <div class="tooltip">
                            <i>i</i>
                            <div class="tooltip-content"></div>
                        </div>
                    </div>
                </div>
                <div class="meta-form">
                    <input type="checkbox" id="snippet" name="no_snippet">
                    <div class="label-container">
                        <label for="snippet">No Snippet</label>
                        <div class="tooltip">
                            <i>i</i>
                            <div class="tooltip-content"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    <div class="inner-box">
        <div class="group">
            <h3>Advanced Robots Meta</h3>
            <div class="meta-group">
                <div class="meta-form">
                    <input type="checkbox" id="max-snippet" name="max_snippet">
                    <div class="label-container">
                        <label for="max-snippet">Max Snippet</label>
                        <div class="tooltip">
                            <i>i</i>
                            <div class="tooltip-content"></div>
                        </div>
                    </div>
                </div>
                <div class="meta-form">
                    <input type="number" id="number-max-snippet" value="-1">
                </div>
                <div class="meta-form">
                    <input type="checkbox" id="max-video-preview" name="max_video_preview">
                    <div class="label-container">
                        <label for="max-video-preview">Max Video Preview</label>
                        <div class="tooltip">
                            <i>i</i>
                            <div class="tooltip-content"></div>
                        </div>
                    </div>
                </div>
                <div class="meta-form">
                    <input type="number" id="number-max-video-preview" value="-2">
                </div>
                <div class="meta-form">
                    <input type="checkbox" id="max-image-preview" name="max_image_preview">
                    <div class="label-container">
                        <label for="max-image-preview">Max Image Preview</label>
                        <div class="tooltip">
                            <i>i</i>
                            <div class="tooltip-content"></div>
                        </div>
                    </div>
                </div>
                <div class="meta-form">
                    <select name="image_preview" id="image-preview">
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="inner-box">
        <div class="group">
            <h3><label for="aysa-canonical-url">Canonical URL</label></h3>
            <input type="text" id="aysa-canonical-url" name="canonical_url">
        </div>
    </div>
</div>