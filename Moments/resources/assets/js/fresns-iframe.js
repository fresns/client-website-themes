/*!
 * Fresns (https://fresns.org)
 * Copyright 2021-Present Jevan Tang
 * Licensed under the Apache-2.0 license
 */

function authorization() {
    let authorization;
    $.ajaxSettings.async = false;
    $.get('/api/web-engine/url-authorization', false, function (res) {
        authorization = res.data.authorization;
    });
    $.ajaxSettings.async = true;

    return authorization;
}

(function ($) {
    $('#fresnsModal.fresnsExtensions').on('show.bs.modal', function (e) {
        let button = $(e.relatedTarget),
            fsHeight = button.data('fs-height'),
            title = button.data('title'),
            reg = /\{[^\}]+\}/g,
            url = button.data('url'),
            replaceJson = button.data(),
            searchArr = url.match(reg);

        if (searchArr) {
            searchArr.forEach(function (v) {
                let attr = v.substring(1, v.length - 1);
                if (replaceJson[attr]) {
                    url = url.replace(v, replaceJson[attr]);
                } else {
                    if (v === '{authorization}') {
                        url = url.replace('{authorization}', authorization());
                    } else {
                        url = url.replace(v, '');
                    }
                }
            });
        }

        $(this).find('.modal-title').empty().html(title);
        let inputHtml = `<iframe src="` + url + `" class="iframe-modal"></iframe>`;
        $(this).find('.modal-body').empty().html(inputHtml);

        // iFrame Resizer V4
        // https://github.com/davidjbradshaw/iframe-resizer
        let isOldIE = navigator.userAgent.indexOf('MSIE') !== -1;
        $('#fresnsModal.fresnsExtensions iframe').on('load', function () {
            $(this).iFrameResize({
                autoResize: true,
                minHeight: fsHeight ? fsHeight : 500,
                heightCalculationMethod: isOldIE ? 'max' : 'lowestElement',
                scrolling: true,
            });
        });
    });
})(jQuery);
