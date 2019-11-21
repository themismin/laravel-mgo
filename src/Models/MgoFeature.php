<?php

namespace ThemisMin\LaravelMgo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ThemisMin\LaravelMgo\Models\MgoFeature
 *
 * @property int $id
 * @property int $mgo_module_id 关联定义模块(模块ID)
 * @property string $name 功能名称
 * @property string $type 功能类型(add,delete,update,view,share,...)
 * @property array|null $attr 功能属性(add:{...},update:[{column:name,edit:false},{column:logo,edit:true}])
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \ThemisMin\LaravelMgo\Models\MgoModule $mgoModule
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoFeature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoFeature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoFeature query()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoFeature whereAttr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoFeature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoFeature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoFeature whereMgoModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoFeature whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoFeature whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoFeature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MgoFeature extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mgo_features';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 这个属性应该被转换为原生类型.
     *
     * @var array
     */
    protected $casts = [
        'attr' => 'array',
    ];

    /**
     * 多对一(获取定义功能所属定义模块)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mgoModule()
    {
        return $this->belongsTo(MgoModule::class, 'mgo_module_id', 'id');
    }

}
