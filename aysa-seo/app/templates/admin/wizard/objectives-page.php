<?php
/** @var \Aysa\App\Helpers\Settings $settings */
?>
<div class="form-container">
    <div>
        <h2><?php echo esc_html($page_title); ?></h2>
    </div>
    <form id="form" class="aysa-wizard-form objectives-step" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="aysa_wizard_save">
        <input type="hidden" name="step" value="objectives">
        <div class="form-group">
            <div class="radio-button-group">
                <?php $objectives = $settings->get_objectives();
                foreach ($objectives as $key => $objective) :?>
                    <div class="radio-button">
                        <input id="<?= $key ?>" name="aysa-goals[]" type="checkbox" value="<?= $key ?>"
                            <?php
                            if ($settings->get_setting('aysa-goals') && is_array($settings->get_setting('aysa-goals')) && in_array($key, $settings->get_setting('aysa-goals'))) {
                                echo 'checked';
                            } elseif ($key == 'more-traffic') {
                                echo 'checked';
                            }
                            ?>
                        />
                        <label for="<?= $key ?>"> <?= $objective ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </form>
</div>


