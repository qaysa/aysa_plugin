<?php
/** @var \Aysa\App\Models\Admin\Data\Table\Rank_Tracker_Table $rank_tracker_list_table */
$rank_tracker_list_table->prepare_items()
?>
<div class="wrap">
    <form method="get" class="search-wrapper">
        <select class="type-filter" name="type">
            <option value="" disabled selected>Type</option>
            <option value="product">Product</option>
            <option value="category">Category</option>
        </select>
        <input type="hidden" name="page" value="aysa-dashboard">
        <?php $rank_tracker_list_table->search_box( esc_html__( 'Search', Aysa::PLUGIN_ID ), 's' ); ?>
    </form>
    <div id="aysa-seo-table-list">
        <div id="aysa-post-body">
            <form id="aysa-seo-table-form" method="get">
                <?php $rank_tracker_list_table->display(); ?>
            </form>
        </div>
    </div>
</div>