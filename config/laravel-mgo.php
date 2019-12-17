<?php
return [

    'models' => [

        /** 定义表属性 */
        'mgo_tables' => \ThemisMin\LaravelMgo\Models\MgoTable::class,

        /** 定义列属性 */
        'mgo_columns' => \ThemisMin\LaravelMgo\Models\MgoColumn::class,

        /** 定义索引属性 */
        'mgo_indices' => \ThemisMin\LaravelMgo\Models\MgoIndex::class,

        /** 定义外键属性 */
        'mgo_foreigns' => \ThemisMin\LaravelMgo\Models\MgoForeign::class,

        /** 定义守卫属性 */
        'mgo_guards' => \ThemisMin\LaravelMgo\Models\MgoGuard::class,

        /** 定义模块 */
        'mgo_modules' => \ThemisMin\LaravelMgo\Models\MgoModule::class,

        /** 定义功能 */
        'mgo_features' => \ThemisMin\LaravelMgo\Models\MgoFeature::class,

        /** 定义枚举 */
        'mgo_enums' => \ThemisMin\LaravelMgo\Models\MgoEnum::class,

        /** 定义枚举值 */
        'mgo_enum_values' => \ThemisMin\LaravelMgo\Models\MgoEnumValue::class,

        /** 定义页面 */
        'mgo_pages' => \ThemisMin\LaravelMgo\Models\MgoPage::class,

    ],

    // 模型路径
    'model_path' => env('MGO_MODEL_PATH', ''),

    // 模型命名空间
    'model_namespace' => env('MGO_MODEL_NAMESPACE', ''),

    // 迁移文件路径
    'migrate_path' => env('MGO_MIGRATE_PATH', database_path('migrations')),

];