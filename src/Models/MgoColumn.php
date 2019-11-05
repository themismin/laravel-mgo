<?php

namespace ThemisMin\LaravelMgo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ThemisMin\LaravelMgo\Models\MgoColumn
 *
 * @property int $id
 * @property string $mgo_table_name 关联定义表属性(定义表属性表名称)
 * @property string $name 列名称
 * @property string $display_name 显示名称
 * @property string $type 列类型
 * @property int|null $length 列长度
 * @property int|null $decimals 小数点长度
 * @property int $not_null 是否不为空
 * @property string|null $default 默认值
 * @property string $comment 备注
 * @property int $auto_increment 是否自增
 * @property int $unsigned 是否无符号
 * @property string $data_type 数据类型(enum:枚举,number:数字,text:文本,rich_text:富文本,image:图片,audio:音频,video:视频,has_one:对一关联,has_many:对多关联)
 * @property string|null $mgo_enum_alias 枚举别名
 * @property int $display_key 是否展示键
 * @property int $order_by 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoEnumValue[] $mgoEnumValues
 * @property-read int|null $mgo_enum_values_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoForeign[] $mgoForeigns
 * @property-read int|null $mgo_foreigns_count
 * @property-read \ThemisMin\LaravelMgo\Models\MgoTable $mgoTable
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoForeign[] $referencedMgoForeigns
 * @property-read int|null $referenced_mgo_foreigns_count
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn query()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereAutoIncrement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereDataType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereDecimals($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereDisplayKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereMgoEnumAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereMgoTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereNotNull($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereOrderBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereUnsigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MgoColumn extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mgoTable()
    {
        return $this->belongsTo(MgoTable::class, 'mgo_table_name', 'name');
    }

    /**
     * 外键字段
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoForeigns()
    {
        return $this->hasMany(MgoForeign::class, 'field_id', 'id');
    }

    /**
     * 反向外键字段
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referencedMgoForeigns()
    {
        return $this->hasMany(MgoForeign::class, 'referenced_field_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoEnumValues()
    {
        return $this->hasMany(MgoEnumValue::class, 'mgo_enum_alias', 'mgo_enum_alias');
    }
}
