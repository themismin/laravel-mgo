<?php

namespace ThemisMin\LaravelMgo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ThemisMin\LaravelMgo\Models\MgoTable
 *
 * @property int $id
 * @property string $name 表名
 * @property string $display_name 显示名称
 * @property string $model_class 模型类名
 * @property string|null $comment 备注
 * @property string|null $migrate 迁移文件
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoColumn[] $mgoColumns
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoForeign[] $mgoForeigns
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoIndex[] $mgoIndices
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoModule[] $mgoModules
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoForeign[] $referencedMgoForeigns
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
 */
class MgoTable extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mgo_tables';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 一对多(获取定义表属性的定义列属性)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoColumns()
    {
        return $this->hasMany(MgoColumn::class, 'mgo_table_name', 'name');
    }

    /**
     * 一对多(获取定义表属性的定义索引属性)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoIndices()
    {
        return $this->hasMany(MgoIndex::class, 'mgo_table_name', 'name');
    }

    /**
     * 一对多(获取定义表属性的定义外键属性)(外键)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoForeigns()
    {
        return $this->hasMany(MgoForeign::class, 'mgo_table_name', 'name');
    }

    /**
     * 一对多(获取定义表属性的定义外键属性)(反向外键)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referencedMgoForeigns()
    {
        return $this->hasMany(MgoForeign::class, 'referenced_mgo_table_name', 'name');
    }

    /**
     * 一对多(获取定义表属性的定义模块)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoModules()
    {
        return $this->hasMany(MgoModule::class, 'mgo_table_name', 'name');
    }

}
