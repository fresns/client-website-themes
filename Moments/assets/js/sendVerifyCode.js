/*!
 * Fresns (https://fresns.org)
 * Copyright 2021-Present Jevan Tang
 * Licensed under the Apache-2.0 license
 */

var countdown = 60;

function settime(obj) {
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
        settime(obj);
    }, 1000);
}
$(function () {
    $('.send-verify-code').on('click', function () {
        var obj = $(this);
        var account, data;
        var form = obj.parent().parent();
        var type = form.find("input[name='type']:checked").val();
        // reset-password cannot find send code type
        if (!type) {
            form = form.parent();
            type = form.find("input[name='type']:checked").val();
        }
        // account login by code, cannot find send code type
        if (!type) {
            form = form.parent();
            type = form.find("input[name='type']:checked").val();
        }
        var countryCode = form.find("select[name='countryCode']").val();
        var useType = form.find("input[name='useType']").val();
        var templateId = form.find("input[name='templateId']").val();
        var action = obj.data('action');
        if (type === 'email') {
            account = form.find("input[name='email']").val();
            if (!account) {
                window.tips(fs_lang('email') + ': ' + fs_lang('errorEmpty'));
                return;
            }
            data = { type: type, useType: useType, templateId: templateId, account: account };
        } else if (type === 'sms' || type === 'phone') {
            // login page, cannot send sms verify code.
            // if change blade value, cannot login.
            // force change the type to sms
            type = 'sms';
            account = form.find("input[name='phone']").val();
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
                if (res.code !== 0) {
                    window.tips(res.message);
                    return;
                }
            },
            complete: function () {
                settime(obj);
            },
        });
    });
});
