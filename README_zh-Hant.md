<p align="center"><a href="https://fresns.org" target="_blank"><img src="https://raw.githubusercontent.com/fresns/docs/main/images/Fresns-Logo(orange).png" width="300"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/Fresns-%5E2.0-orange" alt="Fresns">
<img src="https://img.shields.io/badge/WebFrame-%5E3.0-blueviolet" alt="WebFrame">
<img src="https://img.shields.io/badge/License-Apache--2.0-green" alt="License">
</p>

[English](README.md) | [简体中文](README_zh-Hans.md)

# 介紹

這是一個以外掛機制開發的用戶端程式，通過外掛方式安裝在主程式中運行，引用了 Composer [web-engine](https://github.com/fresns/web-engine) 擴展包。所以本質上就是外掛，除了默認封裝的功能之外，也可以按照外掛機制開發任何功能。

以下視圖和配置功能的開發，均是已經封裝好的功能，可以直接使用。

## 介面預覽

### WebFrame

![WebFrame](https://files.fresns.org/wiki/previews/WebFrame.png)

- 框架主題，展示網站端功能和互動流程。
- [https://marketplace.fresns.com/open-source/detail/WebFrame](https://marketplace.fresns.com/open-source/detail/WebFrame)

### Moments

![Moments](https://files.fresns.org/wiki/previews/Moments.png)

- 一款以資訊流為體驗形式的極簡風格主題，採用響應式設計，自適應電腦、平板電腦、行動裝置。
- [https://marketplace.fresns.com/open-source/detail/Moments](https://marketplace.fresns.com/open-source/detail/Moments)

## 視圖開發

用戶端視圖界面基於 Laravel Blade 方案，文件位於 `resources/views`，由 [web-engine](https://github.com/fresns/web-engine) 擴展包的路由使用。開發請參考 [web-engine](https://github.com/fresns/web-engine) 擴展包的文檔。

- 路徑結構 [https://github.com/fresns/web-engine#path-structure](https://github.com/fresns/web-engine#path-structure)
- 視圖標籤 [https://github.com/fresns/web-engine#view-tags](https://github.com/fresns/web-engine#view-tags)

## 配置開發

本用戶端的配置功能也是基於 Laravel Blade 方案，視圖文件是 `resources/views/functions.blade.php`

### 設置頁面

設置頁面的訪問地址由「路由名」和「路徑名」組成，路由名配置文件 `app/Config/ConfigInfo.php`

比如路由名是 `web-frame`，加上設置頁面的路徑名 `admin`，最終設置頁面的地址是 `/web-frame/admin`

### 配置項

配置項存儲在 [configs](https://fresns.org/database/systems/configs.html) 數據表，所有參數格式同數據表字段。

- 配置項列表 `app/Config/ConfigInfo.php` const `ITEMS`
- 配置項格式參考 [https://fresns.org/supports/utilities/config.html](https://fresns.org/supports/utilities/config.html)

### 設置頁多語言

如果你需要支持多語言，語言文件在 `resources/lang/` 目錄。

使用方式 `{{ __('WebFrame::fresns.name') }}`

其中 `WebFrame` 是命名空間名，配置在 `app/Config/ConfigInfo.php` const `WebFrame`

### 設置頁視圖功能

視圖文件 `resources/views/functions.blade.php`

**視圖功能介紹**

視圖設置文件，負責定義視圖自己的配置項，共有四種配置類型。

- 1、常規表單組件：組件為 input、textarea、select
- 2、上傳文件組件：組件為 input type="file"
- 3、多語言組件：組件為 input 或 textarea
- 4、關聯外掛組件：組件為 select 或 select multiple

**表單**

```html
<form action="{{ route('web-frame.admin.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <!-- input: item_key=fs_theme_name -->
    <input type="text" name="fs_theme_name" value="{{ $params['fs_theme_name']['value'] ?? '' }}">

    <!-- textarea: item_key=fs_theme_intro -->
    <textarea name="fs_theme_intro">{{ $params['fs_theme_intro']['value'] ?? '' }}</textarea>

    <!-- input file: item_key=fs_theme_logo -->
    <input type="hidden" name="fs_theme_logo" value="{{ $params['fs_theme_logo']['value'] }}">
    <input type="file" name="fs_theme_logo_file">
    <input type="url" name="fs_theme_logo_url">

    <!-- select: item_key=fs_theme_type -->
    <select name="fs_theme_type">
        <option value="">Null</option>
        <option value="1">One</option>
        <option value="2">Two</option>
    </select>

    <!-- select multiple: item_key=fs_theme_types -->
    <select name="fs_theme_types" multiple>
        <option value="">Null</option>
        <option value="1">One</option>
        <option value="2">Two</option>
    </select>

    <!-- plugin select multiple: item_key=fs_theme_plugins -->
    @foreach($params['fs_theme_plugins']['value'] ?? [] as $key => $item)
        <input type="text" name="fs_theme_plugins[{{$key}}][code]">
        <select name="fs_theme_plugins[{{$key}}][plugin]">
            <option value="">Null</option>
            <option value="1">One</option>
            <option value="2">Two</option>
        </select>
        <input type="number" name="fs_theme_plugins[{{$key}}][order]">
    @endforeach

    <button type="submit">儲存</button>
</form>

<!-- plugin select multiple: template -->
<template id="pluginTemplate">
    <input type="text" class="plugin-code" name="">
    <select class="plugin-fskey" name="">
        <option selected disabled>請選擇關聯外掛</option>
        <option value="">Null</option>
        <option value="1">One</option>
        <option value="2">Two</option>
    </select>
    <input type="number" class="plugin-order" name="">
</template>
```

**多語言表單：單行輸入**

```html
<!-- 獲取多語言數據 -->
{{ json_encode($params['fs_theme_title']['language_values'] ?? []) }}

<!-- 默認語言的值 -->
{{ $params['fs_theme_title']['value'] ?? '' }}
```

```html
<!-- model(multi-language input): item_key=fs_theme_title -->
<form action="{{ route('web-frame.admin.update.languages') }}" method="post">
    @csrf
    @method('put')

    <input type="hidden" name="fskey" value="WebFrame">
    <input type="hidden" name="itemKey" value="fs_theme_title">

    @foreach ($optionalLanguages as $lang)
        {{ $lang['langTag'] }}
        {{ $lang['langName'] }}

        @if ($lang['areaName'])
            {{ '('.$lang['areaName'].')' }}
        @endif

        @if ($lang['langTag'] == $defaultLanguage) 默認語言 @endif

        <input type="text" name="languages[{{ $lang['langTag'] }}]" value="{{ $params['fs_company_name']['language_values'][$lang['langTag']] ?? '' }}">
    @endforeach

    <button type="submit">儲存</button>
</form>
```

**多語言表單：多行輸入**

```html
<!-- 獲取多語言數據 -->
{{ json_encode($params['fs_theme_title']['language_values'] ?? []) }}

<!-- 默認語言的值 -->
{{ $params['fs_theme_title']['value'] ?? '' }}
```

```html
<!-- model(multi-language textarea): item_key=fs_theme_desc -->
<form action="{{ route('web-frame.admin.update.languages') }}" method="post">
    @csrf
    @method('put')

    <input type="hidden" name="fskey" value="WebFrame">
    <input type="hidden" name="itemKey" value="fs_theme_desc">

    @foreach ($optionalLanguages as $lang)
        {{ $lang['langTag'] }}
        {{ $lang['langName'] }}

        @if ($lang['areaName'])
            {{ '('.$lang['areaName'].')' }}
        @endif

        @if ($lang['langTag'] == $defaultLanguage) 默認語言 @endif

        <textarea name="languages[{{ $lang['langTag'] }}]">{{ $params['fs_company_name']['language_values'][$lang['langTag']] ?? '' }}</textarea>
    @endforeach

    <button type="submit">儲存</button>
</form>
```

## 授權協議

Fresns 網站是根據 [Apache-2.0](https://opensource.org/licenses/Apache-2.0) 授權的開源軟體。
