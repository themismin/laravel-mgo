<?php

namespace ThemisMin\LaravelMgo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ThemisMin\LaravelMgo\Models\MgoForeign
 *
 * @property int $id
 * @property string $mgo_table_name 定义表属性名称(关联表名称)
 * @property string $name 外键名称
 * @property string $field 外键字段("mgo_table_name")(定义列属性名称)(关联列名称)
 * @property int $field_id 外键字段ID(关联列ID)
 * @property string $referenced_table_name 外键关联表("mgo_tables")
 * @property string $referenced_field 外键关联字段("name")
 * @property int $referenced_field_id 外键关联字段ID(关联列ID)
 * @property string $on_update 更新约束("CASCADE")
 * @property string $on_delete 删除约束("RESTRICT")
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
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereMgoTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereOnDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereOnUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereReferencedField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereReferencedFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereReferencedTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoForeign whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MgoForeign extends Model
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mgoColumn()
    {
        return $this->belongsTo(MgoColumn::class, 'field_id', 'id');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referencedMgoTable()
    {
        return $this->belongsTo(MgoTable::class, 'referenced_table_name', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referencedMgoColumn()
    {
        return $this->belongsTo(MgoColumn::class, 'referenced_field_id', 'id');

    }
}
