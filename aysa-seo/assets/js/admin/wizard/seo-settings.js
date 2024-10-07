(function ($) {
    let SeoSettings = {

        validate: function (form) {
            let valid = true;

            if (!this.validateRequiredFields(form)) {
                valid = false;
            }

            if (!this.validateCustomSelect(form, 'targeted_se')) {
                valid = false;
            }

            if (!this.validateCustomSelect(form, 'device-optimize')) {
                valid = false;
            }

            if (!this.validateCustomSelect(form, 'update_frequency')) {
                valid = false;
            }

            return valid;
        },

        validateRequiredFields: function (form) {
            let valid = true;
            form.find('input[required]').each(function () {
                if ($(this).val() === '') {
                    $(this).after('<span class="aysa-error">This field is required.</span>')
                    valid = false;
                }
            });

            form.find('select[required]').each(function () {
                if ($(this).val() === '') {
                    $(this).closest('.sub-group-container').after('<span class="aysa-error">This field is required.</span>')
                    valid = false;
                }
            });

            return valid;
        },

        validateCustomSelect: function (form, name) {
            let customSelectInputs = form.find('input[name="' + name + '"]');
            let customSelectField = customSelectInputs.closest('.sub-group-container');
            if (customSelectInputs.length !== 0) {
                let isSelected = Array.from(customSelectInputs).some(function (button) {
                    return button.checked && $(button).attr('id') !== 'default';
                });
                if (!isSelected) {
                    customSelectField.after('<span class="aysa-error">This field is required.</span>')

                    return false;
                }
            }

            return true;
        },

    }
    if (typeof window.SeoSettings === 'undefined') {
        window.SeoSettings = SeoSettings;
    }
})(jQuery);


