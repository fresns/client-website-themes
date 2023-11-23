<p align="center"><a href="https://fresns.org" target="_blank"><img src="https://files.fresns.org/images/logo.png" width="300"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/Fresns-%5E2.0-orange" alt="Fresns">
<img src="https://img.shields.io/badge/WebEngine-%5E3.0-blueviolet" alt="WebEngine">
<img src="https://img.shields.io/badge/License-Apache--2.0-green" alt="License">
</p>

[English](README.md) | [繁體中文](README_zh-Hant.md)

# 介绍

这是一个以插件机制开发的客户端程序，通过插件方式安装在主程序中运行，引用了 Composer [web-engine](https://github.com/fresns/web-engine) 扩展包。所以本质上就是插件，除了默认封装的功能之外，也可以按照插件机制开发任何功能。

以下视图和配置功能的开发，均是已经封装好的功能，可以直接使用。

## 界面预览

### WebFrame

![WebFrame](https://files.fresns.org/wiki/previews/WebFrame.png)

- 框架主题，展示网站端功能和交互流程。
- [https://marketplace.fresns.com/open-source/detail/WebFrame](https://marketplace.fresns.com/zh-Hans/open-source/detail/WebFrame)

### Moments

![Moments](https://files.fresns.org/wiki/previews/Moments.png)

- 一款以信息流为体验形式的极简风格主题，采用响应式设计，自适应电脑、平板电脑、移动设备。
- [https://marketplace.fresns.com/open-source/detail/Moments](https://marketplace.fresns.com/zh-Hans/open-source/detail/Moments)

## 视图开发

用户端视图界面基于 Laravel Blade 方案，文件位于 `resources/views`，由 [web-engine](https://github.com/fresns/web-engine) 扩展包的路由使用。开发请参考 [web-engine](https://github.com/fresns/web-engine) 扩展包的文档。

- 路径结构 [https://github.com/fresns/web-engine#path-structure](https://github.com/fresns/web-engine#path-structure)
- 视图标签 [https://github.com/fresns/web-engine#view-tags](https://github.com/fresns/web-engine#view-tags)

## 配置开发

本客户端的配置功能也是基于 Laravel Blade 方案，视图文件是 `resources/views/functions.blade.php`

### 设置页面

设置页面的访问地址由「路由名」和「路径名」组成，路由名配置文件 `app/Config/ConfigInfo.php`

比如路由名是 `web-frame`，加上设置页面的路径名 `admin`，最终设置页面的地址是 `/web-frame/admin`

### 配置项

配置项存储在 [configs](https://zh-hans.fresns.org/database/systems/configs.html) 数据表，所有参数格式同数据表字段。

- 配置项列表 `app/Config/ConfigInfo.php` const `ITEMS`
- 配置项格式参考 [https://zh-hans.fresns.org/supports/utilities/config.html](https://zh-hans.fresns.org/supports/utilities/config.html)

### 设置页多语言

如果你需要支持多语言，语言文件在 `resources/lang/` 目录。

使用方式 `{{ __('WebFrame::fresns.name') }}`

其中 `WebFrame` 是命名空间名，配置在 `app/Config/ConfigInfo.php` const `WebFrame`

### 设置页视图功能

视图文件 `resources/views/functions.blade.php`

**视图功能介绍**

视图设置文件，负责定义视图自己的配置项，共有四种配置类型。

- 1、常规表单组件：组件为 input、textarea、select
- 2、上传文件组件：组件为 input type="file"
- 3、多语言组件：组件为 input 或 textarea
- 4、关联插件组件：组件为 select 或 select multiple

**表单**

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
        <option selected disabled>请选择关联插件</option>
        <option value="">Null</option>
        <option value="1">One</option>
        <option value="2">Two</option>
    </select>
    <input type="number" class="plugin-order" name="">
</template>
```

**多语言表单：单行输入**

```html
<!-- 获取多语言数据 -->
{{ json_encode($params['fs_theme_title']['language_values'] ?? []) }}

<!-- 默认语言的值 -->
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

        @if ($lang['langTag'] == $defaultLanguage) 默认语言 @endif

        <input type="text" name="languages[{{ $lang['langTag'] }}]" value="{{ $params['fs_company_name']['language_values'][$lang['langTag']] ?? '' }}">
    @endforeach

    <button type="submit">保存</button>
</form>
```

**多语言表单：多行输入**

```html
<!-- 获取多语言数据 -->
{{ json_encode($params['fs_theme_desc']['language_values'] ?? []) }}

<!-- 默认语言的值 -->
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

        @if ($lang['langTag'] == $defaultLanguage) 默认语言 @endif

        <textarea name="languages[{{ $lang['langTag'] }}]">{{ $params['fs_company_name']['language_values'][$lang['langTag']] ?? '' }}</textarea>
    @endforeach

    <button type="submit">保存</button>
</form>
```

## 许可协议

Fresns 网站是根据 [Apache-2.0](https://opensource.org/licenses/Apache-2.0) 授权的开源软件。
