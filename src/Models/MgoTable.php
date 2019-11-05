<?php

namespace ThemisMin\LaravelMgo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ThemisMin\LaravelMgo\Models\MgoTable
 *
 * @property int $id
 * @property string $name 表名称
 * @property string $display_name 显示名称
 * @property string $model_class 模型类名
 * @property string|null $comment 备注
 * @property string|null $migrate 迁移文件
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoColumn[] $mgoColumns
 * @property-read int|null $mgo_columns_count
 * @property-read \ThemisMin\LaravelMgo\Models\MgoEnum $mgoEnum
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoForeign[] $mgoForeigns
 * @property-read int|null $mgo_foreigns_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoIndex[] $mgoIndices
 * @property-read int|null $mgo_indices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoOrderBy[] $mgoOrderBys
 * @property-read int|null $mgo_order_bys_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoForeign[] $referencedMgoForeigns
 * @property-read int|null $referenced_mgo_foreigns_count
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoTable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoTable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoTable query()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoTable whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoTable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoTable whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoTable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoTable whereMigrate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoTable whereModelClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoTable whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoTable whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoModule[] $mgoModule
 * @property-read int|null $mgo_module_count
 */
class MgoTable extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoColumns()
    {
        return $this->hasMany(MgoColumn::class, 'mgo_table_name', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoIndices()
    {
        return $this->hasMany(MgoIndex::class, 'mgo_table_name', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoForeigns()
    {
        return $this->hasMany(MgoForeign::class, 'mgo_table_name', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referencedMgoForeigns()
    {
        return $this->hasMany(MgoForeign::class, 'referenced_table_name', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoOrderBys()
    {
        return $this->hasMany(MgoOrderBy::class, 'mgo_table_name', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoModule()
    {
        return $this->hasMany(MgoModule::class, 'mgo_table_name', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mgoEnum()
    {
        return $this->belongsTo(MgoEnum::class, 'mgo_enum_alias', 'alias');
    }

}
