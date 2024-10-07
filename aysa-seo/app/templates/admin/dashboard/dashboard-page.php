<?php
/** @var \Aysa\App\Models\Admin\Data\Table\Seo_Data_Table $seo_list_table */
$seo_list_table->prepare_items();
?>
<div class="wrap">
    <div class="aysa-logo">
        <img width="150" src="<?= Aysa::get_plugin_url() . 'assets/images/admin/logo.svg' ?>" alt="">
    </div>
    <div class="header-wrapper">
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="sync_aysa_seo_data">
            <input type="submit" name="sync_aysa_seo_data" class="btn button-primary sync-data" value="Sync Data">
        </form>
        <div class="stats">
            <div class="bar-container">
                <?php $perc = 30;  $color = $perc <= 30 ? 'red' : ($perc < 70 ? 'yellow' : 'green') ?>
                <div class="progress-container" style="--progress-color: var(--progress-<?= $color ?>)">
                    <div class="progress-bar" style="--percentage: <?= $perc ?>%;"></div>
                    <span class="percentage <?= $perc == 100 ? 'full' : '' ?>"><?= $perc ?>%</span>
                </div>
                <span class="bar-title">Own Website</span>
            </div>
            <div class="bar-container">
                <?php $perc = 45;  $color = $perc <= 30 ? 'red' : ($perc < 70 ? 'yellow' : 'green') ?>
                <div class="progress-container" style="--progress-color: var(--progress-<?= $color ?>)">
                    <div class="progress-bar" style="--percentage: <?= $perc ?>%;"></div>
                    <span class="percentage <?= $perc == 100 ? 'full' : '' ?>"><?= $perc ?>%</span>
                </div>
                <span class="bar-title">Competition</span>
            </div>
            <div class="bar-container">
                <?php $perc = 100;  $color = $perc <= 30 ? 'red' : ($perc < 70 ? 'yellow' : 'green') ?>
                <div class="progress-container" style="--progress-color: var(--progress-<?= $color ?>)">
                    <div class="progress-bar" style="--percentage: <?= $perc ?>%;"></div>
                    <span class="percentage <?= $perc == 100 ? 'full' : '' ?>"><?= $perc ?>%</span>
                </div>
                <span class="bar-title">AYSA SEO CREDITS</span>
            </div>
        </div>
    </div>
    <form method="get" class="search-wrapper" id="filter-form">
        <select class="type-filter" name="type" id="type-filter">
            <?php foreach ($seo_list_table->filter_options() as $key => $option): ?>
             <option value="<?= $key ?>" <?= $option['selected'] ? 'selected' : '' ?>><?= $option['label'] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="page" value="aysa-dashboard">
        <?php $seo_list_table->table_nav('type'); ?>
        <?php $seo_list_table->search_box( esc_html__( 'Search', Aysa::PLUGIN_ID ), 's' ); ?>
    </form>
    <div class="notices"></div>
    <div id="aysa-seo-table-list">
        <div id="aysa-post-body">
            <form id="aysa-seo-table-form" method="get">
                <?php $seo_list_table->display(); ?>
            </form>
            <?php include (plugin_dir_path(__FILE__) . 'components/inline-edit-template.php');?>
        </div>
    </div>
</div>