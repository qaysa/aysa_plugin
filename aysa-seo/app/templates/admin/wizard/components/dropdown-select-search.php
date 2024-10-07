<?php
/**
 * Dropdown Select .
 *
 * @param array $args {
 *     Optional. Arguments to pass to the template.
 *
 * @type string $name Name attribute of the select element.
 * @type array $options Array of options for the select dropdown.
 * @type string $class Additional classes for the select element.
 * @type string $default Default option.
 * @type string $selected_value The previously selected option.
 * }
 */
$args = wp_parse_args($args, [
    'name' => '',
    'options' => [],
    'class' => '',
    'default' => '',
    'selected_value' => '',
]);
?>
<div class="select-with-search">
    <div class="<?= esc_attr($args['class']); ?>">
        <select name="<?= $args['name'] ?>" id="<?= $args['name'] ?>" <?php if($args['required']) echo 'required'?> >
            <option value=""><?= $args['default'] ?></option>
            <?php foreach ($args['options'] as $value => $label) : ?>
                <option value="<?= esc_attr($value); ?>"<?php if ($args['selected_value'] == $value) echo 'selected'; ?>>
                    <?= esc_attr($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
