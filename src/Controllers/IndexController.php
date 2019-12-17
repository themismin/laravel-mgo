<?php

namespace ThemisMin\LaravelMgo\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use ThemisMin\LaravelMgo\Models\MgoColumn;
use ThemisMin\LaravelMgo\Models\MgoFeature;
use ThemisMin\LaravelMgo\Models\MgoModule;
use ThemisMin\LaravelMgo\Models\MgoPage;
use ThemisMin\LaravelMgo\Models\MgoTable;
use ThemisMin\LaravelMgo\Traits\MgoTrait;
use Validator;

class IndexController extends Controller
{
    use MgoTrait;

    /**
     * 守卫
     * @var int
     */
    protected $mgoGuardId = 1;

    /**
     * 定义页面
     * @param MgoPage $mgoPage
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function page(MgoPage $mgoPage, Request $request)
    {
        /** @var array $mgoModuleConfig 模块配置 */
        $mgoModuleConfig = [];
        $mgoModules = $mgoPage->mgoModules;
        foreach ($mgoModules as $mgoModule) {
            /** @var MgoFeature[]|Collection $mgoFeatures 定义功能 */
            $mgoFeatures = $mgoModule->mgoFeatures;

            /** @var array $mgoModuleAttr 定义模块 配置 */
            $mgoModuleAttr = $mgoModule->attr;

            switch ($mgoModule->type) {
                case 'list':
                    // 搜索字段
                    $searchColumns = isset($mgoModuleAttr['search']) ? $mgoModuleAttr['search'] : [];
                    // 列表字段
                    $listColumns = isset($mgoModuleAttr['columns']) ? $mgoModuleAttr['columns'] : [];

                    $mgoModuleConfig[] = [
                        "id" => $mgoModule->id,
                        "name" => $mgoModule->name,
                        'mgo_table_name' => $mgoModule->mgo_table_name,
                        "type" => $mgoModule->type,
                        "search" => $this->searchColumns($mgoModule, $searchColumns),
                        "columns" => $this->listColumns($mgoModule, $listColumns),
                        "mgo_features" => $mgoFeatures->map(function ($mgoFeature) use ($mgoModule) {
                            return [
                                'id' => $mgoFeature->id,
                                "name" => $mgoFeature->name,
                                'type' => $mgoFeature->type,
                            ];
                        })
                    ];
                    break;
            }
        }
        $data = [
            'name' => $mgoPage->name,
            'mgo_modules' => $mgoModuleConfig
        ];
        return response_json($data);
    }

    /**
     * 定义模块-列表
     * @param MgoModule $mgoModule
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listModule(MgoModule $mgoModule, Request $request)
    {
        if ('list' != $mgoModule->type) {
            return response_json(null, 500);
        }

        /** @var MgoTable|Collection $mgoTable 定义表 */
        $mgoTable = $mgoModule->mgoTable;
        /** @var MgoColumn[]|Collection $mgoColumns 定义列 */
        $mgoColumns = $mgoTable->mgoColumns;

        /** @var Model $tableModel 模块功能 表模型 */
        $tableModel = app($mgoTable->model_class);

        // 模块功能 配置
        $attr = $mgoModule->attr;

        /** @var array $attrColumns 搜索字段 */
        $attrColumns = isset($attr['search']) ? $attr['search'] : [];
        /** @var MgoColumn[] $searchMgoColumns 搜索显示字段 */
        if ($attrColumns) {
            $columns = collect($attrColumns)->pluck(['column'])->toArray();
            $searchMgoColumns = $mgoColumns->whereIn('name', $columns);
        } else {
            $searchMgoColumns = collect([]);
        }

        $credentials = $request->all();
        foreach ($searchMgoColumns as $searchMgoColumn) {
            if (isset($credentials['search_' . $searchMgoColumn->name])) {
                // TODO::不同类型搜索方式不同
                if (in_array($searchMgoColumn->data_type, ['text'])) {
                    $tableModel = $tableModel->where($searchMgoColumn->name, 'LIKE', "%{$credentials['search_' . $searchMgoColumn->name]}%");
                } else {
                    $tableModel = $tableModel->where($searchMgoColumn->name, $credentials['search_' . $searchMgoColumn->name]);
                }
            }
        }

        /** @var array $attrColumns 列表字段 */
        $attrColumns = isset($attr['columns']) ? $attr['columns'] : [];
        /** @var MgoColumn[]|array $listMgoColumns 列表显示字段 */
        if ($attrColumns) {
            $columns = collect($attrColumns)->pluck(['column'])->toArray();
            in_array('id', $columns) ?: $columns = array_merge(['id'], $columns);
            $listMgoColumns = $mgoColumns->whereIn('name', $columns);
        } else {
            $listMgoColumns = $mgoColumns;
        }
        $listColumnNames = $listMgoColumns->pluck('name')->toArray();
        $tableModel = $tableModel->select($listColumnNames);

        /** @var array $orderBy 排序规则 */
        $attrColumns = $attr['order_by'];
        /** @var MgoColumn[]|array $orderByMgoColumns 列表显示字段 */
        if ($attrColumns) {
            $keyByAttrColumns = collect($attrColumns)->keyBy('column');
            $columns = collect($attrColumns)->pluck(['column'])->toArray();
            $orderByMgoColumns = $mgoColumns->whereIn('name', $columns);
            foreach ($orderByMgoColumns as $orderByMgoColumn) {
                $tableModel = $tableModel->orderBy($orderByMgoColumn->name, $keyByAttrColumns[$orderByMgoColumn->name]['sort']);
            }
        }

        /** @var Collection $listData */
        $listData = $tableModel->customPaginate();
        return response_json($listData);
    }

    /**
     * 定义功能-详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showFeature(MgoFeature $mgoFeature, Request $request)
    {
        if ('show' != $mgoFeature->type) {
            return response_json(null, 500);
        }

        /** @var MgoModule|Collection $mgoModule */
        $mgoModule = $mgoFeature->mgoModule;
        /** @var MgoTable|Collection $mgoTable 定义表 */
        $mgoTable = $mgoModule->mgoTable;
        /** @var MgoColumn[]|Collection $mgoColumns 定义列 */
        $mgoColumns = $mgoTable->mgoColumns;

        /** @var Model $tableModel 模块功能 表模型 */
        $tableModel = app($mgoTable->model_class);
        /** @var string $tableName 表名 */
        $tableName = $mgoTable->name;

        // 模块功能 配置
        $attr = $mgoFeature->attr;

        /** @var array $attrColumns 详情字段 */
        $attrColumns = $attr['columns'];
        /** @var MgoColumn[]|Collection $showMgoColumns 详情显示字段 */
        if ($attrColumns) {
            $columns = collect($attrColumns)->pluck(['column'])->toArray();
            $showMgoColumns = $mgoColumns->whereIn('name', $columns);
        } else {
            $showMgoColumns = $mgoColumns;
        }
        $showColumnNames = $showMgoColumns->pluck('name')->toArray();
        $tableModel = $tableModel->select($showColumnNames);

        $credentials = $request->all();
        $validator = Validator::make($credentials, [
            'id' => "required|exists:{$tableName}",
        ]);
        if ($validator->fails()) {
            return response_json($validator->errors(), '422');
        }

        /** @var Model|Collection $data */
        $data = $tableModel->find($credentials['id']);
        $showData = [];
        foreach ($showMgoColumns as $showMgoColumn) {
            $showData[] = [
                "title" => $showMgoColumn->display_name,
                "key" => $showMgoColumn->name,
                'data' => $data->{$showMgoColumn->name},
            ];
        }
        return response_json($showData);
    }

    /**
     * 定义功能-修改
     * @param MgoFeature $mgoFeature
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editFeature(MgoFeature $mgoFeature, Request $request)
    {
        if ('edit' != $mgoFeature->type) {
            return response_json(null, 500);
        }

        /** @var MgoModule|Collection $mgoModule */
        $mgoModule = $mgoFeature->mgoModule;
        /** @var MgoTable|Collection $mgoTable 定义表 */
        $mgoTable = $mgoModule->mgoTable;
        /** @var MgoColumn[]|Collection $mgoColumns 定义列 */
        $mgoColumns = $mgoTable->mgoColumns;

        /** @var Model $tableModel 模块功能 表模型 */
        $tableModel = app($mgoTable->model_class);
        /** @var string $tableName 表名 */
        $tableName = $mgoTable->name;

        // 模块功能 配置
        $attr = $mgoFeature->attr;

        /** @var array $attrColumns 详情字段 */
        $attrColumns = $attr['columns'];
        /** @var MgoColumn[]|Collection $editMgoColumns 详情显示字段 */
        if ($attrColumns) {
            $keyByAttrColumns = collect($attrColumns)->keyBy('column');
            $columns = collect($attrColumns)->pluck(['column'])->toArray();
            $editMgoColumns = $mgoColumns->whereIn('name', $columns);
        } else {
            $editMgoColumns = $mgoColumns;
        }
        $editColumnNames = $editMgoColumns->pluck('name')->toArray();
        $tableModel = $tableModel->select($editColumnNames);

        $credentials = $request->all();
        $validator = Validator::make($credentials, [
            'id' => "required|exists:{$tableName},id",
        ]);
        if ($validator->fails()) {
            return response_json($validator->errors(), '422');
        }

        /** @var Model|Collection $data */
        $data = $tableModel->find($credentials['id']);

        $editDate = [];
        foreach ($editMgoColumns as $editMgoColumn) {
            $editColumn = [
                'title' => $editMgoColumn->display_name,
                'key' => $editMgoColumn->name,
                'data_type' => $editMgoColumn->data_type,
                'data_values' => $this->dataValues($editMgoColumn),
                'data' => $data->{$editMgoColumn->name},
            ];
            $rules = [];
            if (1 == $editMgoColumn->not_null) {
                $rules[] = [
                    'rule' => 'required'
                ];
            }
            $editColumn['rules'] = $rules;
            $editColumn['style'] = isset($keyByAttrColumns[$editMgoColumn->name]['style']) ? $keyByAttrColumns[$editMgoColumn->name]['style'] : [];
            $editDate[] = $editColumn;
        }

        return response_json($editDate);
    }

    /**
     * 定义功能-修改提交
     * @param MgoFeature $mgoFeature
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateFeature(MgoFeature $mgoFeature, Request $request)
    {
        if ('edit' != $mgoFeature->type) {
            return response_json(null, 500);
        }

        /** @var MgoModule|Collection $mgoModule */
        $mgoModule = $mgoFeature->mgoModule;
        /** @var MgoTable|Collection $mgoTable 定义表 */
        $mgoTable = $mgoModule->mgoTable;
        /** @var MgoColumn[]|Collection $mgoColumns 定义列 */
        $mgoColumns = $mgoTable->mgoColumns;

        /** @var Model $tableModel 模块功能 表模型 */
        $tableModel = app($mgoTable->model_class);
        /** @var string $tableName 表名 */
        $tableName = $mgoTable->name;

        // 模块功能 配置
        $attr = $mgoFeature->attr;

        /** @var array $attrColumns 新增字段 */
        $attrColumns = $attr['columns'];
        /** @var MgoColumn[] $updateMgoColumns 新增显示字段 */
        if ($attrColumns) {
            $columns = collect($attrColumns)->pluck(['column'])->toArray();
            $updateMgoColumns = $mgoColumns->whereIn('name', $columns);
        } else {
            $updateMgoColumns = $mgoColumns;
        }

        $credentials = $request->all();
        $validator = Validator::make($credentials, [
            'id' => "required|exists:{$tableName}",
        ]);
        if ($validator->fails()) {
            return response_json($validator->errors(), '422');
        }

        /** @var array $rules 提交验证 */
        $rules = [];
        foreach ($updateMgoColumns as $updateMgoColumn) {
            $rules[$updateMgoColumn->name] = [];
            if (1 == $updateMgoColumn->not_null) {
                $rules[$updateMgoColumn->name][] = 'required';
            }
        }
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response_json($validator->errors(), '422');
        }

        $attributes = collect($credentials)->filter(function ($credential, $key) use ($updateMgoColumns) {
            return $updateMgoColumns->contains('name', $key);
        });
        $updateData = $tableModel->where('id', $credentials['id'])->update($attributes->toArray());
        return response_json($updateData);

    }

    /**
     * 定义功能-删除
     * @param MgoFeature $mgoFeature
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyFeature(MgoFeature $mgoFeature, Request $request)
    {
        if ('destroy' != $mgoFeature->type) {
            return response_json(null, 500);
        }

        /** @var MgoModule|Collection $mgoModule */
        $mgoModule = $mgoFeature->mgoModule;
        /** @var MgoTable|Collection $mgoTable 定义表 */
        $mgoTable = $mgoModule->mgoTable;
        /** @var MgoColumn[]|Collection $mgoColumns 定义列 */
        $mgoColumns = $mgoTable->mgoColumns;

        /** @var Model $tableModel 模块功能 表模型 */
        $tableModel = app($mgoTable->model_class);
        /** @var string $tableName 表名 */
        $tableName = $mgoTable->name;

        $credentials = $request->all();
        $validator = Validator::make($credentials, [
            'id' => "required|exists:{$tableName}",
        ]);
        if ($validator->fails()) {
            return response_json($validator->errors(), '422');
        }

        // TODO::外键关联判断是否可以删除
        $destroyData = $tableModel->destroy($credentials['id']);

        return response_json($destroyData);
    }

    /**
     * 定义功能-新增
     * @param MgoFeature $mgoFeature
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createFeature(MgoFeature $mgoFeature, Request $request)
    {
        if ('create' != $mgoFeature->type) {
            return response_json(null, 500);
        }

        /** @var MgoModule|Collection $mgoModule */
        $mgoModule = $mgoFeature->mgoModule;
        /** @var MgoTable|Collection $mgoTable 定义表 */
        $mgoTable = $mgoModule->mgoTable;
        /** @var MgoColumn[]|Collection $mgoColumns 定义列 */
        $mgoColumns = $mgoTable->mgoColumns;

        // 模块功能 配置
        $attr = $mgoFeature->attr;

        /** @var array $attrColumns 新增字段 */
        $attrColumns = $attr['columns'];
        /** @var MgoColumn[] $createMgoColumns 新增显示字段 */
        if ($attrColumns) {
            $keyByAttrColumns = collect($attrColumns)->keyBy('column');
            $columnsArr = collect($attrColumns)->pluck(['column'])->toArray();
            $createMgoColumns = $mgoColumns->whereIn('name', $columnsArr);
        } else {
            $createMgoColumns = $mgoColumns;
        }

        $createData = [];
        foreach ($createMgoColumns as $createMgoColumn) {
            $createColumn = [
                'title' => $createMgoColumn->display_name,
                'key' => $createMgoColumn->name,
                'data_type' => $createMgoColumn->data_type,
                'data_values' => $this->dataValues($createMgoColumn),
            ];
            $rules = [];
            if (1 == $createMgoColumn->not_null) {
                $rules[] = [
                    'rule' => 'required'
                ];
            }
            $createColumn['rules'] = $rules;
            $createColumn['style'] = isset($keyByAttrColumns[$createMgoColumn->name]['style']) ? $keyByAttrColumns[$createMgoColumn->name]['style'] : [];
            $createData[] = $createColumn;
        }

        return response_json($createData);
    }

    /**
     * 定义功能-新增提交
     * @param MgoFeature $mgoFeature
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeFeature(MgoFeature $mgoFeature, Request $request)
    {
        if ('create' != $mgoFeature->type) {
            return response_json(null, 500);
        }

        /** @var MgoModule|Collection $mgoModule */
        $mgoModule = $mgoFeature->mgoModule;
        /** @var MgoTable|Collection $mgoTable 定义表 */
        $mgoTable = $mgoModule->mgoTable;
        /** @var MgoColumn[]|Collection $mgoColumns 定义列 */
        $mgoColumns = $mgoTable->mgoColumns;

        /** @var Model $tableModel 模块功能 表模型 */
        $tableModel = app($mgoTable->model_class);

        // 模块功能 配置
        $attr = $mgoFeature->attr;

        /** @var array $attrColumns 新增字段 */
        $attrColumns = $attr['columns'];
        /** @var MgoColumn[] $createMgoColumns 新增显示字段 */
        if ($attrColumns) {
            $columns = collect($attrColumns)->pluck(['column'])->toArray();
            $createMgoColumns = $mgoColumns->whereIn('name', $columns);
        } else {
            $createMgoColumns = $mgoColumns;
        }

        $credentials = $request->all();
        $credentials = collect($credentials)->filter(function ($credential, $key) use ($createMgoColumns) {
            return $createMgoColumns->contains('name', $key);
        })->all();

        /** @var array $rules 提交验证 */
        $rules = [];
        foreach ($createMgoColumns as $addColumn) {
            $rules[$addColumn->name] = [];
            if (1 == $addColumn->not_null) {
                $rules[$addColumn->name][] = 'required';
            }
        }
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response_json($validator->errors(), '422');
        }

        $storeData = $tableModel->create($credentials);
        return response_json($storeData);
    }

    /**
     * 定义功能-恢复
     * @param MgoFeature $mgoFeature
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restoreFeature(MgoFeature $mgoFeature, Request $request)
    {
        if ('restore' != $mgoFeature->type) {
            return response_json(null, 500);
        }

        /** @var MgoModule|Collection $mgoModule */
        $mgoModule = $mgoFeature->mgoModule;
        /** @var MgoTable|Collection $mgoTable 定义表 */
        $mgoTable = $mgoModule->mgoTable;
        /** @var MgoColumn[]|Collection $mgoColumns 定义列 */
        $mgoColumns = $mgoTable->mgoColumns;

        /** @var Model $tableModel 模块功能 表模型 */
        $tableModel = app($mgoTable->model_class);
        /** @var string $tableName 表名 */
        $tableName = $mgoTable->name;

        $credentials = $request->all();
        $validator = Validator::make($credentials, [
            'id' => "required|exists:{$tableName}",
        ]);
        if ($validator->fails()) {
            return response_json($validator->errors(), '422');
        }

        // TODO::外键关联判断是否可以恢复
        $restoreData = $tableModel->restore($credentials['id']);

        return response_json($restoreData);
    }

    /**
     * 定义功能-下拉
     * @param MgoTable $mgoTable
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dropDown(MgoTable $mgoTable, Request $request)
    {
        /** @var Model $tableModel 模块功能 表模型 */
        $tableModel = app($mgoTable->model_class);

        $credentials = $request->all();
        $validator = Validator::make($credentials, [
            'id' => [
                'required',
                Rule::exists('mgo_columns')->where(function ($query) use ($mgoTable) {
                    $query->where('mgo_table_name', $mgoTable->name);
                }),
            ],
        ]);
        if ($validator->fails()) {
            return response_json($validator->errors(), '422');
        }
        $titleMgoColumn = $mgoTable->mgoColumns()->where('display_key', 1)->first();
        $keyMgoColumn = $mgoTable->mgoColumns()->where('id', $credentials['id'])->first();

        return $tableModel->select(\DB::raw("{$titleMgoColumn->name} AS `title`, {$keyMgoColumn->name} AS `key`"))->customPaginate();
    }

    /**
     * 定义功能-生成迁移文件和模型
     */
    public function migrationFilesFeature(MgoFeature $mgoFeature, Request $request)
    {
        $blank = " ";
        $dt = Carbon::now();
        $id = $request->get('id');
        //读取表以及表中的列
        $model_path = base_path('app/Repository/Entities');
        $table = MgoTable::with('mgoColumns')->where('id', $id)->first();
        $mod_name = Str::singular(Str::studly($table->name));
        // substr(str_replace(' ', '', ucwords(str_replace('_', ' ', $table->name))), 0, -1);
        if (file_exists($model_path . '/' . $mod_name . '.php') == false) {
            $mod_str = '<?php' . PHP_EOL . 'use Illuminate\Database\Eloquent\Model;' . PHP_EOL . 'class' .
                $blank . $mod_name . $blank . 'extends' . $blank . 'Model' . PHP_EOL . '{' . PHP_EOL;
            $mod_str .= 'protected $guarded = [\'id\'];' . PHP_EOL . '}';
            $model_url = fopen($model_path . '/' . $mod_name . '.php', 'w');
            //生成model
            fwrite($model_url, $mod_str);
            $tableName = $dt->year . '_' . $dt->month . '_' . $dt->day . '_' . $dt->hour . $dt->minute . $dt->second . '_' . $table->name;
            $database_path = database_path('migrations');
            $files_url = fopen($database_path . '/' . $tableName . '.php', 'w');
            $use = 'use Illuminate\Support\Facades\Schema; ' . PHP_EOL . 'use Illuminate\Database\Schema\Blueprint;' . PHP_EOL . 'use Illuminate\Database\Migrations\Migration;' . PHP_EOL;
            $str = '<?php' . PHP_EOL . PHP_EOL . $use . PHP_EOL . PHP_EOL;

            // dd($table);
            $str .= 'class ' . $table->name . $blank . 'extends' . $blank . 'Migration' . PHP_EOL . '{' . PHP_EOL . PHP_EOL . 'public function up()' . PHP_EOL . '{';
            $str .= PHP_EOL . 'Schema::create(' . "'" . $table->name . "'" . ',' . 'function(Blueprint $table) {' . PHP_EOL;

            // fwrite($files_url, $str);
            // dd(333);
            $guarded = ['id'];
            $timeArray = ['created_at', 'updated_at'];
            foreach ($table->mgoColumns as $k => $v) {
                // dump($table->name, $v['id'], $v);
                if (!in_array($v['name'], $timeArray)) {
                    // dump($v->name, $v['type'], $v['name']);
                    $name = $v->name;
                    $length = $v->length;
                    if ($v['name'] = 'id' && $v['auto_increment'] == 1) {
                        $str .= '$table->bigIncrements(' . "'" . $name . "'" . ')';
                    }
                    if ($v['name'] != 'id' && $v['type'] == 'bigint') {
                        $str .= '$table->increments(' . "'" . $name . "'" . ')';
                    }
                    if ($v['type'] == 'varchar') {
                        $str .= '$table->string(' . "'" . $name . "'";
                        if ($length != null) {
                            $str .= ',' . $length . ')';
                        } else {
                            $str .= ')';
                        }
                        // dd($str);
                    }
                    if ($v['not_null'] == 1) {
                        $str .= '->nullable()';
                    }
                    if ($v['default'] != null) {
                        $str .= '->default(' . "'" . $v['default'] . "'" . ')';
                    }
                    $str .= '->comment(' . "'" . $v['comment'] . "'" . ');' . PHP_EOL;
                }
            }
            $str .= '});' . PHP_EOL . '}' . PHP_EOL;
            // public down()
            $str .= 'public function down()' . PHP_EOL . '{' . PHP_EOL . 'Schema::dropIfExists(' . "'" . $table->name . "'" . ');' . PHP_EOL . '}}';
            //生成迁移文件
            fwrite($files_url, $str);
            return response_json();
        } else {
            return response_json('文件已经存在', 6000);
        }
    }

    /**
     * 上传签名
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAuth(Request $request)
    {
        $config = array(
            'Url' => 'https://sts.api.qcloud.com/v2/index.php',
            'Domain' => 'sts.api.qcloud.com',
            'Proxy' => '',
            'SecretId' => config('filesystems.disks.cosv5.credentials.secretId'), // 固定密钥
            'SecretKey' => config('filesystems.disks.cosv5.credentials.secretKey'), // 固定密钥
            'Bucket' => config('filesystems.disks.cosv5.bucket'),
            'Region' => config('filesystems.disks.cosv5.region'),
            'AllowPrefix' => 'upload_file_mgo/*', // 这里改成允许的路径前缀，这里可以根据自己网站的用户登录态判断允许上传的目录，例子：* 或者 a/* 或者 a.jpg
        );

        $pathname = $request->get('pathname', '/');
        $method = $request->get('method', 'get');
        $query = $request->get('query', []);
        $headers = $request->get('headers', []);

        // 获取临时密钥，计算签名
        $tempKeys = $this->_getTempKeys($config);
        if ($tempKeys && isset($tempKeys['credentials'])) {
            $data = array(
                'Authorization' => $this->_getAuthorization($tempKeys, $method, $pathname, $query, $headers),
                'XCosSecurityToken' => $tempKeys['credentials']['sessionToken'],
            );
        } else {
            $data = array('error' => $tempKeys);
        }
        return response_json($data);
    }

}
