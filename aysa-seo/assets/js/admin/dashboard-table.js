jQuery(function ($) {
    $(document).ready(function () {
        let aysaTable = $('#inline-edit').clone(true);
        $('#inline-edit').remove();
        let aysaSeoTable = $('#aysa-seo-table-form');
        let selectElement = document.getElementById("type-filter");
        let formElement = document.getElementById("filter-form");

        $('a.editinline').click(function (e) {
            e.preventDefault();
            let entityId = $(this).data('id');
            let entityType = $(this).data('type');

            resetQuickEdit();
            quickEdit(entityId, entityType);
        });

        $(document).on('click', '.notices .notice-dismiss', function (){
            $(this).parent().remove()
        })

        aysaSeoTable.on('click', '.inline-edit-save .cancel', function (e) {
            e.preventDefault();
            resetQuickEdit();
        });

        aysaSeoTable.on('click', '.submit.inline-edit-save .save', function (e) {
            e.preventDefault();
            saveData(this);
        });

        aysaSeoTable.on('click', '.button.get-seo', function (e) {
            var overlay = $(this).parents('.inline-edit-wrapper').find('.overlay')
            overlay.show()
            e.preventDefault();
            getSuggestions(this);
        });

        aysaSeoTable.on('click', '.actions .btn-accept', function (e) {
            e.preventDefault();
            replaceValue(this)
        });

        aysaSeoTable.on('click', '[name=gallery_switch]', function (event) {
            toggleGallery($(this));
        });

        aysaSeoTable.on('click', '.rudr-upload, .edit', function (event) {
            event.preventDefault();
            update_image_gallery($(this));
        });

        aysaSeoTable.on('change', 'input[name="track"]',function(){
            this.value = (Number(this.checked));
        });

        selectElement.addEventListener("change", function () {
            formElement.submit();
        });

        function quickEdit(entityId, entityType) {
            let editRow = aysaTable

            let trClass = 'edit-' + entityType + '-' + entityId;
            let inlineEditorRow = $('<tr>', {
                'class': 'inline-editor inline-edit-row ' + trClass, 'style': 'display: none;'
            }).append($('<td>', {
                'colspan': aysaSeoTable.find('thead > tr > *').length, 'html': editRow.html()
            }));
            aysaSeoTable.find('tr#' + entityType + '-' + entityId).after(inlineEditorRow);
            aysaSeoTable.find('tr#' + entityType + '-' + entityId).addClass('active')

            inlineEditorRow.attr('data-id', entityId);
            inlineEditorRow.attr('data-type', entityType);

            inlineEditorRow.find('#aysa-entity-description').attr('data-accepted', 'description');
            inlineEditorRow.find('#aysa-entity-suggested-description').attr('data-suggested', 'description');

            populateWithData(entityId, entityType);
            populateWithSuggestions(entityId, entityType);
        }

        function resetQuickEdit() {
            aysaSeoTable.find('tr.active').removeClass('active');
            aysaSeoTable.find('.inline-editor').remove();
        }

        function populateWithData(entityId, entityType) {

            let editRow = $('.edit-' + entityType + '-' + entityId);
            let params = {
                action: 'aysa_inline_data', data: {
                    entity_id: entityId, type: entityType,
                },
            };

            $.get(ajaxurl, params, function (response) {
                response = JSON.parse(response);
                if (response === null || response.status !== 'success') {
                    //TODO show an error message without using alert
                    alert("error");
                }

                let data = response.data;
                editRow.find('input[name="entity_id"]').val(entityId);
                editRow.find('input[name="type"]').val(entityType);
                $.each(data, function (index, value) {
                    editRow.find('input[name="' + index + '"]').val(value);
                    editRow.find('textarea[name="' + index + '"]').val(value);
                });
                if (data.image) {
                   appendSingleImage(editRow, data.image)
                }
                if (data.image_gallery) {
                    appendGalleryImages(editRow, data.image_gallery)
                }

                if(data.track && data.track === '1'){
                    editRow.find('input[name="track"]').prop('checked', true);
                }

                toggleGallery(editRow.find('[name=gallery_switch]'));
                $(editRow).show();
            }, 'html').fail(function () {
                alert("error");
            });
        }

        async function getSuggestions(element) {
            let editRow = $(element).closest('tr')
            let entityId = $(editRow).data('id');
            let entityType = $(editRow).data('type');

            let response = await SeoSuggestions.getNewSeo(entityId, entityType);
            response = JSON.parse(response);

            if(response.status && response.status === 'error'){
                alert(response.message)
            }

            SeoSuggestions.populateWithSuggestions(response, editRow)
            editRow.find('.overlay').hide()
            show_notices(response)
        }

        async function populateWithSuggestions(entityId, entityType) {
            let editRow = $('.edit-' + entityType + '-' + entityId);

            let response = await SeoSuggestions.getExistingSeo(entityId, entityType);
            response = JSON.parse(response);
            if(response.status && response.status === 'error'){
                alert(response.message)
            }

            SeoSuggestions.populateWithSuggestions(response, editRow);
            editRow.find('.overlay').hide()
            show_notices(response)
        }

        function show_notices(response) {
            let classes = {success: 'notice-success', error: 'notice-error', warning: 'notice-warning'}
            response = JSON.parse(response)
            $('.notices').append('<div class="notice is-dismissible ' + classes[response.status] + '"><p>' + response.message + '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss</span></button></div>');
        }

        function saveData(element) {
            let editRow = $(element).closest('tr')
            let entityId = $(editRow).data('id');
            let entityType = $(editRow).data('type');

            let fields = $('.edit-' + entityType + '-' + entityId).find(':input').serialize();

            $.post(ajaxurl, {
                action: 'aysa_inline_save', data: fields,
            }, function (response) {
                //TODO show an error message without using alert
                location.reload();
            }, 'html').fail(function () {
                console.log("error");
            });
        }

        function update_image_gallery(button) {
            let editRow = $(button).closest('tr')
            let gallery = editRow.find('[name=gallery_switch]:checked').val() === 'gallery'
            let entityId = editRow.find('input[name="entity_id"]').val();
            let entityType = editRow.find('input[name="type"]').val();

            let customUploader = wp.media({
                title: 'Insert image', library: {
                    type: 'image', 'entityId': entityId, 'entityType': entityType,
                }, button: {
                    text: 'Use this image'
                }, multiple: gallery
            })

            let preselectedImages = [];
            if (gallery) {
                preselectedImages = editRow.find('input.image-gallery').val().split(',');
            } else {
                preselectedImages.push(editRow.find('input.single-image').val());
            }

            customUploader.on('open', function () {
                let selection = customUploader.state().get('selection');
                preselectedImages.forEach(function (attachmentId) {
                    var attachment = wp.media.attachment(attachmentId);
                    attachment.fetch();
                    selection.add(attachment);
                });
            });

            customUploader.on('select', function () {
                if (gallery) {
                    let attachments = customUploader.state().get('selection').toJSON();
                    appendGalleryImages(editRow, attachments)
                } else {
                    let attachment = customUploader.state().get('selection').first().toJSON();
                    appendSingleImage(editRow, attachment)
                }

                toggleGallery(editRow.find('[name=gallery_switch]'));
            })

            customUploader.open()
        }

        function toggleGallery(element) {
            let editRow = element.closest('tr');
            let gallery = editRow.find('[name=gallery_switch]:checked').val() === 'gallery';
            let singleImageInput = editRow.find('input.single-image');
            let galleryInput = editRow.find('input.image-gallery');
            let rudrUploadButton = editRow.find('.button.rudr-upload');
            let editButton = editRow.find('.edit');


            if (gallery && galleryInput.val() !== '') {
                editRow.find('.thumbs .single-image').hide();
                editRow.find('.thumbs .image-gallery').show();
                rudrUploadButton.hide();
                editButton.show();
            }

            if (gallery && galleryInput.val() === '') {
                editRow.find('.thumbs .single-image').hide();
                editRow.find('.thumbs .image-gallery').hide();
                rudrUploadButton.show();
                editButton.hide();
            }

            if (!gallery && singleImageInput.val() !== '') {
                editRow.find('.thumbs .single-image').show();
                editRow.find('.thumbs .image-gallery').hide();
                rudrUploadButton.hide();
                editButton.show();
            }

            if (!gallery && singleImageInput.val() === '') {
                editRow.find('.thumbs .single-image').hide();
                editRow.find('.thumbs .image-gallery').hide();
                rudrUploadButton.show();
                editButton.hide();
            }
        }

        function appendSingleImage(editRow, data)
        {
            let thumbs_single = editRow.find('.thumbs .single-image');
            thumbs_single.empty();
            thumbs_single.append('<img src="' + data.url + '" alt="" />');
            editRow.find('input.single-image').val(data.id);
        }

        function appendGalleryImages(editRow, data){
            let thumbs_gallery = editRow.find('.thumbs .image-gallery');
            let attachment_ids = [];
            thumbs_gallery.empty();

            data.forEach(function (item) {
                attachment_ids.push(item.id);
                if(!item.url){
                    return;
                }
                thumbs_gallery.append('<img src="' + item.url + '" alt="" />');
                thumbs_gallery.addClass('imgs-grid');
                editRow.find('.image-block').addClass('imgs-block');
            })

            editRow.find('input.image-gallery').val(attachment_ids);
        }

        function replaceValue(element) {
            let inputToChange = element.getAttribute('data-input-name');
            let value = aysaSeoTable.find('[data-suggested="' + inputToChange + '"]').val();

            aysaSeoTable.find('[data-accepted="' + inputToChange + '"]').val(value);
        }

    });
});
