<?php

/*
 |--------------------------------------------------------------------------
 | 验证信息说明
 |--------------------------------------------------------------------------
*/

return [
    'unique'               => ':attribute 已存在',
    'accepted'             => ':attribute 是被接受的',
    'active_url'           => ':attribute 必须是一个合法的 URL',
    'after'                => ':attribute 必须是 :date 之后的一个日期',
    'alpha'                => ':attribute 必须全部由字母字符构成。',
    'alpha_dash'           => ':attribute 必须全部由字母、数字、中划线或下划线字符构成',
    'alpha_num'            => ':attribute 必须全部由字母和数字构成',
    'array'                => ':attribute 必须是个数组',
    'before'               => ':attribute 必须是 :date 之前的一个日期',
    'between'              => [
        'numeric' => ':attribute 必须在 :min 到 :max 之间',
        'file'    => ':attribute 必须在 :min 到 :max KB之间',
        'string'  => ':attribute 必须在 :min 到 :max 个字符之间',
        'array'   => ':attribute 必须在 :min 到 :max 项之间',
    ],
    'boolean'              => ':attribute 字符必须是 true 或 false',
    'confirmed'            => ':attribute 二次确认不匹配',
    'date'                 => ':attribute 必须是一个合法的日期',
    'date_format'          => ':attribute 与给定的格式 :format 不符合',
    'different'            => ':attribute 必须不同于:other',
    'digits'               => ':attribute必须是:digits位',
    'digits_between'       => ':attribute 必须在 :min and :max 位之间',
    'email'                => ':attribute 必须是一个合法的电子邮件地址。',
    'filled'               => ':attribute 的字段是必填的',
    'exists'               => '选定的 :attribute 是无效的',
    'image'                => ':attribute 必须是一个图片 (jpeg, png, bmp 或者 gif)',
    'in'                   => '选定的:attribute是无效的',
    'integer'              => ':attribute 必须是个整数',
    'ip'                   => ':attribute 必须是一个合法的 IP 地址。',
    'max'                  => [
        'numeric' => ':attribute 的最大长度为 :max 位',
        'file'    => ':attribute 的最大为 :max',
        'string'  => ':attribute 的最大长度为 :max 字符',
        'array'   => ':attribute 的最大个数为 :max 个',
    ],
    'mimes'                => ':attribute 的文件类型必须是:values',
    'min'                  => [
        'numeric' => ':attribute 的最小长度为 :min 位',
        'string'  => ':attribute 的最小长度为 :min 字符',
        'file'    => ':attribute 大小至少为:min KB',
        'array'   => ':attribute 至少有 :min 项',
    ],
    'not_in'               => '选定的 :attribute 是无效的',
    'numeric'              => ':attribute必须是数字',
    'regex'                => ':attribute格式不正确',
    'required'             => ':attribute不得为空',
    'required_if'          => ':attribute 字段是必须的当 :other 是 :value',
    'required_with'        => ':attribute 字段是必须的当 :values 是存在的',
    'required_with_all'    => ':attribute 字段是必须的当 :values 是存在的',
    'required_without'     => ':attribute 字段是必须的当 :values 是不存在的',
    'required_without_all' => ':attribute 字段是必须的当 没有一个 :values 是存在的',
    'same'                 => ':attribute 和 :other 必须匹配',
    'size'                 => [
        'numeric' => ':attribute必须是:size位',
        'file'    => ':attribute必须是:sizeKB',
        'string'  => ':attribute必须是:size个字符',
        'array'   => ':attribute必须包括:size项',
    ],
    'url'                  => ':attribute 无效的格式',
    'timezone'             => ':attribute 必须个有效的时区',
    //自定义验证信息
    'custom'               => [

    ],
    //属性定义
    'attributes'           => [
    ],
];
