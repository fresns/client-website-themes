<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace Plugins\WebFrame\Controllers;

use App\Fresns\Panel\Http\Controllers\Controller;
use App\Helpers\AppHelper;
use App\Helpers\CacheHelper;
use App\Helpers\ConfigHelper;
use App\Helpers\PrimaryHelper;
use App\Models\Config;
use App\Models\File;
use App\Models\FileUsage;
use App\Models\Language;
use App\Models\Plugin;
use App\Utilities\ConfigUtility;
use Illuminate\Http\Request;
use Plugins\WebFrame\Config\ConfigInfo;

class AdminController extends Controller
{
    protected $fresnsConfigItems = ConfigInfo::ITEMS;

    public function index()
    {
        // configs
        $functionKeys = collect($this->fresnsConfigItems ?? []);

        $configs = Config::whereIn('item_key', $functionKeys->pluck('item_key'))->get();
        $configValue = $configs->pluck('item_value', 'item_key');

        // config language keys
        $langKeys = $functionKeys->where('is_multilingual', true)->pluck('item_key');
        $languages = Language::ofConfig()->whereIn('table_key', $langKeys)->get();

        // params
        $params = [];
        foreach ($functionKeys as $functionKey) {
            $key = $functionKey['item_key'];
            $functionKey['value'] = $configValue[$key] ?? null;

            // File
            if ($functionKey['item_type'] == 'file') {
                $functionKey['fileType'] = ConfigHelper::fresnsConfigFileValueTypeByItemKey($key);

                if ($functionKey['fileType'] == 'ID') {
                    $functionKey['fileUrl'] = ConfigHelper::fresnsConfigFileUrlByItemKey($key);
                } else {
                    $functionKey['fileUrl'] = $functionKey['value'];
                }
            }

            // Multilingual
            if ($functionKey['is_multilingual'] ?? false) {
                $functionKey['value'] = $languages->where('table_key', $key)->where('lang_tag', $this->defaultLanguage)->first()['lang_content'] ?? '';
                $functionKey['language_values'] = $languages->where('table_key', $key)->mapWithKeys(function ($language) {
                    return [$language['lang_tag'] => $language['lang_content']];
                })->toArray();
            }

            $params[$key] = $functionKey;
        }

        // plugins
        $plugins = Plugin::all();

        $versionMd5 = AppHelper::VERSION_MD5_16BIT;

        $redirectURL = '/'.ConfigInfo::ROUTE_NAME.'/admin';

        $namespace = ConfigInfo::NAMESPACE;

        return view("{$namespace}::functions", compact('params', 'plugins', 'versionMd5', 'redirectURL'));
    }

    public function update(Request $request)
    {
        $functionKeys = collect($this->fresnsConfigItems ?? []);

        $fresnsConfigItems = [];
        foreach ($functionKeys as $functionKey) {
            $itemKey = $functionKey['item_key'];

            // upload file
            if ($functionKey['item_type'] == 'file') {
                $fileInputName = $itemKey.'_file';
                $fileUrlInputName = $itemKey.'_url';

                if ($request->file($fileInputName)) {
                    $wordBody = [
                        'usageType' => FileUsage::TYPE_SYSTEM,
                        'platformId' => 4,
                        'tableName' => 'configs',
                        'tableColumn' => 'item_value',
                        'tableKey' => $itemKey,
                        'type' => File::TYPE_IMAGE,
                        'file' => $request->file($fileInputName),
                    ];
                    $fresnsResp = \FresnsCmdWord::plugin('Fresns')->uploadFile($wordBody);
                    if ($fresnsResp->isErrorResponse()) {
                        return back()->with('failure', $fresnsResp->getMessage());
                    }
                    $fileId = PrimaryHelper::fresnsFileIdByFid($fresnsResp->getData('fid'));
                    $request->request->set($itemKey, $fileId);
                } elseif ($request->get($fileUrlInputName)) {
                    $request->request->set($itemKey, $request->get($fileUrlInputName));
                }

                CacheHelper::forgetFresnsConfigs($itemKey);
            }

            $value = $request->{$itemKey};
            if ($functionKey['item_type'] == 'plugins') {
                $value = array_values($value);
            }

            $fresnsConfigItems[] = [
                'item_key' => $itemKey,
                'item_value' => $value,
                'item_type' => $functionKey['item_type'],
                'item_tag' => $functionKey['item_tag'],
                'is_multilingual' => $functionKey['is_multilingual'] ?? false,
                'is_api' => 1,
            ];
        }
        ConfigUtility::changeFresnsConfigItems($fresnsConfigItems);

        return $this->updateSuccess();
    }

    public function updateLanguages(Request $request)
    {
        $itemKey = $request->itemKey;

        if (! $itemKey) {
            abort(404);
        }

        $functionKeys = collect($this->fresnsConfigItems ?? []);

        $functionKey = collect($functionKeys)->where('item_key', $itemKey)->first();
        if (! $functionKey) {
            abort(404);
        }

        $content = $request->languages[$this->defaultLanguage] ?? current(array_filter($request->languages));

        $fresnsConfigItem = [
            'item_key' => $functionKey['item_key'],
            'item_value' => $content,
            'item_type' => $functionKey['item_type'],
            'item_tag' => $functionKey['item_tag'],
            'is_multilingual' => $functionKey['is_multilingual'] ?? false,
            'is_api' => 1,
            'language_values' => $request->languages,
        ];

        ConfigUtility::changeFresnsConfigItems([$fresnsConfigItem]);

        return $this->updateSuccess();
    }
}
