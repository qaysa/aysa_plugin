<div class="aysa-wizard-header inner-container">
    <div class="aysa-logo"><img width="220" src="<?= Aysa::get_plugin_url() . 'assets/images/admin/logo.svg' ?>"
                                alt=""/></div>
    <div class="wizard-navigation">
        <div class="custom-progress-bar">
            <div class="custom-progress-container">
                <svg id="progress-bar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 60">
                    <defs>
                        <filter id="f1" x="-50%" y="-50%" width="200%" height="200%">
                            <feOffset result="offOut" in="SourceAlpha" dx="0" dy="0" />
                            <feGaussianBlur result="blurOut" in="offOut" stdDeviation="5" />
                            <!-- Flooding the shadow area with a solid red color -->
                            <feFlood flood-color="#357f4d" result="colorOut" />

                            <!-- Clip the red region to the shape of the shadow -->
                            <feComposite in="colorOut" in2="blurOut" operator="in" result="shadowOut" />

                            <!-- Blend the red shadow with the original graphic -->
                            <feBlend in="SourceGraphic" in2="shadowOut" mode="normal" />
                        </filter>
                        <clipPath id="progressClip">
                            <rect id="clipRect" x="0" y="0" width="100%" height="100%"/>
                        </clipPath>
                    </defs>
                    <!-- Base Path -->
                    <path id="wavyPathBase" d="M1.5 29.2842C68 6 33.3203 51.5 100.5 29.2842" stroke="grey" stroke-width="4"/>

                    <!-- Progress Path -->
                    <path id="wavyPathProgress" d="M1.5 29.2842C68 6 33.3203 51.5 100.5 29.2842" stroke="#D50D3AFF" stroke-width="4" clip-path="url(#progressClip)"/>

                    <!-- Dot Indicator -->
                    <circle id="progressDot" cx="0" cy="0" r="8" fill="#D50D3AFF" filter="url(#f1)"/>
                </svg>
            </div>
            <?php
            $anchor = true;
            $i = 1;
            $total = count($steps);
            ?>
            <?php foreach ($steps as $key => $step):?>
                <div style="left: <?= round($i / $total * 100) ?>%;"
                     class="dot <?php if ($anchor): ?> active <?php endif; ?> step-<?= $i ?>" data-step="<?= $key ?>">
                    <span class="<?= $i % 2 ? 'above' : 'below' ?>"><a
                                href="<?= $anchor ? admin_url('/admin.php?page=aysa-wizard&step=' . $key) : 'javascript:void(0)' ?>"><?= $step['name'] ?></a></span>
                </div>
                <?php if ($key == $current) $anchor = false; $i++; endforeach; ?>
            <input id="slider" type="range" min="0" max="1" step="0.01" value="<?= round((array_search($current, array_keys($steps)) + 1) / $total, 2) ?>" oninput="moveProgress(this.value)"/>
        </div>
    </div>
</div>
<div class="container wrapper">