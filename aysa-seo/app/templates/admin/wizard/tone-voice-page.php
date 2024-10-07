<?php
/** @var \Aysa\App\Helpers\Settings $settings */
?>
<div class="form-container">
    <h2><?php echo esc_html( $page_title ); ?></h2>
    <form id="form" class="aysa-wizard-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
        <input type="hidden" name="action" value="aysa_wizard_save">
        <input type="hidden" name="step" value="tone-of-voice">
        <div class="form-group">
            <div class="radio-button-group sub-form-group">
                <?php $toneOfVoice = $settings->get_tone_voice();
                foreach ($toneOfVoice as $key => $tone) :?>
                    <div class="radio-button">
                        <input id="<?= $key ?>" name="aysa-tone-voice" type="radio" value="<?= $key ?>"
                            <?= $settings->get_setting('aysa-tone-voice')== $key ? 'checked' : ''?> />
                        <label for="<?= $key ?>"> <?= $tone ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </form>
</div>

