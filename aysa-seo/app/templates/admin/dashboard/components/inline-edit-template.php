<div id="inline-edit">
    <div class="inline-edit-wrapper">
        <div class="overlay">
            <span class="loading-spinner"></span>
        </div>
        <input type="hidden" id="aysa-entity-id" name="entity_id" value="">
        <input type="hidden" id="aysa-entity-type" name="type" value="">
        <div class="upper-buttons">
            <button type="button" class="button button-primary btn-universal get-seo"><?= __('Get SEO', Aysa::PLUGIN_ID) ?></button>
            <ul class="tabs">
                <li class="active" data-toggle="general">General</li>
                <li data-toggle="seo">Seo Settings</li>
                <li data-toggle="advanced">Advanced</li>
            </ul>
        </div>
        <div class="group">
            <div class="sub-group">
                <div class="label-group">
                    <div class="label-container">
                        <label for="aysa-entity-name"><?= __('Name', Aysa::PLUGIN_ID) ?></label>
                        <div class="tooltip">
                            <i>i</i>
                            <div class="tooltip-content"></div>
                        </div>
                    </div>
                    <input type="text" id="aysa-entity-name" name="name" data-accepted="name">
                </div>
                <div class="label-group">
                    <label for="aysa-entity-suggested-name">Suggested name</label>
                    <input type="text" id="aysa-entity-suggested-name" name="suggested-name" data-suggested="name">
                </div>
                <div class="actions">
                    <button type="button"
                            class="btn btn-accept save"
                            data-input-name="name"
                    >
                        <?php esc_html_e('Accept', Aysa::PLUGIN_ID); ?>
                    </button>
                    <span class="spinner"></span>
                </div>
            </div>
            <div class="sub-group">
                <div class="label-group">
                    <div class="label-container">
                        <label for="aysa-entity-slug"><?= __('Permalink', Aysa::PLUGIN_ID) ?></label>
                        <div class="tooltip">
                            <i>i</i>
                            <div class="tooltip-content"></div>
                        </div>
                    </div>
                    <input type="text" id="aysa-entity-slug" name="slug" data-accepted="slug">
                </div>
                <div class="label-group">
                    <label for="aysa-entity-suggested-slug">Suggested permalink</label>
                    <input type="text" id="aysa-entity-suggested-slug" name="suggested-slug" data-suggested="slug">
                </div>
                <div class="actions">
                    <button type="button"
                            class="btn btn-accept save"
                            data-input-name="slug"
                    ><?php esc_html_e('Accept', Aysa::PLUGIN_ID); ?></button>
                    <span class="spinner"></span>
                </div>
            </div>
        </div>
        <div class="group aysa-entity-description">
            <div class="label-container">
                <label for="aysa-entity-description"><?= __('Description', Aysa::PLUGIN_ID) ?></label>
                <div class="tooltip">
                    <i>i</i>
                    <div class="tooltip-content"></div>
                </div>
            </div>
            <?php wp_editor(
                '',
                'aysa-entity-description',
                $settings = [
                    'textarea_name' => 'description',
                    'media_buttons' => false,
                    'textarea_rows' => 4,
                    'tinymce' => false,
                ]
            ); ?>

            <div class="label-container">
                <label for="aysa-entity-suggested-description"><?= __('Suggested Description', Aysa::PLUGIN_ID) ?></label>
                <div class="tooltip">
                    <i>i</i>
                    <div class="tooltip-content"></div>
                </div>
            </div>
            <?php wp_editor(
                '',
                'aysa-entity-suggested-description',
                $settings = [
                    'textarea_name' => 'suggested-description',
                    'media_buttons' => false,
                    'textarea_rows' => 4,
                    'tinymce' => false
                ]
            ); ?>
            <div class="actions">
                <button type="button"
                        class="btn btn-accept save"
                        data-input-name="description"
                ><?php esc_html_e('Accept', Aysa::PLUGIN_ID); ?></button>
                <span class="spinner"></span>
            </div>
        </div>
        <div class="group">
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
                        <?php $perc = 50;
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
                        <?php $perc = 100;
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
            <div class="meta-group">
                <div class="meta-form">
                    <input type="checkbox" name="track" id="aysa-track">
                    <div class="label-container">
                        <label for="aysa-track"><?= __('Track Keywords', Aysa::PLUGIN_ID) ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="group media-upload">
            <input type="hidden" class="single-image" name="single_image">
            <input type="hidden" class="image-gallery" name="image_gallery">
            <a href="#" class="button rudr-upload">Upload image</a>
            <input type="hidden" name="rudr_img" value="">
            <div class="image-block">
                <div class="thumbs">
                    <div class="single-image"></div>
                    <div class="image-gallery"></div>
                </div>
                <div class="edit"><span>Edit</span></div>
            </div>
            <div class="gallery-switches">
                <label>
                    <input type="radio" name="gallery_switch" value="image" checked/>
                    <span>Image</span>
                </label>
                <label>
                    <input type="radio" name="gallery_switch" value="gallery"/>
                    <span>Gallery</span>
                </label>
            </div>
        </div>
        <div class="group">
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
                        <?php $perc = 75;
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
                        <?php $perc = 80;
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
                        <?php $perc = 40;
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
        <div class="multiple-group">
            <div class="group">
                <h3>Robots Meta</h3>
                <div class="meta-group">
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
            <div class="group">
                <h3><label for="aysa-canonical-url">Canonical URL</label></h3>
                <input type="text" id="aysa-canonical-url" name="canonical_url">
            </div>
        </div>
        <div class="submit inline-edit-save">
            <button type="button"
                    class="btn btn-accept save"><?php esc_html_e('Update', Aysa::PLUGIN_ID); ?></button>
            <button type="button" class="btn btn-decline cancel"><?php esc_html_e('Close', Aysa::PLUGIN_ID); ?></button>
            <span class="spinner"></span>
        </div>
    </div>
</div>