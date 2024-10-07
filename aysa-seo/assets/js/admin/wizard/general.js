(function ($) {
    let General = {
        validate: function (form) {
            let valid = true;

            if (!this.validateRequiredFields(form)) {
                valid = false;
            }

            if (!this.validateIndustry(form)) {
                let industryInputs = form.find('input[name="aysa-industry"]');
                let industryField = industryInputs.closest('.sub-group-container');
                industryField.after('<span class="aysa-error">This field is required.</span>')

                valid = false;
            }

            let email = form.find('input[name="aysa-email"]');
            if (!this.validateEmail(email.val())) {
                email.after('<span class="aysa-error">Please enter a valid email address.</span>')
                valid = false;
            }

            let phone = form.find('input[name="aysa-telephone"]');
            if (!this.validatePhone(phone.val())) {
                phone.after('<span class="aysa-error">Please enter a valid phone number.</span>')
                valid = false;
            }

            let website = form.find('input[name="aysa-website"]');
            if (!this.validateWebsite(website.val())) {
                website.after('<span class="aysa-error">Please enter a valid website address.</span>')
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

            return valid;
        },
        validateEmail: function (email) {
            let re = /\S+@\S+\.\S+/;

            return re.test(email);
        },

        validatePhone: function (phone) {
            let re = /^\+?[0-9]+$/;

            return re.test(phone);
        },

        validateWebsite: function (website) {
            let re = /^((http|https):\/\/)?(www\.)?[a-z0-9]+\.[a-z]+(\/[a-zA-Z0-9#]+\/?)*$/;

            return re.test(website);
        },

        validateIndustry: function (form) {
            let industryInputs = form.find('input[name="aysa-industry"]');
            if (industryInputs.length !== 0) {
                let isIndustrySelected = Array.from(industryInputs).some(function (button) {
                    return button.checked && $(button).attr('id') !== 'default';
                });
                if (!isIndustrySelected) {
                    return false;
                }
            }

            return true;
        }
    }
    if (typeof window.General === 'undefined') {
        window.General = General;
    }
})(jQuery);


