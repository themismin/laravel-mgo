<?php

namespace ThemisMin\LaravelMgo\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use ThemisMin\LaravelMgo\Models\MgoColumn;
use ThemisMin\LaravelMgo\Models\MgoModule;
use ThemisMin\LaravelMgo\Models\MgoTable;

trait MgoTrait
{
    /**
     * 搜索字段
     * @param MgoModule|Collection $mgoModule 定义模块
     * @param array $attrColumns 搜索配置
     * @return array
     */
    protected function searchColumns(MgoModule $mgoModule, array $attrColumns)
    {
        /** @var MgoColumn[]|Collection $mgoColumns 定义列属性 */
        $mgoColumns = $mgoModule->mgoTable->mgoColumns;

        /** @var MgoColumn[]|Collection $mgoColumns 搜索配置 */
        if ($attrColumns) {
            $columns = collect($attrColumns)->pluck(['column'])->toArray();
            $searchMgoColumns = $mgoColumns->whereIn('name', $columns);
        } else {
            $searchMgoColumns = collect([]);
        }

        $searchColumns = [];
        foreach ($searchMgoColumns as $searchMgoColumn) {
            /** @var MgoColumn|Collection $searchMgoColumn */
            $searchColumn = [
                'title' => $searchMgoColumn->display_name,
                'key' => $searchMgoColumn->name,
                'data_type' => $searchMgoColumn->data_type,
            ];

            switch ($searchMgoColumn->data_type) {
                case 'enum':
                    $searchColumn['mgo_enum_values'] = $searchMgoColumn->mgoEnumValues->only(['id', 'name', 'display_name']);
                    break;
            }

            $searchColumns[] = $searchColumn;
        }
        return $searchColumns;
    }

    /**
     * 列字段
     * @param MgoModule|Collection $mgoModule 定义模块
     * @param array $attrColumns 列配置
     * @return array
     */
    protected function listColumns(MgoModule $mgoModule, array $attrColumns)
    {
        /** @var MgoTable|Collection $mgoTable 定义表 */
        $mgoTable = $mgoModule->mgoTable;
        /** @var MgoColumn[]|Collection $mgoColumns 定义列 */
        $mgoColumns = $mgoTable->mgoColumns;

        /** @var MgoColumn[]|array $listMgoColumns 列表显示字段 */
        if ($attrColumns) {
            $columns = collect($attrColumns)->pluck(['column'])->toArray();
            in_array('id', $columns) ?: $columns = array_merge(['id'], $columns);
            $listMgoColumns = $mgoColumns->whereIn('name', $columns);
        } else {
            $listMgoColumns = $mgoColumns;
        }

        $listColumns = [];
        foreach ($listMgoColumns as $listMgoColumn) {
            /** @var MgoColumn|Collection $listMgoColumn */
            $listColumn = [
                'title' => $listMgoColumn->display_name,
                'key' => $listMgoColumn->name,
                'data_type' => $listMgoColumn->data_type,
            ];

            switch ($listMgoColumn->data_type) {
                case 'enum':
                    $listColumn['mgo_enum_values'] = $listMgoColumn->mgoEnumValues->only(['id', 'name', 'display_name']);
                    break;
            }
            $listColumns[] = $listColumn;
        }
        return $listColumns;
    }
}