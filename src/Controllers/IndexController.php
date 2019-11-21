<?php

namespace ThemisMin\LaravelMgo\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
    protected function listModule(MgoModule $mgoModule, Request $request)
    {
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
    protected function showFeature(MgoFeature $mgoFeature, Request $request)
    {
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
    protected function editFeature(MgoFeature $mgoFeature, Request $request)
    {
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
            $rules = [];
            if (1 == $editMgoColumn->not_null) {
                $rules[] = [
                    'rule' => 'required'
                ];
            }

            $editDate[] = [
                "title" => $editMgoColumn->display_name,
                "key" => $editMgoColumn->name,
                'data_type' => $editMgoColumn->data_type,
                'rules' => $rules,
                'style' => isset($keyByAttrColumns[$editMgoColumn->name]['style']) ? $keyByAttrColumns[$editMgoColumn->name]['style'] : [],
                'data' => $data->{$editMgoColumn->name},
            ];
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
    protected function createFeature(MgoFeature $mgoFeature, Request $request)
    {
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
            ];
            switch ($createMgoColumn->data_type) {
                case 'enum':
                    $createColumn['mgo_enum_values'] = $createMgoColumn->mgoEnumValues->only(['id', 'name', 'display_name']);
                    break;
            }
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

}
