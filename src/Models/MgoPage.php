<?php

namespace ThemisMin\LaravelMgo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ThemisMin\LaravelMgo\Models\MgoPage
 *
 * @property int $id
 * @property int $mgo_guard_id 关联定义守卫(守卫ID)
 * @property string $name 页面名称
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \ThemisMin\LaravelMgo\Models\MgoGuard $mgoGuard
 * @property-read \Illuminate\Database\Eloquent\Collection|\ThemisMin\LaravelMgo\Models\MgoModule[] $mgoModules
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoPage whereMgoGuardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoPage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\ThemisMin\LaravelMgo\Models\MgoPage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MgoPage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mgo_pages';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 一对多(获取定义页面的定义模块)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mgoModules()
    {
        return $this->hasMany(MgoModule::class, 'mgo_page_id', 'id');
    }

    /**
     * 多对一(获取定义页面所属定义守卫)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mgoGuard()
    {
        return $this->belongsTo(MgoGuard::class, 'mgo_guard_id', 'id');
    }

}
