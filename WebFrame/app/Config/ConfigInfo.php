<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace Plugins\WebFrame\Config;

class ConfigInfo
{
    const NAMESPACE = 'WebFrame';

    const ROUTE_NAME = 'web-frame';

    const ITEMS = [
        [
            'item_key' => 'webframe_loading',
            'item_value' => 'true',
            'item_type' => 'boolean', // number, string, boolean, array, object, file, plugin, plugins
            'item_tag' => 'themes',
        ],
        [
            'item_key' => 'webframe_quick_publish',
            'item_value' => 'true',
            'item_type' => 'boolean',
            'item_tag' => 'themes',
        ],
        [
            'item_key' => 'webframe_editor_markdown',
            'item_value' => '{"quickPublish":1,"editor":1,"commentBox":1}',
            'item_type' => 'array',
            'item_tag' => 'themes',
        ],
        [
            'item_key' => 'webframe_notifications',
            'item_value' => '["systems","recommends","likes","dislikes","follows","blocks","mentions","comments","quotes"]',
            'item_type' => 'array',
            'item_tag' => 'themes',
        ],
        [
            'item_key' => 'fs_company_name',
            'item_value' => 'Name LLC',
            'item_type' => 'string',
            'item_tag' => 'themes',
            'is_multilingual' => true,
            'language_values' => [
                'en' => 'Name LLC',
                'zh-Hans' => '某某网络科技有限公司',
                'zh-Hant' => '某某網路科技有限公司',
            ],
        ],
    ];
}
