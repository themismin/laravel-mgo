<?php

namespace App\Traits;


use App\Logics\TableLogic;
use App\Repositorys\DuProductRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * 列表数据
 * Trait ListTrait
 * @package App\Http\Modules\Adm\Traits
 */
trait ListTrait
{
    /**
     * 控制器主模块对象
     * @return Model
     * @throws Exception
     */
    abstract protected function getModel();

    /**
     * 列表筛选条件
     * @return array
     */
    abstract protected function getListWhere();

    /**
     * 列表排序规则
     * @return array
     */
    abstract protected function getListOrderBy();

    /**
     * 分页列表
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function paginate(Request $request)
    {
        $duProductRepository = app(DuProductRepository::class);

        // 显示字段
        $fields = $duProductRepository->where('list', true)->keys();

        /** @var Model $model */
        $model = $this->getModel();
        $where = $this->getListWhere();
        $orderBy = $this->getListOrderBy();

        /** @var array $param */
        $param = $request->all();

        if ($fields) {
            $model = $model->select($fields);
        }

        if ($where) {
            $model = $model->where(function ($query) use ($where, $param) {
                foreach ($where as $item) {
                    foreach ($param as $key => $val) {
                        // 下拉筛选条件包含传入的参数
                        if ($item['field'] == $key) {
                            // TODO:: 根据类型生成不同查询方式
                            $query->where($item['field'], $val);
                        }
                    }
                }
            });
        }

        if ($orderBy) {
            $column = $orderBy['column'];
            $direction = $orderBy['direction'];
            $model = $model->orderBy($column, $direction);
        }

        /** @var Collection $list */
        $list = $model->paginate();

        $list = $list->toArray();
        $list['columns'] = [];

        foreach ($duProductRepository as $key => $val) {
            if (isset($val['list']) && $val['list']) {
                $list['columns'][] = [
                    'title' => isset($val['display']) ? $val['display'] : $val['name'],
                    'key' => $key,
                    'property' => isset($val['property']) ? $val['property'] : 'string',
                ];
            }
        }

        return response_json($list);
    }
}