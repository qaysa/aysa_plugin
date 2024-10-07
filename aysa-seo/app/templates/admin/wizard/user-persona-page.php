<?php
/** @var \Aysa\App\Helpers\Settings $settings */
?>
<div class="form-container">
    <h2><?php echo esc_html( $page_title ); ?></h2>
    <form id="form" class="aysa-wizard-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
        <input type="hidden" name="action" value="aysa_wizard_save">
        <input type="hidden" name="step" value="user-persona">
        <div class="form-group">
            <label for="demographic"><?= __('Demographic', Aysa::PLUGIN_ID) ?></label>
            <textarea id="demographic" name="demographic" rows="4" cols="50"><?=
                $settings->get_setting('demographic')
                ?></textarea>
        </div>
        <div class="form-group">
            <label for="psychographics"><?= __('Psychographics', Aysa::PLUGIN_ID) ?></label>
            <textarea id="psychographics" name="psychographics" rows="4" cols="50" placeholder="eg: values, beliefs, lifestyle..." ><?=
                $settings->get_setting('psychographics')
                ?></textarea>
        </div>
        <div class="form-group">
            <label for="information-sources"><?= __('Information Sources', Aysa::PLUGIN_ID) ?></label>
            <textarea id="information-sources" name="information-sources" rows="4" cols="50" placeholder="eg: favorite social networks, influencers, events..." ><?=
                $settings->get_setting('information-sources')
                ?></textarea>
        </div>
        <div class="form-group">
            <label for="professional-status"><?= __('Professional Status', Aysa::PLUGIN_ID) ?></label>
            <textarea id="professional-status" name="professional-status" rows="4" cols="50" placeholder="eg: job title,industry, income..." ><?=
                $settings->get_setting('professional-status')
                ?></textarea>
        </div>
        <div class="form-group">
            <label for="challenges"><?= __('Challenges', Aysa::PLUGIN_ID) ?></label>
            <textarea id="challenges" name="challenges" rows="4" cols="50" placeholder="eg: frustrations,obstacles,dissatisfactions" ><?=
                $settings->get_setting('challenges')
                ?></textarea>
        </div>
        <div class="form-group">
            <label for="purchasing-process"><?= __('Purchasing Process', Aysa::PLUGIN_ID) ?></label>
            <textarea id="purchasing-process" name="purchasing-process" rows="4" cols="50" placeholder="eg: role in decision making process, frequency of purchase" ><?=
                $settings->get_setting('purchasing-process')
                ?></textarea>
        </div>
    </form>
</div>