<p align="center"><a href="https://fresns.org" target="_blank"><img src="https://raw.githubusercontent.com/fresns/docs/main/images/Fresns-Logo(orange).png" width="300"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/Fresns-%5E2.0-orange" alt="Fresns">
<img src="https://img.shields.io/badge/WebEngine-%5E3.0-blueviolet" alt="WebEngine">
<img src="https://img.shields.io/badge/License-Apache--2.0-green" alt="License">
</p>

[简体中文](README_zh-Hans.md) | [繁體中文](README_zh-Hant.md)

# Introduction

This is a client program developed with a plugin mechanism, running by being installed in the main program through a plugin method, and it references the Composer [web-engine](https://github.com/fresns/web-engine) extension package. Essentially, it is a plugin that, in addition to the default encapsulated functions, can develop any function according to the plugin mechanism.

The following view and configuration function development are all pre-encapsulated functions that can be used directly.

## Preview

### WebFrame

![WebFrame](https://files.fresns.org/wiki/previews/WebFrame.png)

- Fresns view framework to showcase web-side functionality and interaction flow.
- [https://marketplace.fresns.com/open-source/detail/WebFrame](https://marketplace.fresns.com/open-source/detail/WebFrame)

### Moments

![Moments](https://files.fresns.org/wiki/previews/Moments.png)

- A minimalist theme in the form of information flow as an experience, with responsive design, adaptive to computers, tablets, mobile devices.
- [https://marketplace.fresns.com/open-source/detail/Moments](https://marketplace.fresns.com/open-source/detail/Moments)

## View Development

The user-end view interface is based on the Laravel Blade scheme, with files located in `resources/views`, used by the [web-engine](https://github.com/fresns/web-engine) extension package's routing. Please refer to the documentation of the [web-engine](https://github.com/fresns/web-engine) extension package for development.

- Path Structure [https://github.com/fresns/web-engine#path-structure](https://github.com/fresns/web-engine#path-structure)
- View Tags [https://github.com/fresns/web-engine#view-tags](https://github.com/fresns/web-engine#view-tags)

## Configuration Development

The configuration function of this client is also based on the Laravel Blade scheme, and the view file is `resources/views/functions.blade.php`

### Settings Page

The access address of the settings page is composed of "route name" and "path name", with the route name configured in the file `app/Config/ConfigInfo.php`

For example, if the route name is `web-frame`, plus the path name `admin` of the settings page, the final address of the settings page is `/web-frame/admin`

### Configuration Items

Configuration items are stored in the [configs](https://fresns.org/database/systems/configs.html) data table, and all parameter formats are the same as the data table fields.

- Configuration Item List `app/Config/ConfigInfo.php` const `ITEMS`
- Configuration Item Format Reference [https://fresns.org/supports/utilities/config.html](https://fresns.org/supports/utilities/config.html)

### Multi-language for Settings Page

If you need to support multiple languages, the language files are in the `resources/lang/` directory.

Usage: `{{ __('WebFrame::fresns.name') }}`

Where `WebFrame` is the namespace name, configured in `app/Config/ConfigInfo.php` const `WebFrame`

### View Setting Function

Setting the view file of the function `resources/views/functions.blade.php`

**Introduction to View Functions**

The view settings file, which is responsible for defining the view's own configuration items, has four configuration types.

- 1. General form tag: Type is input, textarea, select
- 2. Upload file html tag: Type is input type="file"
- 3. Multilingual html tag: Type is input or textarea
- 4. associated plugin html tag: Type is select or select multiple

**form**

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

    <button type="submit">Save</button>
</form>

<!-- plugin select multiple: template -->
<template id="pluginTemplate">
    <input type="text" class="plugin-code" name="">
    <select class="plugin-fskey" name="">
        <option selected disabled>Please select the plugin</option>
        <option value="">Null</option>
        <option value="1">One</option>
        <option value="2">Two</option>
    </select>
    <input type="number" class="plugin-order" name="">
</template>
```

**Multilingual form: input**

```html
<!-- Get multilingual data -->
{{ json_encode($params['fs_theme_title']['language_values'] ?? []) }}

<!-- Value of the default language -->
{{ $params['fs_theme_title']['value'] ?? '' }}
```

```html
<!-- model(multi-language input): item_key=fs_theme_title -->
<form action="{{ route('web-frame.admin.update.languages') }}" method="post">
    @csrf
    @method('put')

    <input type="hidden" name="itemKey" value="fs_theme_title">

    @foreach ($optionalLanguages as $lang)
        {{ $lang['langTag'] }}
        {{ $lang['langName'] }}

        @if ($lang['areaName'])
            {{ '('.$lang['areaName'].')' }}
        @endif

        @if ($lang['langTag'] == $defaultLanguage) Default Language @endif

        <input type="text" name="languages[{{ $lang['langTag'] }}]" value="{{ $params['fs_company_name']['language_values'][$lang['langTag']] ?? '' }}">
    @endforeach

    <button type="submit">Save</button>
</form>
```

**Multilingual form: textarea**

```html
<!-- Get multilingual data -->
{{ json_encode($params['fs_theme_desc']['language_values'] ?? []) }}

<!-- Value of the default language -->
{{ $params['fs_theme_desc']['value'] ?? '' }}
```

```html
<!-- model(multi-language textarea): item_key=fs_theme_desc -->
<form action="{{ route('web-frame.admin.update.languages') }}" method="post">
    @csrf
    @method('put')

    <input type="hidden" name="itemKey" value="fs_theme_desc">

    @foreach ($optionalLanguages as $lang)
        {{ $lang['langTag'] }}
        {{ $lang['langName'] }}

        @if ($lang['areaName'])
            {{ '('.$lang['areaName'].')' }}
        @endif

        @if ($lang['langTag'] == $defaultLanguage) Default Language @endif

        <textarea name="languages[{{ $lang['langTag'] }}]">{{ $params['fs_company_name']['language_values'][$lang['langTag']] ?? '' }}</textarea>
    @endforeach

    <button type="submit">Save</button>
</form>
```

## License

Fresns Website is open-sourced software licensed under the [Apache-2.0 license](https://opensource.org/licenses/Apache-2.0).
