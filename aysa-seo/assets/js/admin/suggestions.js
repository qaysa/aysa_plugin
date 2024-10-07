(function ($) {
    let SeoSuggestions = {
        getExistingSeo: function (entityId, entityType) {
            let params = {
                action: 'get_aysa_saved_suggestions', data: {
                    entity_id: entityId, type: entityType,
                },
            };

            return $.get(ajaxurl, params, function (response) {
                response = JSON.parse(response);
                if (response === null || response.status === 'error') {
                    return {
                        'status': 'error',
                        'message': 'Error while getting existing seo data'
                    };
                }

                if (response.status === 'error' && response.message ==='No data available.') {
                    return {
                        'status': 'no-data',
                    };
                }

                return response;
            }, 'html').fail(function () {
                return {
                    'status': 'error',
                    'message': 'Error while getting existing seo data',
                }
            });
        },

        getNewSeo: function (entityId, entityType) {
            let params = {
                action: 'get_aysa_suggestions', data: {
                    entity_id: entityId, type: entityType,
                },
            };

            return $.get(ajaxurl, params, function (response) {
                response = JSON.parse(response);
                if (response === null || response.status !== 'success') {
                    return {
                        'status': 'error',
                        'message': response.message
                    };
                }

                return response;
            }, 'html').fail(function () {
                return {
                    'status': 'error',
                    'message': 'Error while getting existing seo data',
                }
            });
        },

        populateWithSuggestions: function (response, editRow) {
            let data = response.data;
            if(data === null) {
                return;
            }

            $.each(data, function (index, value) {
                editRow.find('input[name="' + index + '"]').val(value);
                editRow.find('textarea[name="' + index + '"]').val(value);
            });

            if(data.hasOwnProperty('suggestion_errors') && data.suggestion_errors !== null) {
                let suggestion_errors = data.suggestion_errors;

                this.setMetaSuggestions(suggestion_errors.sg_meta_tile.standard, editRow, '#aysa-entity-meta-title');
                this.setMetaSuggestions(suggestion_errors.sg_meta_keywords.standard, editRow, '#aysa-entity-meta-keywords');
                this.setMetaSuggestions(suggestion_errors.sg_meta_description.standard, editRow, '#aysa-entity-meta-description');
            }
        },

        setMetaSuggestions: function (suggestions, editRow, id) {
            let elementAppend = editRow.find(id).parents('.sub-group');
            elementAppend.find('.meta-suggestions').remove();
            elementAppend.append('<div class="meta-suggestions"></div>');
            $.each(suggestions, function (key, item) {
                let className = SeoSuggestions.getErrorClassName(item.message_type);
                elementAppend.find('.meta-suggestions').append(
                    '<div class="meta-suggestion '+ className +'"> <span>' + item.message + '</span></div>'
                );
            });
        },

        getErrorClassName: function (messageType)
        {
            switch (messageType) {
                case 0:
                    return 'error-message';
                case 1:
                    return 'warning-message';
                case 2:
                    return 'success-massage';
            }
        }

    };

    if (typeof window.SeoSuggestions === 'undefined') {
        window.SeoSuggestions = SeoSuggestions;
    }
})(jQuery);
