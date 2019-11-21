<?php

namespace ThemisMin\LaravelMgo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ThemisMin\LaravelMgo\Models\MgoIndex
 *
 * @property int $id
 * @property string $mgo_table_name 关联定义表属性(表名)
 * @property string $name 索引名称
 * @property string $fields 索引字段(["name"])
 * @property string $type 索引类型("PRIMARY", "UNIQUE")
 * @property string $method 索引算法(BTREE, HASH)
 * @property string $comment 备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \ThemisMin\LaravelMgo\Models\MgoTable $mgoTable
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoIndex newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoIndex newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoIndex query()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoIndex whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoIndex whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoIndex whereFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoIndex whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoIndex whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoIndex whereMgoTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoIndex whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoIndex whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoIndex whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MgoIndex extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mgo_indices';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 多对一(获取定义索引属性所属定义表属性)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mgoTable()
    {
        return $this->belongsTo(MgoTable::class, 'mgo_table_name', 'name');
    }

}
