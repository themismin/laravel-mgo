<?php

namespace ThemisMin\LaravelMgo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ThemisMin\LaravelMgo\Models\MgoColumn
 *
 * @property int $id
 * @property string $mgo_table_name 关联定义表属性(表名)
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
 * @property string|null $mgo_enum_name 关联定义枚举(枚举名称)
 * @property int $display_key 是否展示键
 * @property int $order_by 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \ThemisMin\LaravelMgo\Models\MgoEnum|null $mgoEnum
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoEnumValue[] $mgoEnumValues
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoForeign[] $mgoForeigns
 * @property-read \ThemisMin\LaravelMgo\Models\MgoTable $mgoTable
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoForeign[] $referencedMgoForeigns
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
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoColumn whereMgoEnumName($value)
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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mgo_columns';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 多对一(获取定义列属性所属定义表属性)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mgoTable()
    {
        return $this->belongsTo(MgoTable::class, 'mgo_table_name', 'name');
    }

    /**
     * 一对一(获取定义列属性的定义外键属性)(外键)
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mgoForeign()
    {
        return $this->hasOne(MgoForeign::class, 'mgo_column_id', 'id');
    }

    /**
     * 一对多(获取定义列属性的定义外键属性)(反向外键)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referencedMgoForeigns()
    {
        return $this->hasMany(MgoForeign::class, 'referenced_mgo_column_id', 'id');
    }

    /**
     * 多对一(获取定义列属性所属定义枚举)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mgoEnum()
    {
        return $this->belongsTo(MgoEnum::class, 'mgo_enum_name', 'name');
    }

    /**
     * 一对多(获取定义列属性的定义枚举值)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoEnumValues()
    {
        return $this->hasMany(MgoEnumValue::class, 'mgo_enum_name', 'mgo_enum_name');
    }

}
