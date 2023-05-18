/*!
 * Fresns (https://fresns.org)
 * Copyright 2021-Present Jevan Tang
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
            let errorCode = $(v).data('errorCode');

            if (errorCode == 36104 || errorCode == 38200) {
                return;
            }

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
    if (window.langTag) {
        langTag = '/' + window.langTag;
    } else {
        langTag = '';
    }

    siteName = window.siteName ?? 'Tip';
    siteIcon = window.siteIcon ?? '/static/images/icon.png';

    if (code == 0 || code == 200) {
        apiCode = '';
    } else {
        apiCode = code;
    }

    if (code == 36104) {
        apiMessage = `${message}
            <div class="mt-2 pt-2 border-top">
                <a class="btn btn-primary btn-sm" href="${langTag}/account/settings#account-tab" role="button">
                    ${fs_lang('settingAccount')}
                </a>
            </div>`;
    } else if (code == 38200) {
        apiMessage = `${message}
            <div class="mt-2 pt-2 border-top">
                <a class="btn btn-primary btn-sm" href="${langTag}/editor/drafts/posts" role="button">
                    ${fs_lang('view')}
                </a>
            </div>`;
    } else {
        apiMessage = message;
    }

    let html = `<div aria-live="polite" aria-atomic="true" class="position-fixed top-50 start-50 translate-middle" style="z-index:2048">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="${siteIcon}" width="20px" height="20px" class="me-2">
                <strong class="me-auto">${siteName}</strong>
                <small>${apiCode}</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">${apiMessage}</div>
        </div>
    </div>`;

    $('div.fresns-tips').prepend(html);

    // tip toast time
    if (code == 36104 || code == 38200) {
        return;
    }

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
        countryCodeSelectId = $(obj).data('country-code-select-id'),
        accountInputId = $(obj).data('account-input-id');

    let countryCode = '',
        account = '';

    if (countryCodeSelectId) {
        countryCode = $('#' + countryCodeSelectId).val();
    }

    if (accountInputId) {
        account = $('#' + accountInputId).val();
    }

    fetchSendVerifyCode(type, useType, templateId, account, obj, countryCode);
}

// send Timer
var countdown = 60;
function setSendCodeTime(obj, stop) {
    if (stop) {
        obj.attr('disabled', false);
        obj.text(fs_lang('sendVerifyCode'));
        countdown = 60;
        return;
    }

    if (countdown == 0) {
        obj.attr('disabled', false);
        obj.text(fs_lang('sendVerifyCode'));
        countdown = 60;
        return;
    } else {
        obj.attr('disabled', true);
        obj.text(fs_lang('resendVerifyCode') + '(' + countdown + ')');
        countdown--;
    }
    setTimeout(function () {
        setSendCodeTime(obj);
    }, 1000);
}

// send request
function fetchSendVerifyCode(type, useType, templateId, account, obj, countryCode) {
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

    setSendCodeTime($(obj));

    $.ajax({
        url: '/api/engine/send-verify-code',
        type: 'post',
        data: data,
        error: function (error) {
            setSendCodeTime(obj, true);
            alert(error.responseJSON.message, error.status);
        },
        success: function (res) {
            if (res.code != 0) {
                return window.tips(res.message, res.code);
            }

            window.tips(fs_lang('send') + ': ' + fs_lang('success'));
        },
    });
}

// download file
function downloadFile(url, fileName, mimeType) {
    $('#loading').hide();

    const xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.responseType = 'blob';
    xhr.onload = function () {
        if (xhr.status === 200) {
            const blob = xhr.response;
            const a = document.createElement('a');
            a.style.display = 'none';
            document.body.appendChild(a);
            const url = window.URL.createObjectURL(blob);
            a.href = url;
            a.download = fileName;
            a.type = mimeType;

            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            $('#loading').hide();
        }
    };
    xhr.send();
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
    if (window.mentionStatus) {
        $('.fresns-content').atwho({
            at: '@',
            displayTpl:
                '<li><img src="${image}" height="20" width="20"/> ${name} <small class="text-muted">@${fsid}</small></li>',
            insertTpl: '${atwho-at}${fsid}',
            searchKey: 'searchQuery',
            callbacks: {
                remoteFilter: function (query, callback) {
                    if (query) {
                        $.get(
                            '/api/engine/input-tips',
                            { type: 'user', key: query },
                            function (data) {
                                data.map((item) => (item.searchQuery = item.name + item.fsid));
                                callback(data);
                            },
                            'json'
                        );
                    }
                },
            },
        });
    }

    if (window.hashtagStatus) {
        $('.fresns-content').atwho({
            at: '#',
            displayTpl: '<li> ${name} </li>',
            insertTpl: window.hashtagFormat == 1 ? '${atwho-at}${name}' : '${atwho-at}${name}${atwho-at}',
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
        verifyCode = $(obj).prev().val();
    $(obj).prop('disabled', true);
    $(obj).prepend('<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> ');

    $.ajax({
        url: '/api/engine/account/verify-identity',
        type: 'post',
        data: { type: codeType, verifyCode },
        error: function (error) {
            $(obj).prev().addClass('is-invalid');
            $(obj).after(`<div class="invalid-feedback">` + error.responseJSON.message + `</div>`);
        },
        success: function (res) {
            if (res.code !== 0) {
                window.tips(res.message, res.code);
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

    // loading
    $(document).on('click', 'a', function (e) {
        var href = $(this).attr('href');
        var loading = $(this).data('loading');

        if (href && !href.startsWith('javascript:') && href !== '#' && loading !== 'false') {
            if ((href.indexOf(location.hostname) !== -1 || href[0] === '/') && $(this).attr('target') !== '_blank') {
                $('#loading').show();
            }
        }
    });
    $(window).on('load', function () {
        $('#loading').hide();
    });
    window.addEventListener('pageshow', function () {
        $('#loading').hide();
    });
    window.addEventListener('visibilitychange', function () {
        // android compatible
        $('#loading').hide();
    });

    // image zoom
    $('.zoom-image').on('click', function () {
        $('#imageZoom img').attr('src', $(this).data('zoom-src'));
        $('#imageZoom').modal('show');
    });

    // video play
    var videos = document.getElementsByTagName('video');
    for (var i = videos.length - 1; i >= 0; i--) {
        (function () {
            var p = i;
            videos[p].addEventListener('play', function () {
                pauseAll(p);
            });
        })();
    }
    function pauseAll(index) {
        for (var j = videos.length - 1; j >= 0; j--) {
            if (j != index) videos[j].pause();
        }
    }

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
                    return window.tips(res.message, res.code);
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

                    html += `<img src="${item.user.avatar}" alt="${item.user.username}" class="rounded-circle">`;
                }

                $(modal).find('.file-download-user .file-user-list').html(html);
                $(modal).find('.file-download-user').parent().css('display', 'block');
            },
        });
    });

    $('.fresns-file-download').on('click', function (e) {
        e.stopPropagation();
        let button = $(this),
            url = button.data('url'),
            name = button.data('name'),
            mime = button.data('mime');

        button.prop('disabled', true);
        button.prepend(
            '<span class="spinner-border spinner-border-sm mg-r-5" role="status" aria-hidden="true"></span> '
        );

        $.ajax({
            method: 'get',
            url: url,
            success: function (res) {
                if (res.code != 0) {
                    return window.tips(res.message, res.code);
                }

                downloadFile(res.data.originalUrl, name, mime);
            },
            complete: function (e) {
                button.prop('disabled', false);
                button.find('.spinner-border').remove();
                $('#loading').hide();
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
                if (res.code != 0) {
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

        let form = obj.closest('form');

        const url = form.attr('action'),
            body = form.serialize(),
            interactionType = form.find('input[name="interactionType"]').val(),
            count = obj.find('.show-count').text(),
            text = obj.find('.show-text'),
            id = obj.data('id'),
            collapseId = obj.data('collapse-id'),
            bi = obj.data('bi'),
            icon = obj.data('icon'),
            iconActive = obj.data('icon-active'),
            interactionActive = obj.data('interaction-active') || 0;

        let markBtn = obj;
        if (id) {
            markBtn = $('#' + id);
        }

        window.buildAjaxAndSubmit(
            url,
            body,
            function (e) {
                if (e.code != 0) {
                    window.tips(e.message, e.code);
                    return;
                }

                if (interactionActive) {
                    obj.data('interaction-active', 0);
                } else {
                    obj.data('interaction-active', 1);
                }

                if (iconActive) {
                    markBtn.find('img').attr('src', interactionActive == 0 ? iconActive : icon);
                    if (interactionActive) {
                        markBtn.removeClass('btn-active');
                    } else {
                        markBtn.addClass('btn-active');
                    }
                }

                if (count) {
                    if (interactionActive) {
                        markBtn.find('.show-count').text(parseInt(count) - 1);
                    } else {
                        markBtn.find('.show-count').text(parseInt(count) + 1);
                    }
                }

                if (text) {
                    const isFollowOrBlock = interactionType === 'follow' || interactionType === 'block';

                    if (isFollowOrBlock && interactionActive) {
                        markBtn.find('.show-text').text(markBtn.data('name'));
                    } else {
                        markBtn.find('.show-text').text('√ ' + markBtn.data('name'));
                    }
                }

                if (bi) {
                    markBtn.find('i').removeClass();
                    if (interactionActive) {
                        if (bi.indexOf('-fill') > 0) {
                            markBtn.find('i').addClass('bi ' + bi.slice(0, -5));
                        } else {
                            markBtn.find('i').addClass('bi ' + bi);
                        }
                        markBtn.hasClass('btn')
                            ? markBtn.removeClass('btn-success').addClass('btn-outline-success')
                            : markBtn.removeClass('text-success');
                    } else {
                        markBtn.find('i').addClass('bi ' + bi);
                        markBtn.hasClass('btn')
                            ? markBtn.addClass('btn-success').removeClass('btn-outline-success')
                            : markBtn.addClass('text-success');
                    }
                }

                interactionType === 'like' ? markBtn.addClass('btn-pre') : markBtn.removeClass('btn-pre');

                if (collapseId) {
                    $('#' + collapseId).collapse('hide');
                }

                if (interactionType == 'like') {
                    let formObj = form.parent().find('form')[1];
                    let likeOrDislikeObj;
                    if (formObj && formObj !== form[0]) {
                        likeOrDislikeObj = $(formObj).find('.fs-mark');
                    } else {
                        likeOrDislikeObj = $(form.parent().parent().find('form')[1]).find('.fs-mark');
                    }
                    const likeOrDislikeObjInteractionActivate = likeOrDislikeObj.data('interaction-active') || 0;
                    const likeOrDislikeObjCount = likeOrDislikeObj.find('.show-count').text();

                    if (likeOrDislikeObjCount) {
                        if (likeOrDislikeObjInteractionActivate) {
                            likeOrDislikeObj.find('.show-count').text(parseInt(likeOrDislikeObjCount) - 1);
                            likeOrDislikeObj.data('interaction-active', 0);
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

                        if (likeOrDislikeObjIconActive && likeOrDislikeObjInteractionActivate) {
                            likeOrDislikeObj
                                .find('img')
                                .attr(
                                    'src',
                                    likeOrDislikeObjInteractionActivate == 0
                                        ? likeOrDislikeObjIconActive
                                        : likeOrDislikeObjIcon
                                );
                            likeOrDislikeObj.hasClass('btn')
                                ? likeOrDislikeObj.removeClass('btn-active').addClass('btn-outline-success')
                                : likeOrDislikeObj.removeClass('text-success');
                        }
                    }
                } else if (interactionType == 'dislike') {
                    let formObj = form.parent().find('form')[0];
                    let likeOrDislikeObj;
                    if (formObj && formObj !== form[0]) {
                        likeOrDislikeObj = $(formObj).find('.fs-mark');
                    } else {
                        likeOrDislikeObj = $(form.parent().parent().find('form')[0]).find('.fs-mark');
                    }
                    const likeOrDislikeObjInteractionActivate = likeOrDislikeObj.data('interaction-active') || 0;
                    const likeOrDislikeObjCount = likeOrDislikeObj.find('.show-count').text();

                    if (likeOrDislikeObjCount) {
                        if (likeOrDislikeObjInteractionActivate) {
                            likeOrDislikeObj.find('.show-count').text(parseInt(likeOrDislikeObjCount) - 1);
                            likeOrDislikeObj.data('interaction-active', 0);
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

                        if (likeOrDislikeObjIconActive && likeOrDislikeObjInteractionActivate) {
                            likeOrDislikeObj
                                .find('img')
                                .attr(
                                    'src',
                                    likeOrDislikeObjInteractionActivate == 0
                                        ? likeOrDislikeObjIconActive
                                        : likeOrDislikeObjIcon
                                );
                            likeOrDislikeObj.hasClass('btn')
                                ? likeOrDislikeObj.removeClass('btn-active').addClass('btn-outline-success')
                                : likeOrDislikeObj.removeClass('text-success');
                        }
                    }
                }

                window.tips(e.message, e.code);
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
                    window.tips(res.message, res.code);
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
            label = button.data('label'),
            name = button.data('name'),
            desc = button.data('desc') ?? '',
            type = button.data('type'),
            inputTips = button.data('input-tips'),
            option = button.data('option'),
            action = button.data('action'),
            email = button.data('email') ?? '',
            phone = button.data('phone') ?? '',
            value = button.data('value') ?? '';

        $(this).find('.modal-title').empty().html(label);
        $(this).find('form').attr('action', action);
        $(this)
            .find('.modal-footer button[type="submit"]')
            .data('targe-type', type ?? 'input')
            .data('targe-name', name);

        let html = '';
        switch (type) {
            case 'select':
                html = `
                <div class="input-group has-validation">
                    <label class="input-group-text border-end-rounded-0">${label}</label>
                    <select class="form-select" name="${name}">`;
                $(option).each(function (k, v) {
                    let selected = value == v.id ? 'selected' : '';
                    html += `<option ` + selected + ` value="` + v.id + `">` + v.text + `</option>`;
                });
                html += `
                    </select>
                </div>`;
                break;
            case 'textarea':
                html = `
                <div class="input-group has-validation">
                    <span class="input-group-text border-end-rounded-0">${label}</span>
                    <textarea class="form-control ${inputTips}" name="${name}" rows="5">${value}</textarea>
                </div>`;
                break;
            case 'date':
                html = `
                <div class="input-group has-validation">
                    <span class="input-group-text border-end-rounded-0">${label}</span>
                    <input type="date" class="form-control" name="${name}" value="${value}" required>
                </div>`;
                break;
            case 'editPhone':
                let smsCodes = button.data('sms-codes');
                let defaultSmsCode = button.data('default-sms-code');

                if (value) {
                    html = `
                    <div class="form-text mb-3 text-center">${desc}</div>
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text border-end-rounded-0">${label}</span>
                        <input class="form-control border-end-rounded-0" type="text" placeholder="${value}" value="${value}" id="oldPhone" disabled>
                        <button data-type="sms" data-use-type="4" data-template-id="4" data-country-code-select-id="editCountryCode" data-account-input-id="oldPhone" onclick="sendVerifyCode(this)" class="btn btn-outline-secondary" type="button">
                            ${fs_lang('sendVerifyCode')}
                        </button>
                    </div>
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('verifyCode')}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="verifyCode">
                        <button class="btn btn-outline-secondary" data-code-type="sms" type="button" onclick="accountVerification(this)">
                            ${fs_lang('check')}
                        </button>
                    </div>
                    <div class="input-group has-validation mb-3 d-none">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('newPhone')}</span>`;

                    if (smsCodes.length > 1) {
                        html += `<select class="form-select border-end-rounded-0" name="editCountryCode" id="editCountryCode">
                                    <option disabled>Country Calling Codes</option>`;
                        $(smsCodes).each(function (k, v) {
                            let selected = v == defaultSmsCode ? 'selected' : '';
                            html += `<option ` + selected + ` value="` + v + `">` + v + `</option>`;
                        });
                        html += `</select>`;
                    } else {
                        html += `<select class="d-none" name="editCountryCode" id="editCountryCode">
                                <option value="${defaultSmsCode}" selected>+${defaultSmsCode}</option>
                            </select>
                            <span class="input-group-text border-end-rounded-0">+${defaultSmsCode}</span>`;
                    }

                    html += `<input type="text" class="form-control w-50" required name="${name}" id="editPhone" value="">
                    </div>
                    <div class="input-group has-validation d-none">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('newVerifyCode')}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="newVerifyCode">
                        <input type="hidden" name="codeType" value="sms">
                        <button data-type="sms" data-use-type="1" data-template-id="3" data-country-code-select-id="editCountryCode" data-account-input-id="editPhone" onclick="sendVerifyCode(this)" class="btn btn-outline-secondary" type="button">
                            ${fs_lang('sendVerifyCode')}
                        </button>
                    </div>`;
                } else {
                    html = `
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text border-end-rounded-0">${label}</span>`;

                    if (smsCodes.length > 1) {
                        html += `<select class="form-select border-end-rounded-0" name="editCountryCode" id="editCountryCode">
                                    <option disabled>Country Calling Codes</option>`;
                        $(smsCodes).each(function (k, v) {
                            let selected = v == defaultSmsCode ? 'selected' : '';
                            html += `<option ` + selected + ` value="` + v + `">` + v + `</option>`;
                        });
                        html += `</select>`;
                    } else {
                        html += `<select class="d-none" name="editCountryCode" id="editCountryCode">
                                <option value="${defaultSmsCode}" selected>+${defaultSmsCode}</option>
                            </select>
                            <span class="input-group-text border-end-rounded-0">+${defaultSmsCode}</span>`;
                    }

                    html += `<input type="text" class="form-control w-50" name="${name}" value="" id="editPhone" required>
                    </div>
                    <input type="hidden" name="codeType" value="sms">
                    <div class="input-group has-validation">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('verifyCode')}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="newVerifyCode" required>
                        <button data-type="sms" data-use-type="3" data-template-id="4" data-country-code-select-id="editCountryCode" data-account-input-id="editPhone" onclick="sendVerifyCode(this)" class="btn btn-outline-secondary" type="button">
                            ${fs_lang('sendVerifyCode')}
                        </button>
                    </div>`;
                }
                break;
            case 'editEmail':
                if (value) {
                    html = `
                    <div class="form-text has-validation mb-3 text-center">${desc}</div>
                    <div class="input-group mb-3">
                        <span class="input-group-text border-end-rounded-0">${label}</span>
                        <input class="form-control border-end-rounded-0" type="text" placeholder="${value}" value="${value}" id="oldEmail" disabled>
                        <button data-type="email" data-use-type="4" data-template-id="4" data-account-input-id="oldEmail" onclick="sendVerifyCode(this)" class="btn btn-outline-secondary" type="button">
                            ${fs_lang('sendVerifyCode')}
                        </button>
                    </div>
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('verifyCode')}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="verifyCode">
                        <button class="btn btn-outline-secondary" required data-code-type="email" type="button" onclick="accountVerification(this)">
                            ${fs_lang('check')}
                        </button>
                    </div>
                    <div class="input-group has-validation mb-3 d-none">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('newEmail')}</span>
                        <input type="text" class="form-control border-end-rounded-0" required name="${name}" id="editEmail" value="">
                        <button data-type="email" data-use-type="1" data-template-id="3" data-account-input-id="editEmail" onclick="sendVerifyCode(this)" class="btn btn-outline-secondary" type="button">
                            ${fs_lang('sendVerifyCode')}
                        </button>
                    </div>
                    <div class="input-group d-none">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('newVerifyCode')}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="newVerifyCode">
                        <input type="hidden" name="codeType" value="email">
                    </div>`;
                } else {
                    html = `
                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text border-end-rounded-0">${label}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="${name}" value="" id="editEmail" required>
                        <input type="hidden" name="codeType" value="email">
                    </div>
                    <div class="input-group has-validation">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('verifyCode')}</span>
                        <input type="text" class="form-control border-end-rounded-0" name="newVerifyCode">
                        <button data-type="email" data-use-type="3" data-template-id="4" data-account-input-id="editEmail" onclick="sendVerifyCode(this)" class="btn btn-outline-secondary" type="button">
                            ${fs_lang('sendVerifyCode')}
                        </button>
                    </div>`;
                }
                break;
            case 'editPassword':
                let templateId = 5;
                if (name === 'editWalletPassword') {
                    templateId = 6;
                }

                html = `
                <div class="input-group mb-3 mt-2">
                    <span class="input-group-text border-end-rounded-0">${fs_lang('settingType')}</span>
                    <div class="form-control">`;
                if (value) {
                    html += `
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="${name}_mode" id="password_to_edit" value="password_to_${name}" data-bs-toggle="collapse" data-bs-target=".password_to_edit:not(.show)" aria-controls="password_to_edit" aria-expanded="true" checked>
                            <label class="form-check-label" for="password_to_edit">${fs_lang('password')}</label>
                        </div>`;
                }
                html += `
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="${name}_mode" id="email_to_edit" value="email_to_${name}" data-bs-toggle="collapse" data-bs-target=".email_to_edit:not(.show)" aria-expanded="${
                    value ? 'false' : 'true'
                }" ${value ? '' : 'checked'}>
                            <label class="form-check-label" for="email_to_edit">${fs_lang('emailVerifyCode')}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="${name}_mode" id="phone_to_edit" value="phone_to_${name}" data-bs-toggle="collapse" data-bs-target=".phone_to_edit:not(.show)" aria-controls="phone_to_edit" aria-expanded="false">
                            <label class="form-check-label" for="phone_to_edit">${fs_lang('smsVerifyCode')}</label>
                        </div>
                    </div>
                </div>
                <div id="edit_password_mode">
                    <div class="collapse password_to_edit ${
                        value ? 'show' : ''
                    }" aria-labelledby="password_to_edit" data-bs-parent="#edit_password_mode">
                        <div class="input-group mb-3">
                            <span class="input-group-text border-end-rounded-0">${fs_lang('passwordCurrent')}</span>
                            <input type="hidden" class="form-control" name="edit_type" value="${name}">
                            <input type="password" class="form-control" name="now_${name}" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="collapse email_to_edit ${
                        !value ? 'show' : ''
                    }" aria-labelledby="email_to_edit" data-bs-parent="#edit_password_mode">
                        <div class="input-group mb-3">
                            <span class="input-group-text border-end-rounded-0">${fs_lang('email')}</span>
                            <input class="form-control" type="text" placeholder="${email}" value="${email}" id="emailEditPassword" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text border-end-rounded-0">${fs_lang('verifyCode')}</span>
                            <input type="text" class="form-control" name="email_verifyCode" autocomplete="off">
                            <button data-type="email" data-use-type="4" data-template-id="${templateId}" data-account-input-id="emailEditPassword" onclick="sendVerifyCode(this)" class="btn btn-outline-secondary" type="button">
                                ${fs_lang('sendVerifyCode')}
                            </button>
                        </div>
                    </div>
                    <div class="collapse phone_to_edit" aria-labelledby="phone_to_edit" data-bs-parent="#edit_password_mode">
                        <div class="input-group mb-3">
                            <span class="input-group-text border-end-rounded-0">${fs_lang('phone')}</span>
                            <input class="form-control" type="text" placeholder="${phone}" value="${phone}" id="phoneEditPassword" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text border-end-rounded-0">${fs_lang('verifyCode')}</span>
                            <input type="text" class="form-control" name="phone_verifyCode">
                            <button data-type="sms" data-use-type="4" data-template-id="${templateId}" data-account-input-id="phoneEditPassword" onclick="sendVerifyCode(this)" class="btn btn-outline-secondary" type="button">
                                ${fs_lang('sendVerifyCode')}
                            </button>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('passwordNew')}</span>
                        <input type="password" class="form-control" name="new_${name}" autocomplete="off">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text border-end-rounded-0">${fs_lang('passwordAgain')}</span>
                        <input type="password" class="form-control" name="new_${name}_confirmation" autocomplete="off">
                    </div>
                </div>`;
                break;
            default:
                html = `
                <div class="input-group has-validation">
                    <span class="input-group-text border-end-rounded-0">${label}</span>
                    <input type="text" class="form-control" name="${name}" value="${value}" required>
                </div>
                <div class="form-text">${desc}</div>`;
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
                        window.location.href = res.data.redirectURL || '/account/login';
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

    // Account Edit
    $("#editModal.user-edit form button[type='submit']").on('click', function (e) {
        e.preventDefault();
        let obj = $(this),
            targeType = obj.data('targe-type'),
            targeName = obj.data('targe-name'),
            form = obj.closest('form'),
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
                                : form.find('.modal-body').append(
                                      `<div class="invalid-feedback d-block">
                                            ${fs_lang('settingCheckError')}
                                        </div>`
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
                window.tips(res.message, res.code);
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
                        targeObj.parent().find('.invalid-feedback').text(e.responseJSON.message, e.status);
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
                    window.tips(res.message, res.code);
                    return;
                }

                window.location.reload();
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
                    window.tips(res.message, res.code);
                    return;
                }

                if (res.data.fid) {
                    let data = { uidOrUsername: sendUidOrUsername, fid: res.data.fid };
                    window.buildAjaxAndSubmit(
                        sendAction,
                        data,
                        function (res) {
                            window.tips(res.message, res.code);
                            window.location.reload();
                        },
                        function (e) {
                            window.tips(e.responseJSON.message, e.status);
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

// ajax get list
$(function () {
    var currentPage = 1;
    var lastPage = 1;
    var isLoading = false;

    // Loading data for the next page
    function loadNextPage() {
        // Show loading text
        $('#fresns-list-tip').hide();
        $('#fresns-list-loading').show();

        // Set status to loading
        isLoading = true;

        // Send an AJAX request to get the data of the next page
        $.ajax({
            url: window.location.href,
            type: 'get',
            data: {
                page: currentPage + 1,
            },
            dataType: 'json',
            success: function (response) {
                // Hide the loading text
                $('#fresns-list-loading').hide();
                $('#fresns-list-tip').show();

                // Insert the HTML of the next page into the list
                $('#fresns-list-container').append(response.html);

                // Update current page number and last page code
                currentPage = response.paginate.currentPage;
                lastPage = response.paginate.lastPage;

                // If it is the last page, the text of "no more" is displayed
                if (currentPage >= lastPage) {
                    $('#fresns-list-tip').hide();
                    $('#fresns-list-no-more').show();

                    console.log('ajax get list => no more');
                }

                // Set status to not loading
                isLoading = false;
            },
            error: function () {
                // Set status to not loading
                isLoading = false;

                console.log('ajax get list => error');
            },
        });
    }

    // Use IntersectionObserver to listen to whether the bottom is reached
    if ('IntersectionObserver' in window) {
        let options = {
            root: null,
            rootMargin: '0px',
            threshold: 1.0,
        };

        let observer = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (!window.ajaxGetList || $('#fresns-list-container').length == 0) {
                    $('#fresns-list-tip').hide();

                    console.log('ajax get list => end');
                    return;
                }

                if (entry.isIntersecting && currentPage <= lastPage && !isLoading) {
                    loadNextPage();
                }
            });
        }, options);

        var targetElement = document.querySelector('#fresns-list-tip');
        if (targetElement) {
            observer.observe(targetElement);
        }
    }

    // Click the button to load the next page of data
    $('#fresns-list-loading-btn').click(function () {
        if (currentPage <= lastPage && !isLoading) {
            loadNextPage();
        }
    });
});

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

// fresns extensions callback
window.onmessage = function (event) {
    let fresnsCallback;

    try {
        fresnsCallback = JSON.parse(event.data);
    } catch (error) {
        return;
    }

    console.log('fresnsCallback', fresnsCallback);

    if (!fresnsCallback) {
        return;
    }

    if (fresnsCallback.code != 0) {
        if (fresnsCallback.message) {
            window.tips(fresnsCallback.message, fresnsCallback.code);
        }
        return;
    }

    switch (fresnsCallback.action.postMessageKey) {
        case 'reload':
            window.location.reload();
            break;

        case 'fresnsConnect':
            if (fresnsCallback.action.reloadData) {
                window.location.href = `/${langTag}/account/settings#account-tab`;
            }
            break;

        case 'fresnsJoin':
            let params = new URLSearchParams(window.location.search.slice(1));

            $.ajax({
                url: '/api/engine/account/connect-login',
                type: 'post',
                dataType: 'json',
                data: {
                    apiData: fresnsCallback,
                    redirectURL: params.get('redirectURL'),
                },
                success: function (res) {
                    if (res.code !== 0) {
                        return window.tips(res.message, res.code);
                    }

                    if (res.data.redirectURL) {
                        window.location.href = res.data.redirectURL;
                        return;
                    }
                },
            });
            break;

        case 'fresnsEditorUpload':
            fresnsCallback.data.forEach((fileinfo) => {
                addEditorAttachment(fileinfo);
            });

            if (fresnsCallback.action.reloadData) {
                $('#fresnsModal').modal('hide');

                return;
            }
            break;
    }

    if (fresnsCallback.action.windowClose) {
        $('#fresnsModal').modal('hide');
    }

    if (fresnsCallback.action.redirectUrl) {
        window.location.href = fresnsCallback.action.redirectUrl;
    }

    console.log('fresnsCallback end');
};
