<?php

namespace ThemisMin\LaravelMgo\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * ThemisMin\LaravelMgo\Models\MgoEnum
 *
 * @property int $id
 * @property string $name 枚举名称
 * @property string $display_name 显示名称
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoColumn[] $mgoColumns
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoEnumValue[] $mgoEnumValues
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoEnum newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoEnum newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoEnum query()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoEnum whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoEnum whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoEnum whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoEnum whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoEnum whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MgoEnum extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mgo_enums';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoEnumValues()
    {
        return $this->hasMany(MgoEnumValue::class, 'mgo_enum_name', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoColumns()
    {
        return $this->hasMany(MgoColumn::class, 'mgo_enum_name', 'name');
    }
}
