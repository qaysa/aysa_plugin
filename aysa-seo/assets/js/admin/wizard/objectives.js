(function ($) {
    let Objectives = {

        initialize: function () {
            if ($('#form').hasClass('objectives-step')) {
                this.limitCheckbox('input[name="aysa-goals[]"]', 1, 3);
            }
        },

        validate: function (form) {
            let objectives = form.find('input[name="aysa-goals[]"]:checked');
            let maxLimit = 3;
            if (objectives.length === 0) {
                let message = 'You must select at least one option.';
                form.find('input[name="aysa-goals[]"]')
                    .closest('.radio-button-group')
                    .after('<span class="aysa-error">' + message + '</span>')

                return false;
            }

            if (objectives.length > maxLimit) {
                let message = 'You can only select up to ' + maxLimit + ' options.';
                form.find('input[name="aysa-goals"]')
                    .closest('.radio-button-group')
                    .after('<span class="aysa-error">' + message + '</span>')

                return false;
            }

            return true;
        },

        limitCheckbox: function (checkboxes, minLimit, maxLimit) {
            $(checkboxes).change(function () {
                let checkedCheckboxes = $(checkboxes + ':checked');

                if (checkedCheckboxes.length > maxLimit) {
                    $(this).prop('checked', false);
                }

                if (checkedCheckboxes.length < minLimit) {
                    this.checked = true;
                }
            });
        }

    }
    if (typeof window.Objectives === 'undefined') {
        window.Objectives = Objectives;
        Objectives.initialize();
    }
})(jQuery);


