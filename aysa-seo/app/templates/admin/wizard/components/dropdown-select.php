<?php
/**
 * Dropdown Select Component.
 *
 * @param array $args {
 *     Optional. Arguments to pass to the template.
 *
 * @type string $name Name attribute of the select element.
 * @type array $options Array of options for the select dropdown.
 * @type string $class Additional classes for the select element.
 * @type string $default Default option.
 * }
 */
$args = wp_parse_args($args, [
    'name' => '',
    'options' => [],
    'class' => '',
    'default' => '',
    'selected_value' => ''
]);
?>
<div class="custom-select">
    <details class="<?= esc_attr($args['class']); ?>">
        <summary class="radios">
            <?php if($args['default']) : ?>
                <input type="radio" name="<?= esc_attr($args['name']); ?>" id="default"
                       title="<?= esc_attr($args['default']); ?>" checked/>
            <?php endif; ?>
            <?php $i = 0;
            foreach ($args['options'] as $value => $label) : ?>
                <input required type="radio" name="<?= esc_attr($args['name']); ?>" value="<?= esc_attr($value); ?>"
                       id="<?= $args['name'] . $i ?>" title="<?= esc_attr($label); ?>"
                        <?php if ($args['selected_value'] == $value){
                            echo 'checked';
                        } ?>
                    />
                <?php $i++; endforeach; ?>
        </summary>
        <ul class="list">
            <?php $i = 0;
            foreach ($args['options'] as $value => $label) : ?>
                <li>
                    <label for="<?= $args['name'] . $i ?>"><?= esc_attr($label); ?></label>
                </li>
                <?php $i++; endforeach; ?>
        </ul>
    </details>
</div>
