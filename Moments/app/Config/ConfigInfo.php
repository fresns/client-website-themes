<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace Plugins\Moments\Config;

class ConfigInfo
{
    const NAMESPACE = 'Moments';

    const ROUTE_NAME = 'moments';

    const ITEMS = [
        [
            'item_key' => 'moments_loading',
            'item_value' => 'true',
            'item_type' => 'boolean', // number, string, boolean, array, object, file, plugin, plugins
            'item_tag' => 'themes',
        ],
        [
            'item_key' => 'moments_quick_publish',
            'item_value' => 'true',
            'item_type' => 'boolean',
            'item_tag' => 'themes',
        ],
        [
            'item_key' => 'moments_editor_markdown',
            'item_value' => '{"quickPublish":1,"editor":1,"commentBox":1}',
            'item_type' => 'array',
            'item_tag' => 'themes',
        ],
        [
            'item_key' => 'moments_notifications',
            'item_value' => '["systems","recommends","likes","dislikes","follows","blocks","mentions","comments","quotes"]',
            'item_type' => 'array',
            'item_tag' => 'themes',
        ],
        [
            'item_key' => 'moments_search_method',
            'item_value' => 'google',
            'item_type' => 'string',
            'item_tag' => 'themes',
        ],
    ];
}
