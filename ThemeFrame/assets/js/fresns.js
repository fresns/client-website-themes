/*!
 * Fresns (https://fresns.org)
 * Copyright 2021-Present Jarvis Tang
 * Licensed under the Apache-2.0 license
 */

// bootstrap Tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

// set timeout toast hide
const setTimeoutToastHide = () => {
    $('.toast.show').each((k, v) => {
        setTimeout(function () {
            $(v).hide();
        }, 1500);
    });
};

/* Fresns Token */
$.ajaxSetup({
    headers: {
        Accept: 'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
});

const sleep = (delay = 500) => {
    let t = Date.now();
    while (Date.now() - t <= delay) {
        continue;
    }
};

// fs_lang
window.fs_lang = function (key, replace = {}) {
    let translation = key.split('.').reduce((t, i) => {
        if (!t.hasOwnProperty(i)) {
            return key;
        }
        return t[i];
    }, window.translations || []);

    for (var placeholder in replace) {
        translation = translation.replace(`:${placeholder}`, replace[placeholder]);
    }

    return translation;
};

// tips
window.tips = function (message, code = 200) {
    let html = `
        <div aria-live="polite" aria-atomic="true" class="position-fixed top-50 start-50 translate-middle" style="z-index:9999">
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="/static/images/icon.png" width="20px" height="20px" class="rounded me-2" alt="Fresns">
                    <strong class="me-auto">Fresns</strong>
                    <small>${code}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">${message}</div>
            </div>
        </div>`;
    $('div.fresns-tips').prepend(html);
    setTimeoutToastHide();
};

// copy url
function copyToClipboard(element) {
    var $temp = $('<input>');
    $('body').append($temp);
    $temp.val($(element).text()).select();
    document.execCommand('copy');
    $temp.remove();
    window.tips(fs_lang('copySuccess'));
}

// send verify code
function sendVerifyCode(obj) {
    let type = $(obj).data('type'),
        useType = $(obj).data('use-type'),
        templateId = $(obj).data('template-id'),
        countryCode = $(obj).parent().prev().find('select').val(),
        account = $(obj).parent().prev().find('input').val(),
        action = $(obj).data('action');

    if (!account) {
        account = $(obj).prev('input').val();
    }

    fetchSendVerifyCode(type, useType, templateId, account, action, obj, countryCode);
}

/**
 *
 * @param type
 * @param useType
 * @param templateId
 * @param account
 * @param action
 * @param countryCode
 */
function fetchSendVerifyCode(type, useType, templateId, account, action, obj, countryCode) {
    let data;
    if (type == 'email') {
        if (!account) {
            window.tips(fs_lang('email') + ': ' + fs_lang('errorEmpty'));
            return;
        }
        data = { type: type, useType: useType, templateId: templateId, account: account };
    } else if (type == 'sms') {
        if (!account) {
            window.tips(fs_lang('phone') + ': ' + fs_lang('errorEmpty'));
            return;
        }
        data = { type: type, useType: useType, templateId: templateId, account: account, countryCode: countryCode };
    }

    $.ajax({
        url: action,
        type: 'post',
        data: data,
        error: function (error) {
            alert(error.responseJSON.message);
        },
        success: function (res) {
            if (res.code != 0) {
                return window.tips(res.message);
            }

            window.tips(fs_lang('success'));
            window.settime($(obj));
        },
    });
}

// download file
function downloadFile(data, fileName, type = 'text/plain') {
    // Create an invisible A element
    const a = document.createElement('a');
    a.style.display = 'none';
    document.body.appendChild(a);
    // Set the HREF to a Blob representation of the data to be downloaded
    a.href = window.URL.createObjectURL(new Blob([data], { type }));
    // Use download attribute to set set desired file name
    a.setAttribute('download', fileName);
    // Trigger the download by simulating click
    a.click();
    // Cleanup
    window.URL.revokeObjectURL(a.href);
    document.body.removeChild(a);
}

// comment box
function showReply(fresnsReply) {
    if (fresnsReply.hasClass('show')) {
        fresnsReply.hide();
        fresnsReply.removeClass('show');
    } else {
        fresnsReply.addClass('show');
        fresnsReply.show();
    }
}

// at and hashtag
function atwho() {
    $('.fresns-content')
        .atwho({
            at: '@',
            displayTpl:
                "<li><img src='${image}' height='20' width='20'/> ${nickname} <small class='text-muted'>@${name}</small></li>",
            callbacks: {
                remoteFilter: function (query, callback) {
                    if (query) {
                        $.get(
                            '/api/engine/input-tips',
                            { type: 'user', key: query },
                            function (data) {
                                callback(data);
                            },
                            'json'
                        );
                    }
                },
            },
        })
        .atwho({
            at: '#',
            displayTpl: '<li> ${name} </li>',
            insertTpl: window.hashtag_show == 2 ? '${atwho-at}${name}${atwho-at}' : '${atwho-at}${name}',
            callbacks: {
                remoteFilter: function (query, callback) {
                    if (query) {
                        $.get(
                            '/api/engine/input-tips',
                            { type: 'hashtag', key: query },
                            function (data) {
                                callback(data);
                            },
                            'json'
                        );
                    }
                },
            },
        });
}

// progress
window.progress = {
    total: 100,
    valuenow: 0,
    speed: 1000,
    parentElement: null,
    stop: false,
    html: function () {
        return `<div class="progress-bar" role="progressbar" style="width: ${progress.valuenow}%" aria-valuenow="${progress.valuenow}" aria-valuemin="0" aria-valuemax="100">${progress.valuenow}</div>`;
    },
    setParentElement: function (pe) {
        this.parentElement = pe;
        return this;
    },
    init: function () {
        this.total = 100;
        this.valuenow = 0;
        this.parentElement = null;
        this.stop = false;
        return this;
    },
    work: function () {
        this.add(progress);
    },
    add: function (obj) {
        if (obj.stop !== true && obj.valuenow < obj.total) {
            let num = parseFloat(obj.total) - parseFloat(obj.valuenow);
            obj.valuenow = (parseFloat(obj.valuenow) + parseFloat(num / 100)).toFixed(2);
            obj.parentElement.empty().append(obj.html());
        } else {
            obj.parentElement.empty().append(obj.html());
            return;
        }
        setTimeout(function () {
            obj.add(obj);
        }, obj.speed);
    },
    exit: function () {
        this.stop = true;
        sleep(1000);
        return this;
    },
    done: function () {
        this.valuenow = this.total;
        sleep(1000);
        return this;
    },
    clearHtml: function () {
        this.parentElement?.empty();
    },
};

// verification
function accountVerification(obj) {
    let codeType = $(obj).data('code-type'),
        verifyCode = $(obj).prev().val(),
        action = $(obj).data('action');
    $(obj).prop('disabled', true);
    $(obj).prepend('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> ');

    $.ajax({
        url: action,
        type: 'post',
        data: { type: codeType, action, verifyCode },
        error: function (error) {
            $(obj).prev().addClass('is-invalid');
            $(obj).after(`<div class="invalid-feedback">` + error.responseJSON.message + `</div>`);
        },
        success: function (res) {
            if (res.code !== 0) {
                window.tips(res.message);
                return;
            }

            let html = '';
            $(obj)
                .parent()
                .siblings()
                .each(function (k, v) {
                    $(v).removeClass('d-none');
                });
        },
        complete: function () {
            $(obj).prop('disabled', false);
            $(obj).children('.spinner-border').remove();
        },
    });
}

// build form and submit
window.buildFormAndSubmit = function (url, method, body) {
    const form = document.createElement('form');
    form.style = 'display:none;';
    form.method = 'POST';
    form.action = url;
    let e1 = document.createElement('input');
    e1.name = '_method';
    e1.value = method;
    form.appendChild(e1);
    let e2 = document.createElement('input');
    e2.name = '_token';
    e2.value = $('meta[name="csrf-token"]').attr('content');
    form.appendChild(e2);

    for (const k in body) {
        let e = document.createElement('input');
        e.name = k;
        if (body.hasOwnProperty(k)) {
            e.value = body[k];
        }
        form.appendChild(e);
    }

    document.body.appendChild(form);
    form.submit();
};

// build ajax and submit
window.buildAjaxAndSubmit = function (url, body, succeededCallback, failedCallback, completeCallback = null) {
    $.ajax({
        type: 'POST',
        url: url,
        data: body,
        error: function (e) {
            typeof failedCallback == 'function' && failedCallback(e);
        },
        success: function (e) {
            typeof succeededCallback == 'function' && succeededCallback(e);
        },
        complete: function (e) {
            typeof completeCallback == 'function' && completeCallback(e);
        },
    });
};

(function ($) {
    // tip toast time
    setTimeoutToastHide();

    // at and hashtag
    atwho();

    // image zoom
    $('.zoom-image').on('click', function () {
        $('#imageZoom img').attr('src', $(this).data('zoom-src'));
        $('#imageZoom').modal('show');
    });

    // jquery extend
    $.fn.extend({
        insertAtCaret: function (myValue) {
            var $t = $(this)[0];
            if (document.selection) {
                this.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            } else if ($t.selectionStart || $t.selectionStart == '0') {
                var startPos = $t.selectionStart;
                var endPos = $t.selectionEnd;
                var scrollTop = $t.scrollTop;
                $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                this.focus();
                $t.selectionStart = startPos + myValue.length;
                $t.selectionEnd = startPos + myValue.length;
                $t.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        },
    });

    // comment box
    $('.fresns-trigger-reply').on('click', function () {
        var fresnsReply = $(this).parent().next();
        showReply(fresnsReply);
    });

    $('.fresns-reply .btn-close').on('click', function () {
        var fresnsReply = $(this).parent().parent();
        showReply(fresnsReply);
    });

    // file download and users
    $('.fresns-file-users').on('click', function () {
        var fid = $(this).data('fid');
        if (!fid) {
            window.tips(fs_lang('errorNoInfo'));
            return;
        }

        var modal = $(this).next('.modal');

        $(modal).find('.file-download-user').parent().css('display', 'none');
        $(modal).find('.file-download-user .text-muted').css('display', 'none');

        $.ajax({
            method: 'get',
            url: `/api/engine/content/file/${fid}/users`,
            success: function (res) {
                if (res.code != 0) {
                    return window.tips(res.message);
                }

                if (!res.data || res.data.list.length <= 0) {
                    $(modal).find('.file-download-user .file-user-list').html('');
                    return;
                }
                if (res.data && res.data.paginate.total > 30) {
                    $(modal).find('.file-download-user .text-muted').css('display', 'block');
                }

                var html = '';
                var item = null;
                for (var i = 0; i < res.data.list.length; i++) {
                    item = res.data.list[i];

                    html += `<img src="${item.downloadUser.avatar}" alt="${item.downloadUser.username}" class="rounded-circle">`;
                }

                $(modal).find('.file-download-user .file-user-list').html(html);
                $(modal).find('.file-download-user').parent().css('display', 'block');
            },
        });
    });

    $('.fresns-file-download').on('click', function (e) {
        e.preventDefault();
        var name = $(this).data('name');
        var mime = $(this).data('mime');

        $.ajax({
            method: 'get',
            url: $(this).attr('href'),
            success: function (res) {
                if (res.code != 0) {
                    return window.tips(res.message);
                }

                $.ajax({
                    method: 'get',
                    url: res.data.originalUrl,
                    success: function (res) {
                        downloadFile(res, name, mime);
                    },
                });
            },
        });
    });

    // show loading spinner while processing a form
    // https://getbootstrap.com/docs/5.1/components/spinners/
    $(document).on('submit', 'form', function () {
        var btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true);
        if (0 === btn.children('.spinner-border').length) {
            btn.prepend(
                '<span class="spinner-border spinner-border-sm mg-r-5 d-none" role="status" aria-hidden="true"></span> '
            );
        }
        btn.children('.spinner-border').removeClass('d-none');
    });

    // post box
    $('.form-post-box').submit(function (e) {
        e.preventDefault();
        let form = $(this),
            data = new FormData($(this)[0]),
            btn = $(this).find('button[type="submit"]'),
            actionUrl = $(this).attr('action');

        $.ajax({
            type: 'POST',
            url: actionUrl,
            data: data, // serializes the form's elements.
            processData: false,
            cache: false,
            contentType: false,
            success: function (res) {
                tips(res.message, res.code);
                if (res.code != 0 || res.code == 38200) {
                    window.tips(res.message);
                    return;
                }
                window.location.reload();
            },
            complete: function (e) {
                btn.prop('disabled', false);
                btn.find('.spinner-border').remove();
            },
        });
    });

    // comment box
    $('.form-comment-box').submit(function (e) {
        e.preventDefault();
        let form = $(this),
            data = new FormData($(this)[0]),
            btn = $(this).find('button[type="submit"]'),
            actionUrl = $(this).attr('action'),
            fresnsReply = $(this).parent().parent();

        $.ajax({
            type: 'POST',
            url: actionUrl,
            data: data, // serializes the form's elements.
            processData: false,
            cache: false,
            contentType: false,
            success: function (res) {
                tips(res.message, res.code);
                if (res.code == 38200) {
                    window.tips(res.message);
                    btn.prop('disabled', false);
                    btn.find('.spinner-border').remove();
                    return;
                }
                if (fresnsReply.prev().find('.cm-count').length === 1) {
                    if (res.code === 0) {
                        let oldCount = fresnsReply.prev().find('.cm-count').text();
                        fresnsReply
                            .prev()
                            .find('.cm-count')
                            .text(parseInt(oldCount) + 1);
                        form[0].reset();
                        showReply(fresnsReply);
                    }
                    btn.prop('disabled', false);
                    btn.find('.spinner-border').remove();
                } else {
                    window.location.reload();
                }
            },
        });
    });

    // fs mark ajax submit
    $(document).on('click', '.fs-mark', function (e) {
        e.preventDefault();
        let obj = $(this);
        obj.prop('disabled', true);
        obj.prepend('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> ');

        let form = obj.parent('form');

        const url = form.attr('action'),
            body = form.serialize(),
            interactiveType = form.find('input[name="interactiveType"]').val(),
            count = obj.find('.show-count').text(),
            iconActive = obj.data('icon-active'),
            interactiveActive = obj.data('interactive-active') || 0,
            text = obj.find('.show-text'),
            bi = obj.data('bi'),
            icon = obj.data('icon');

        window.buildAjaxAndSubmit(
            url,
            body,
            function (e) {
                if (e.code != 0) {
                    window.tips(e.message);
                    return;
                }

                if (interactiveActive) {
                    obj.data('interactive-active', 0);
                } else {
                    obj.data('interactive-active', 1);
                }

                if (iconActive) {
                    obj.find('img').attr('src', interactiveActive == 0 ? iconActive : icon);
                    if (interactiveActive) {
                        obj.removeClass('btn-active');
                    } else {
                        obj.addClass('btn-active');
                    }
                }

                if (count) {
                    if (interactiveActive) {
                        obj.find('.show-count').text(parseInt(count) - 1);
                    } else {
                        obj.find('.show-count').text(parseInt(count) + 1);
                    }
                }

                if (text) {
                    const isFollowOrBlock = interactiveType === 'follow' || interactiveType === 'block';

                    if (isFollowOrBlock && interactiveActive) {
                        obj.find('.show-text').text(obj.data('name'));
                    } else {
                        obj.find('.show-text').text('√ ' + obj.data('name'));
                    }
                }
                if (bi) {
                    obj.find('i').removeClass();
                    if (interactiveActive) {
                        if (bi.indexOf('-fill') > 0) {
                            obj.find('i').addClass('bi ' + bi.slice(0, -5));
                        } else {
                            obj.find('i').addClass('bi ' + bi);
                        }
                        obj.hasClass('btn')
                            ? obj.removeClass('btn-success').addClass('btn-outline-success')
                            : obj.removeClass('text-success');
                    } else {
                        obj.find('i').addClass('bi ' + bi);
                        obj.hasClass('btn')
                            ? obj.addClass('btn-success').removeClass('btn-outline-success')
                            : obj.addClass('text-success');
                    }
                }
                interactiveType === 'like' ? obj.addClass('btn-pre') : obj.removeClass('btn-pre');

                if (interactiveType == 'like') {
                    let formObj = form.parent().find('form')[1];
                    let likeOrDislikeObj;
                    if (formObj && formObj !== form[0]) {
                        likeOrDislikeObj = $(formObj).find('.fs-mark');
                    } else {
                        likeOrDislikeObj = $(form.parent().parent().find('form')[1]).find('.fs-mark');
                    }
                    const likeOrDislikeObjInteractiveActivate = likeOrDislikeObj.data('interactive-active') || 0;
                    const likeOrDislikeObjCount = likeOrDislikeObj.find('.show-count').text();

                    if (likeOrDislikeObjCount) {
                        if (likeOrDislikeObjInteractiveActivate) {
                            likeOrDislikeObj.find('.show-count').text(parseInt(likeOrDislikeObjCount) - 1);
                            likeOrDislikeObj.data('interactive-active', 0);
                        }
                    }

                    const likeOrDislikeObjBi = likeOrDislikeObj.data('bi');
                    if (likeOrDislikeObjBi) {
                        const fillPosition = likeOrDislikeObjBi.includes('-fill') ? -5 : 0;
                        const newBi =
                            fillPosition != 0 ? likeOrDislikeObjBi.slice(0, fillPosition) : likeOrDislikeObjBi.slice(0);

                        likeOrDislikeObj.find('i').removeClass();
                        likeOrDislikeObj.find('i').addClass('bi ' + newBi);
                        likeOrDislikeObj.hasClass('btn')
                            ? likeOrDislikeObj.removeClass('btn-success').addClass('btn-outline-success')
                            : likeOrDislikeObj.removeClass('text-success');
                    } else {
                        const likeOrDislikeObjIconActive = likeOrDislikeObj.data('icon-active');
                        const likeOrDislikeObjIcon = likeOrDislikeObj.data('icon');

                        if (likeOrDislikeObjIconActive && likeOrDislikeObjInteractiveActivate) {
                            likeOrDislikeObj
                                .find('img')
                                .attr(
                                    'src',
                                    likeOrDislikeObjInteractiveActivate == 0
                                        ? likeOrDislikeObjIconActive
                                        : likeOrDislikeObjIcon
                                );
                            likeOrDislikeObj.hasClass('btn')
                                ? likeOrDislikeObj.removeClass('btn-active').addClass('btn-outline-success')
                                : likeOrDislikeObj.removeClass('text-success');
                        }
                    }
                } else if (interactiveType == 'dislike') {
                    let formObj = form.parent().find('form')[0];
                    let likeOrDislikeObj;
                    if (formObj && formObj !== form[0]) {
                        likeOrDislikeObj = $(formObj).find('.fs-mark');
                    } else {
                        likeOrDislikeObj = $(form.parent().parent().find('form')[0]).find('.fs-mark');
                    }
                    const likeOrDislikeObjInteractiveActivate = likeOrDislikeObj.data('interactive-active') || 0;
                    const likeOrDislikeObjCount = likeOrDislikeObj.find('.show-count').text();

                    if (likeOrDislikeObjCount) {
                        if (likeOrDislikeObjInteractiveActivate) {
                            likeOrDislikeObj.find('.show-count').text(parseInt(likeOrDislikeObjCount) - 1);
                            likeOrDislikeObj.data('interactive-active', 0);
                        }
                    }

                    const likeOrDislikeObjBi = likeOrDislikeObj.data('bi');
                    if (likeOrDislikeObjBi) {
                        const fillPosition = likeOrDislikeObjBi.includes('-fill') ? -5 : 0;
                        const newBi =
                            fillPosition != 0 ? likeOrDislikeObjBi.slice(0, fillPosition) : likeOrDislikeObjBi.slice(0);

                        likeOrDislikeObj.find('i').removeClass();
                        likeOrDislikeObj.find('i').addClass('bi ' + newBi);
                        likeOrDislikeObj.hasClass('btn')
                            ? likeOrDislikeObj.removeClass('btn-success').addClass('btn-outline-success')
                            : likeOrDislikeObj.removeClass('text-success');
                    } else {
                        const likeOrDislikeObjIconActive = likeOrDislikeObj.data('icon-active');
                        const likeOrDislikeObjIcon = likeOrDislikeObj.data('icon');

                        if (likeOrDislikeObjIconActive && likeOrDislikeObjInteractiveActivate) {
                            likeOrDislikeObj
                                .find('img')
                                .attr(
                                    'src',
                                    likeOrDislikeObjInteractiveActivate == 0
                                        ? likeOrDislikeObjIconActive
                                        : likeOrDislikeObjIcon
                                );
                            likeOrDislikeObj.hasClass('btn')
                                ? likeOrDislikeObj.removeClass('btn-active').addClass('btn-outline-success')
                                : likeOrDislikeObj.removeClass('text-success');
                        }
                    }
                }

                window.tips(e.message);
            },
            function (e) {
                window.tips(e.responseJSON.message, e.responseJSON.code);
            },
            function (e) {
                obj.prop('disabled', false);
                obj.children('.spinner-border').remove();
            }
        );
    });

    // web request link
    $(document).on('click', '.web-request-link', function (e) {
        e.preventDefault();
        $(this).prop('disabled', true);
        $(this).prepend(
            '<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> '
        );

        const url = $(this).data('action'),
            method = $(this).data('method') || 'POST',
            body = $(this).data('body') || {};

        window.buildFormAndSubmit(url, method, body);
    });

    // api request link
    $(document).on('click', '.api-request-link', function (e) {
        e.preventDefault();
        $(this).prop('disabled', true);
        $(this).prepend(
            '<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> '
        );

        const url = $(this).data('action'),
            type = $(this).data('method') || 'POST',
            id = $(this).data('id'),
            data = $(this).data('body') || {},
            btn = $(this);
        $.ajax({
            url,
            type,
            data,
            success: function (res) {
                if (res.code === 0) {
                    if (id) {
                        if (
                            $('#' + id)
                                .next()
                                .prop('nodeName') === 'HR'
                        ) {
                            $('#' + id)
                                .next()
                                .remove();
                        }
                        $('#' + id).remove();
                    } else {
                        tips(res.message, res.code);
                        window.location.reload();
                    }
                } else {
                    tips(res.message, res.code);
                }
            },
            complete: function (e) {
                btn.prop('disabled', false);
                btn.find('.spinner-border').remove();
            },
        });
    });

    // api request form
    $('.api-request-form').submit(function (e) {
        e.preventDefault();
        let form = $(this),
            btn = $(this).find('button[type="submit"]');

        const url = form.attr('action'),
            type = form.attr('method') || 'POST',
            data = form.serialize();

        $.ajax({
            url,
            type,
            data,
            success: function (res) {
                tips(res.message, res.code);
                if (res.code != 0) {
                    window.tips(res.message);
                    return;
                }
                window.location.reload();
            },
            complete: function (e) {
                btn.prop('disabled', false);
                btn.find('.spinner-border').remove();
            },
        });
    });

    // User Settings
    $('#editModal.user-edit').on('show.bs.modal', function (e) {
        let button = $(e.relatedTarget),
            lable = button.data('lable'),
            name = button.data('name'),
            desc = button.data('desc') ?? '',
            type = button.data('type'),
            inputTips = button.data('input-tips'),
            option = button.data('option'),
            action = button.data('action'),
            email = button.data('email') ?? '',
            phone = button.data('phone') ?? '',
            value = button.data('value') ?? '';

        $(this).find('.modal-title').empty().html(lable);
        $(this).find('form').attr('action', action);
        $(this)
            .find('.modal-footer button[type="submit"]')
            .data('targe-type', type ?? 'input')
            .data('targe-name', name);

        let html = '';
        switch (type) {
            case 'select':
                html =
                    `
                <div class="input-group has-validation">
                    <label class="input-group-text border-end-rounded-0">` +
                    lable +
                    `</label>
                    <select class="form-select" name="` +
                    name +
                    `">`;
                $(option).each(function (k, v) {
                    let selected = value == v.id ? 'selected' : '';
                    html += `<option ` + selected + ` value="` + v.id + `">` + v.text + `</option>`;
                });
                html += `
                    </select>
                </div>`;
                break;
            case 'textarea':
                html =
                    `
                <div class="input-group has-validation">
                    <span class="input-group-text border-end-rounded-0">` +
                    lable +
                    `</span>
                    <textarea class="form-control ` +
                    inputTips +
                    `" name="` +
                    name +
                    `" rows="3">` +
                    value +
                    `</textarea>
                </div>`;
                break;
            case 'date':
                html =
                    `
                <div class="input-group has-validation">
                    <span class="input-group-text border-end-rounded-0">` +
                    lable +
                    `</span>
                    <input type="date" class="form-control" name="` +
                    name +
                    `" value="` +
                    value +
                    `" required>
                </div>`;
                break;
            default:
                if (name === 'editPhone' && !value) {
                    let smsCodes = button.data('sms-codes'),
                        defaultSmsCode = button.data('default-sms-code');
                    html =
                        `
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text border-end-rounded-0">` +
                        lable +
                        `</span>
                        <select class="form-select" name="editCountryCode">
                            <option disabled>Country Calling Codes</option>`;
                    $(smsCodes).each(function (k, v) {
                        let selected = v == defaultSmsCode ? 'selected' : '';
                        html += `<option ` + selected + ` value="` + v + `">` + v + `</option>`;
                    });
                    html +=
                        `
                        </select>
                        <input type="text" class="form-control w-50" name="` +
                        name +
                        `" value="" required>
                        <input type="hidden" name="codeType" value="sms">
                    </div>
                    <div class="input-group has-validation">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('verifyCode')}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="newVerifyCode" required>
                        <button data-type="sms" data-use-type="3" data-template-id="4" data-action="/api/engine/send-verify-code" onclick="sendVerifyCode(this)"  class="btn btn-outline-secondary send-verify-code" type="button">
                            ${fs_lang('sendVerifyCode')}
                        </button>
                    </div>`;
                } else if (name === 'editEmail' && !value) {
                    html =
                        `
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text border-end-rounded-0">` +
                        lable +
                        `</span>
                        <input type="text" class="form-control border-end-rounded-0" name="` +
                        name +
                        `" value="" required>
                        <input type="hidden" name="codeType" value="email">
                    </div>
                    <div class="input-group has-validation">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('verifyCode')}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="newVerifyCode">
                        <button data-type="email" data-use-type="3" data-template-id="4" data-action="/api/engine/send-verify-code" onclick="sendVerifyCode(this)" class="btn btn-outline-secondary send-verify-code" type="button">
                            ${fs_lang('sendVerifyCode')}
                        </button>
                    </div>`;
                } else if (name === 'editPhone' && value) {
                    let smsCodes = button.data('sms-codes'),
                        defaultSmsCode = button.data('default-sms-code');
                    html =
                        `
                    <div class="form-text mb-3 text-center">` +
                        desc +
                        `</div>
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text border-end-rounded-0">` +
                        lable +
                        `</span>
                        <input class="form-control border-end-rounded-0" type="text" placeholder="` +
                        value +
                        `" value="` +
                        value +
                        `" disabled>
                        <button data-type="sms" data-use-type="4" data-template-id="4" data-action="/api/engine/send-verify-code" onclick="sendVerifyCode(this)"  class="btn btn-outline-secondary send-verify-code" type="button">
                            ${fs_lang('sendVerifyCode')}
                        </button>
                    </div>
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('verifyCode')}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="verifyCode">
                        <button class="btn btn-outline-secondary" data-code-type="sms" data-action="/api/engine/account/verify-identity" type="button" onclick="accountVerification(this)">
                            ${fs_lang('check')}
                        </button>
                    </div>
                    <div class="input-group has-validation mb-3 d-none">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('newPhone')}</span>
                        <select class="form-select" name="editCountryCode">
                            <option disabled>Country Calling Codes</option>`;
                    $(smsCodes).each(function (k, v) {
                        let selected = v == defaultSmsCode ? 'selected' : '';
                        html += `<option ` + selected + ` value="` + v + `">` + v + `</option>`;
                    });
                    html +=
                        `
                        </select>
                        <input type="text" class="form-control w-50" required name="` +
                        name +
                        `" value="">
                    </div>
                    <div class="input-group has-validation d-none">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('newVerifyCode')}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="newVerifyCode">
                        <input type="hidden" name="codeType" value="sms">
                        <button data-type="sms" data-use-type="1" data-template-id="3" data-action="/api/engine/send-verify-code" onclick="sendVerifyCode(this)"  class="btn btn-outline-secondary send-verify-code" type="button">${fs_lang(
                            'sendVerifyCode'
                        )}</button>
                    </div>`;
                } else if (name === 'editEmail') {
                    html =
                        `
                    <div class="form-text has-validation mb-3 text-center">` +
                        desc +
                        `</div>
                    <div class="input-group mb-3">
                        <span class="input-group-text border-end-rounded-0">` +
                        lable +
                        `</span>
                        <input class="form-control border-end-rounded-0" type="text" placeholder="` +
                        value +
                        `" value="` +
                        value +
                        `" disabled>
                        <button data-type="email" data-use-type="4" data-template-id="4" data-action="/api/engine/send-verify-code" onclick="sendVerifyCode(this)"  class="btn btn-outline-secondary send-verify-code" type="button">
                            ${fs_lang('sendVerifyCode')}
                        </button>
                    </div>
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('verifyCode')}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="verifyCode">
                        <button class="btn btn-outline-secondary" required data-code-type="email" data-action="/api/engine/account/verify-identity" type="button" onclick="accountVerification(this)">
                            ${fs_lang('check')}
                        </button>
                    </div>
                    <div class="input-group has-validation mb-3 d-none">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('newEmail')}</span>
                        <input type="text" class="form-control" required name="` +
                        name +
                        `" value="">
                    </div>
                    <div class="input-group d-none">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('newVerifyCode')}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="newVerifyCode">
                        <input type="hidden" name="codeType" value="email">
                        <button data-type="email" data-use-type="1" data-template-id="3" data-action="/api/engine/send-verify-code" onclick="sendVerifyCode(this)"  class="btn btn-outline-secondary send-verify-code" type="button">
                            ${fs_lang('sendVerifyCode')}
                        </button>
                    </div>`;
                } else if (name === 'editPassword' || name === 'editWalletPassword') {
                    html = `
                    <div class="input-group mb-3 mt-2">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('settingType')}</span>
                        <div class="form-control">`;
                    if (value) {
                        html +=
                            `
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="` +
                            name +
                            `_mode" id="password_to_edit" value="password_to_` +
                            name +
                            `" data-bs-toggle="collapse" data-bs-target="#password_to_edit:not(.show)" aria-expanded="true" checked>
                                <label class="form-check-label" for="password_to_edit">${fs_lang('password')}</label>
                            </div>`;
                    }
                    html +=
                        `
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="` +
                        name +
                        `_mode" id="email_to_edit" value="email_to_` +
                        name +
                        `" data-bs-toggle="collapse" data-bs-target="#email_to_edit:not(.show)" aria-expanded="${
                            value ? 'false' : 'true'
                        }" ${value ? '' : 'checked'}>
                                <label class="form-check-label" for="email_to_edit">${fs_lang(
                                    'emailVerifyCode'
                                )}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="` +
                        name +
                        `_mode" id="phone_to_edit" value="phone_to_` +
                        name +
                        `" data-bs-toggle="collapse" data-bs-target="#phone_to_edit:not(.show)" aria-expanded="false">
                                <label class="form-check-label" for="phone_to_edit">${fs_lang('smsVerifyCode')}</label>
                            </div>
                        </div>
                    </div>
                    <div id="edit_password_mode">
                        <div class="collapse ${
                            value ? 'show' : ''
                        }" id="password_to_edit" aria-labelledby="password_to_edit" data-bs-parent="#edit_password_mode">
                            <div class="input-group mb-3">
                                <span class="input-group-text border-end-rounded-0">${fs_lang('passwordCurrent')}</span>
                                <input type="hidden" class="form-control" name="edit_type" value="` +
                        name +
                        `">
                                <input type="password" class="form-control" name="now_` +
                        name +
                        `">
                            </div>
                        </div>
                        <div class="collapse ${
                            !value ? 'show' : ''
                        }" id="email_to_edit" aria-labelledby="email_to_edit" data-bs-parent="#edit_password_mode">
                            <div class="input-group mb-3">
                                <span class="input-group-text border-end-rounded-0">${fs_lang('email')}</span>
                                <input class="form-control" type="text" placeholder="` +
                        email +
                        `" value="` +
                        email +
                        `" disabled>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text border-end-rounded-0">${fs_lang('verifyCode')}</span>
                                <input type="text" class="form-control" name="email_verifyCode">
                                <button data-type="email" data-use-type="4" data-template-id="5" data-action="/api/engine/send-verify-code" onclick="sendVerifyCode(this)"  class="btn btn-outline-secondary send-verify-code" type="button">
                                    ${fs_lang('sendVerifyCode')}
                                </button>
                            </div>
                        </div>
                        <div class="collapse" id="phone_to_edit" aria-labelledby="phone_to_edit" data-bs-parent="#edit_password_mode">
                            <div class="input-group mb-3">
                                <span class="input-group-text border-end-rounded-0">${fs_lang('phone')}</span>
                                <input class="form-control" type="text" placeholder="` +
                        phone +
                        `" value="` +
                        phone +
                        `" disabled>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text border-end-rounded-0">${fs_lang('verifyCode')}</span>
                                <input type="text" class="form-control" name="phone_verifyCode">
                                <button data-type="sms" data-use-type="4" data-template-id="5" data-action="/api/engine/send-verify-code" onclick="sendVerifyCode(this)"  class="btn btn-outline-secondary send-verify-code" type="button">
                                    ${fs_lang('sendVerifyCode')}
                                </button>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text border-end-rounded-0">${fs_lang('passwordNew')}</span>
                            <input type="password" class="form-control" name="new_` +
                        name +
                        `">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text border-end-rounded-0">${fs_lang('passwordAgain')}</span>
                            <input type="password" class="form-control" name="new_` +
                        name +
                        `_confirmation">
                        </div>
                    </div>`;
                } else {
                    html =
                        `
                    <div class="input-group has-validation">
                        <span class="input-group-text border-end-rounded-0">` +
                        lable +
                        `</span>
                        <input type="text" class="form-control" name="` +
                        name +
                        `" value="` +
                        value +
                        `" required>
                    </div>
                    <div class="form-text">` +
                        desc +
                        `</div>`;
                }
                break;
        }
        $(this).find('.modal-body').empty().html(html);

        // at and hashtag
        atwho();
    });

    $("#accordionCodeAccount button[type='submit']").on('click', function (e) {
        e.preventDefault();
        let obj = $(this),
            form = $('#accordionCodeAccount');

        let url = form.attr('action'),
            body = form.serializeArray();

        let result = [];
        jQuery.each(body, function (i, field) {
            result[field.name] = field.value;
        });

        if (result['password'] !== undefined) {
            result[`password`] = window.btoa(result[`password`]);
        }

        if (result['password_confirmation'] !== undefined) {
            result[`password_confirmation`] = window.btoa(result[`password_confirmation`]);
        }

        let bodyArr = [];
        let formData = new FormData();

        for (i in result) {
            if (i == 'verifyCode' && result[i] == '') {
                window.tips(fs_lang('verifyCode') + ': ' + fs_lang('errorEmpty'));
                return;
            }

            let item = `${i}=${result[i]}`;

            bodyArr.push(item);
        }

        body = bodyArr.join('&');

        obj.prop('disabled', true);
        obj.prepend('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> ');

        window.buildAjaxAndSubmit(
            url,
            body,
            function (res) {
                window.tips(res.message || fs_lang('accountLogin') + ': ' + fs_lang('errorUnknown'));

                if (res.code == 0) {
                    setTimeout(function () {
                        window.location.href = res.data.prev_url || '/account/login';
                    }, 1000);
                }
            },
            function (e) {
                console.error(e);
            },
            function (e) {
                obj.prop('disabled', false);
                obj.children('.spinner-border').remove();
            }
        );
    });

    // Edit Password
    $("#editModal.user-edit form button[type='submit']").on('click', function (e) {
        e.preventDefault();
        let obj = $(this),
            targeType = obj.data('targe-type'),
            targeName = obj.data('targe-name'),
            form = obj.parent().parent('form'),
            exit = false;

        targeType = targeType === 'date' ? 'input' : targeType;
        let targeObj = form.find(targeType + '[name=' + targeName + ']');

        obj.parent()
            .prev()
            .find('input, textarea, select')
            .each(function (k, v) {
                if (
                    !$(v).val() &&
                    !$(v).is(':disabled') &&
                    (!$(v).parent().parent().hasClass('collapse') || $(v).parent().parent().hasClass('show'))
                ) {
                    let text = $(v).prev().text(),
                        message = fs_lang('pleaseEnter') + text + '!';

                    if (!$(v).hasClass('is-invalid')) {
                        $(v).addClass('is-invalid');

                        if (
                            $(v).parent().hasClass('d-none') &&
                            $(v).parent().parent().find('input[name="verifyCode"]').length
                        ) {
                            form.find('.modal-body .invalid-feedback').length
                                ? form.find('.modal-body .invalid-feedback').text(fs_lang('settingCheckError'))
                                : form
                                      .find('.modal-body')
                                      .append(
                                          `<div class="invalid-feedback d-block">${fs_lang(
                                              'Please verify first'
                                          )}</div>`
                                      );
                        } else if ($(v).next().length) {
                            $(v)
                                .parent()
                                .append(`<div class="invalid-feedback d-block">` + message + `</div>`);
                        } else {
                            $(v).after(`<div class="invalid-feedback d-block">` + message + `</div>`);
                        }
                    } else {
                        $(v).parent().find('.invalid-feedback').text(message);
                    }
                    exit = true;
                    return;
                } else {
                    $(v).removeClass('is-invalid');
                    $(v).parent().find('.invalid-feedback').remove();
                }
            });

        if (exit) {
            return;
        }

        obj.prop('disabled', true);
        obj.prepend('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> ');

        let url = form.attr('action'),
            body = form.serializeArray();

        let result = [];
        jQuery.each(body, function (i, field) {
            result[field.name] = field.value;
        });

        if (result['edit_type'] !== undefined) {
            if (result[`now_${result['edit_type']}`] !== undefined) {
                result[`now_${result['edit_type']}`] = window.btoa(result[`now_${result['edit_type']}`]);
            }

            if (result[`new_${result['edit_type']}`] !== undefined) {
                result[`new_${result['edit_type']}`] = window.btoa(result[`new_${result['edit_type']}`]);
            }

            if (result[`new_${result['edit_type']}_confirmation`] !== undefined) {
                result[`new_${result['edit_type']}_confirmation`] = window.btoa(
                    result[`new_${result['edit_type']}_confirmation`]
                );
            }
        }

        let bodyArr = [];
        let formData = new FormData();

        for (i in result) {
            let item = `${i}=${result[i]}`;

            bodyArr.push(item);
        }

        body = bodyArr.join('&');

        window.buildAjaxAndSubmit(
            url,
            body,
            function (res) {
                window.tips(res.message);
                if (res.code != 0) {
                    return;
                }

                obj.prev().trigger('click');
                let editedVal = targeObj.val(),
                    editedText = editedVal,
                    showSiteObj = $('#' + targeType + '-' + targeName);

                // if targe button type select
                if (targeType === 'select') {
                    $(showSiteObj.next().data('option')).each(function (k, v) {
                        if (v.id == editedVal) {
                            editedText = v.text;
                        }
                    });
                }
                if (targeName === 'editWalletPassword' || targeName === 'editPassword') {
                    editedText = fs_lang('settingAlready');
                    editedVal = true;
                }

                showSiteObj.text(editedText);
                showSiteObj.next().data('value', editedVal);
            },
            function (e) {
                if (!targeObj.length) {
                    form.find('.modal-body').append(
                        `<div class="invalid-feedback d-block">` + e.responseJSON.message + `</div>`
                    );
                } else {
                    if (!targeObj.hasClass('is-invalid')) {
                        targeObj.addClass('is-invalid');
                        targeObj.parent().append(`<div class="invalid-feedback">` + e.responseJSON.message + `</div>`);
                    } else {
                        targeObj.parent().find('.invalid-feedback').text(e.responseJSON.message);
                    }
                }
            },
            function (e) {
                obj.prop('disabled', false);
                obj.children('.spinner-border').remove();
            }
        );
    });

    // Upload Avatar
    $('#uploadAvatar').on('change', function (e) {
        let formData = new FormData(),
            uploadAction = $(this).data('upload-action'),
            editAction = $(this).data('edit-action'),
            token = $('meta[name="csrf-token"]').attr('content'),
            obj = $(this),
            type = obj.data('type'),
            usageType = obj.data('usagetype'),
            tableName = obj.data('tablename'),
            tableColumn = obj.data('tablecolumn'),
            tableKey = obj.data('tablekey'),
            uploadMode = obj.data('uploadmode');

        obj.prop('disabled', true);
        obj.prev().prepend(
            '<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> '
        );

        formData.append('file', obj[0].files[0]);
        formData.append('_token', token);
        formData.append('type', type);
        formData.append('usageType', usageType);
        formData.append('tableName', tableName);
        formData.append('tableColumn', tableColumn);
        formData.append('tableKey', tableKey);
        formData.append('uploadMode', uploadMode);

        $.ajax({
            url: uploadAction,
            type: 'POST',
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.code !== 0) {
                    window.tips(res.message);
                    return;
                }

                if (res.data.imageAvatarUrl && res.data.fid) {
                    let data = { avatarFid: res.data.fid, avatarUrl: null };
                    window.buildAjaxAndSubmit(
                        editAction,
                        data,
                        function (res) {
                            window.tips(res.message);
                            window.location.reload();
                        },
                        function (e) {
                            window.tips(e.responseJSON.message);
                        }
                    );
                }
            },
            error: function (e) {
                window.tips(e.responseJSON.message, e.status);
            },
        });
    });

    // Send File Message
    $('.sendFile').on('change', function (e) {
        let formData = new FormData(),
            uploadAction = $(this).data('upload-action'),
            token = $('meta[name="csrf-token"]').attr('content'),
            obj = $(this),
            type = obj.data('type'),
            usageType = obj.data('usagetype'),
            tableName = obj.data('tablename'),
            tableColumn = obj.data('tablecolumn'),
            tableKey = obj.data('tablekey'),
            uploadMode = obj.data('uploadmode'),
            sendAction = $(this).data('send-action'),
            sendUidOrUsername = $(this).data('send-uidorusername');

        $('.send-file-btn').prop('disabled', true);
        $('.send-file-btn').prepend(
            '<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> '
        );

        formData.append('file', obj[0].files[0]);
        formData.append('_token', token);
        formData.append('type', type);
        formData.append('usageType', usageType);
        formData.append('tableName', tableName);
        formData.append('tableColumn', tableColumn);
        formData.append('tableKey', tableKey);
        formData.append('uploadMode', uploadMode);

        $.ajax({
            url: uploadAction,
            type: 'POST',
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.code !== 0) {
                    window.tips(res.message);
                    return;
                }

                if (res.data.fid) {
                    let data = { uidOrUsername: sendUidOrUsername, fid: res.data.fid };
                    window.buildAjaxAndSubmit(
                        sendAction,
                        data,
                        function (res) {
                            window.tips(res.message);
                            window.location.reload();
                        },
                        function (e) {
                            window.tips(e.responseJSON.message);
                        }
                    );
                }
            },
            error: function (e) {
                window.tips(e.responseJSON.message, e.status);
            },
        });
    });
})(jQuery);

// Markdown a tag
$(document).ready(function () {
    var parse_url = /^(?:([A-Za-z]+):)?(\/{0,3})([0-9.\-A-Za-z]+)(?::(\d+))?(?:\/([^?#]*))?(?:\?([^#]*))?(?:#(.*))?$/;
    var location_href = window.location.href.replace(parse_url, '$3');
    $('.content-article a:not(:has(img)),.content-article a').hover(function () {
        var this_href = $(this).attr('href');
        var replace_href = this_href.replace(parse_url, '$3');
        if (this_href != replace_href && location_href != replace_href) $(this).attr('target', '_blank');
    });

    window.locale = $('html').attr('lang');
    if (window.locale) {
        $.ajax({
            url: '/api/engine/js/' + window.locale + '/translations',
            method: 'get',
            success(response) {
                if (response.data) {
                    window.translations = response.data;
                } else {
                    console.error('Failed to get translation');
                }
            },
        });
    }
});
