<div class="footer">
    <?php if ($next): ?>
        <a href="<?= admin_url('/admin.php?page=aysa-wizard&step=' . $next) ?>"><?= __('Skip Step', Aysa::PLUGIN_ID) ?></a>
        <button id="submit-form"
                type="submit"
                class="button button-primary">
            <?php esc_html_e('Save and Continue', Aysa::PLUGIN_ID); ?>
        </button>
    <?php else: ?>
        <button id="submit-form" type="submit"
                class="button button-primary">
            <?php esc_html_e('Save', Aysa::PLUGIN_ID); ?>
        </button>
    <?php endif; ?>
</div>
