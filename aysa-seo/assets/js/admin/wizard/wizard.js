jQuery(document).ready(function ($) {
    $('.custom-select input').change(function () {
        $(this).parents('.form-group').find('.sub-group').hide();
        let additionalOptions = $('#' + $(this).val());
        additionalOptions.show();

        $(this).parents('details').removeAttr('open')
        additionalOptions.find('input').attr('required', 'required');
    });

    $('.custom-select input:checked').trigger('change');

    $('body').click(function () {
        $('details[open]').removeAttr('open')
    });

    $('.button-add').click(function () {
        if ($('.inputs input').length < 3) {
            $('.inputs input:first-child').clone().val('').appendTo('.inputs');
        }
        if ($('.inputs input').length == 3) {
            $(this).hide()
        }
    });

    if ($('.inputs input').length == 3) {
        $('.button-add').hide()
    }

    if ($('.inputs input').length < 3) {
        $('.button-add').show()
    }


    $('.select-with-search select').select2();

    $('#submit-form').click(function (event) {
        let form = $('#form');
        form.find('.aysa-error').remove();
        let validForm = true;

        if (form.hasClass('general-step')) {
            validForm = General.validate(form);
        }

        if (form.hasClass('objectives-step')) {
            validForm = Objectives.validate(form);
        }

        if (form.hasClass('seo-settings-step')) {
            validForm = SeoSettings.validate(form);
        }

        if (!validForm) {
            let firstError = form.find('.aysa-error:first');
            let offset = firstError.offset();
            $('html, body').animate({scrollTop: offset.top - 100}, 500);

            event.preventDefault();
        } else {
            form.submit();
        }
    });
});

function moveProgress(percentage) {
    const base = document.getElementById('wavyPathBase');
    const dot = document.getElementById('progressDot');
    const clipRect = document.getElementById('clipRect');

    // Calculate the total length of the base path
    const pathLength = base.getTotalLength();
    const position = pathLength * percentage; // Ensure the percentage is in decimal form

    // Use getPointAtLength to get the x, y coordinates of a point at a given distance along the base path
    const point = base.getPointAtLength(position);

    dot.setAttribute('cx', point.x);
    dot.setAttribute('cy', point.y);

    // Adjust the width of the mask's rectangle to hide/reveal the progress path
    clipRect.setAttribute('width', point.x);
}

function generateWavyPath(containerWidth) {
    const patternWidth = 100;
    let d = `M1.5 29.2842`;
    containerWidth += 50;

    let accumulatedWidth = 1.5; // starting x-coordinate
    while (accumulatedWidth < containerWidth) {
        if (accumulatedWidth + patternWidth > containerWidth) {
            // If adding a full segment overshoots, break the loop to cut off the wave
            break;
        }

        d += `C${accumulatedWidth + 66.5} 6 ${accumulatedWidth + 31.8203} 51.5 ${accumulatedWidth + patternWidth} 29.2842 `;
        accumulatedWidth += patternWidth;
    }

    return d;
}

let containerWidth = 0;
let svgPath, svgPath2, svg = {};

document.addEventListener('DOMContentLoaded', () => {
    generatePaths();
    moveProgress(document.getElementById('slider').value);
    document.querySelector('.custom-progress-container').style.opacity = '1';
});

window.addEventListener('resize', () => {
    generatePaths();
    // Adjust the dot's position
    moveProgress(document.getElementById('slider').value);
});

function generatePaths() {
    containerWidth = document.querySelector('.custom-progress-container').offsetWidth;
    svgPath = document.getElementById('wavyPathBase');
    svgPath2 = document.getElementById('wavyPathProgress');

    svgPath.setAttribute('d', generateWavyPath(containerWidth));
    svgPath2.setAttribute('d', generateWavyPath(containerWidth));

    // Adjust viewBox again based on the new width
    svg = document.querySelector('svg#progress-bar');
    const viewBoxHeight = 60; // Assuming the height of the wave fits in 60 units
    const dotRadius = 30;
    svg.setAttribute('viewBox', `${-dotRadius / 2} 0 ${containerWidth + dotRadius} ${viewBoxHeight}`);
}