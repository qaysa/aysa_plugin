jQuery(document).ready(function ($) {
    $('[data-toggle]').click(function () {
        $('[data-panel]').removeClass('active')
        $('[data-toggle]').removeClass('active')
        $('[data-panel=' + $(this).data('toggle') + ']').addClass('active')
        $(this).addClass('active')
    })

    let seoBtns = [
        {selector: '.page-title-action', value: 'product-title', input: 'title'},
        {selector: '#edit-slug-buttons', value: 'product-slug', input: 'new-post-slug'},
        {selector: '#wp-content-media-buttons', value: 'product-description', input: 'content'},
        {selector: '#wp-excerpt-media-buttons', value: 'product-short-description', input: 'excerpt'}
    ]

    seoBtns.forEach(function (item) {
        addSeoBtn($(item.selector), item.value, item.input)
    })

    $(document).on('click', '.seo-suggestion-btn', function (){
        var inputId = $(this).parents('.seo-suggestion-wrapper').data('input')
        $(this).parent().append('<dialog class="seo-suggestion-modal" open><button type="button" class="btn btn-accept seo-suggestion-accept">Accept</button><input type="text" readonly value="demo"/><span class="close">x</span></dialog>')
        if(inputId === 'new-post-slug') {
            $('#edit-slug-buttons button.edit-slug').trigger('click')
        }
    })

    $(document).on('click', '.close', function (){
        $(this).parent().removeAttr('open')
    })

    $(document).on('click', '.seo-suggestion-accept', function (){
        var value = $(this).siblings('input').val()
        var inputId = $(this).parents('.seo-suggestion-wrapper').data('input')
        var input = $('#'+inputId)

        if(input.hasClass('wp-editor-area')) {
            tinyMCE.get(inputId).setContent(value);
        } else {
            input.val(value)
        }
    })

    function addSeoBtn(element, value, input) {
        element.after('<div data-input="'+input+'" class="seo-suggestion-wrapper"><a href="javascript:void(0)" data-value="'+value+'" class="seo-suggestion-btn btn btn-universal">See Suggestions</a></div>')
    }
})