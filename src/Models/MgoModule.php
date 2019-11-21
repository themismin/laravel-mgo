<?php

namespace ThemisMin\LaravelMgo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ThemisMin\LaravelMgo\Models\MgoModule
 *
 * @property int $id
 * @property int $mgo_page_id 关联定义页面(页面ID)
 * @property string $name 模块名称
 * @property string $mgo_table_name 模块主表名(关联定义表属性)(表名)
 * @property string $type 模块类型(index,list,tree,charts,view)
 * @property array|null $attr 模块属性(list:{column:[title,logo,...],order_by:[created_at,updated_at],search:[title,deleted_at,...]})
 * @property int $order_by 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoFeature[] $mgoFeatures
 * @property-read \ThemisMin\LaravelMgo\Models\MgoPage $mgoPage
 * @property-read \ThemisMin\LaravelMgo\Models\MgoTable $mgoTable
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoModule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoModule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoModule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoModule whereAttr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoModule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoModule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoModule whereMgoPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoModule whereMgoTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoModule whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoModule whereOrderBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoModule whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoModule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MgoModule extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mgo_modules';

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
     * 一对多(获取定义模块的定义功能)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoFeatures()
    {
        return $this->hasMany(MgoFeature::class, 'mgo_module_id', 'id');
    }

    /**
     * 多对一(获取定义模块所属定义页面)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mgoPage()
    {
        return $this->belongsTo(MgoPage::class, 'mgo_page_id', 'id');
    }

    /**
     * 多对一(获取定义模块所属定义表属性)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mgoTable()
    {
        return $this->belongsTo(MgoTable::class, 'mgo_table_name', 'name');
    }

}
