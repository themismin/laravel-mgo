<?php

namespace ThemisMin\LaravelMgo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ThemisMin\LaravelMgo\Models\MgoForeign
 *
 * @property int $id
 * @property string $mgo_table_name 关联定义表属性(表名)
 * @property string $name 外键名称
 * @property int $mgo_column_id 外键字段ID(关联定义列属性)(列ID)
 * @property string $referenced_mgo_table_name 外键关联表(关联定义表属性)(表名)
 * @property int $referenced_mgo_column_id 外键关联字段ID(关联定义列属性)(列ID)
 * @property string $on_update 更新约束(CASCADE,SET NULL,RESTRICT,NO ACTION)
 * @property string $on_delete 删除约束(CASCADE,SET NULL,RESTRICT,NO ACTION)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \ThemisMin\LaravelMgo\Models\MgoColumn $mgoColumn
 * @property-read \ThemisMin\LaravelMgo\Models\MgoTable $mgoTable
 * @property-read \ThemisMin\LaravelMgo\Models\MgoColumn $referencedMgoColumn
 * @property-read \ThemisMin\LaravelMgo\Models\MgoTable $referencedMgoTable
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign query()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereMgoColumnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereMgoTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereOnDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereOnUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereReferencedMgoColumnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereReferencedMgoTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MgoForeign extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mgo_foreigns';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 多对一(获取定义外键属性所属定义表属性)(外键)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mgoTable()
    {
        return $this->belongsTo(MgoTable::class, 'mgo_table_name', 'name');
    }

    /**
     * 多对一(获取定义外键属性所属定义列属性)(外键)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mgoColumn()
    {
        return $this->belongsTo(MgoColumn::class, 'mgo_column_id', 'id');

    }

    /**
     * 多对一(获取定义外键属性所属定义表属性)(反向外键)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referencedMgoTable()
    {
        return $this->belongsTo(MgoTable::class, 'referenced_mgo_table_name', 'name');
    }

    /**
     * 多对一(获取定义外键属性所属定义列属性)(反向外键)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referencedMgoColumn()
    {
        return $this->belongsTo(MgoColumn::class, 'referenced_mgo_column_id', 'id');

    }
}
