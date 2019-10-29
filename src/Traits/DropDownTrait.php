<?php

namespace App\Traits;


use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * 下拉筛选
 * Trait DropDownListTrait
 * @package App\Http\Modules\Adm\Traits
 */
trait DropDownTrait
{
    /**
     * 控制器主模块对象
     * @return Model
     * @throws Exception
     */
    abstract protected function getModel();

    /**
     * 下拉展示字段
     * @return string
     * @throws Exception
     */
    abstract protected function getDropDownField();

    /**
     * 下拉筛选条件
     * @return array
     */
    abstract protected function getDropDownWhere();

    /**
     * 下拉
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function dropDownList(Request $request)
    {
        /** @var Model $model */
        $model = $this->getModel();
        $field = $this->getDropDownField();
        $where = $this->getDropDownWhere();

        /** @var array $param */
        $param = $request->all();

        $list = $model->where(function ($query) use ($where, $param) {
            foreach ($where as $item) {
                foreach ($param as $key => $val) {
                    // 下拉筛选条件包含传入的参数
                    if ($item['field'] == $key) {
                        // TODO:: 根据类型查询
                        $query->where($item['field'], $val);
                    }
                }
            }
        })->get(['id', $field]);

        return response_json($list);
    }
}