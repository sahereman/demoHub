<?php

namespace App\Models;

use App\Admin\Models\Administrator;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Demo extends Model
{
    /*use Sluggable;
    use SluggableScopeHelpers;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }*/

    const DEMO_SCENARIO_PC = 'PC';
    const DEMO_SCENARIO_MOBILE = 'Mobile';

    public static $demoScenarioMap = [
        self::DEMO_SCENARIO_PC => 'PC 端',
        self::DEMO_SCENARIO_MOBILE => '移动端',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scenario',
        'name',
        'slug',
        'description',
        'memo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        //
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        //
    ];

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            // 如果模型的 slug 字段为空
            if (!$model->slug) {
                // 调用 generateSlug 生成 Slug
                $model->slug = static::generateSlug();
                // 如果生成失败，则终止创建订单
                if (!$model->slug) {
                    return false;
                }
            }
        });
    }

    //  生成 Slug
    public static function generateSlug()
    {
        // Slug前缀
        // $prefix = date('YmdHis');
        for ($i = 0; $i < 10; $i++) {
            // 随机生成 6 位的数字
            // $slug = $prefix . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $slug = 'De' . Str::random();
            // 判断是否已经存在
            if (!static::query()->where('slug', $slug)->exists()) {
                return $slug;
            }
        }
        Log::error('generating demo slug failed');
        return false;
    }

    /* Accessors */
    //

    /* Mutators */
    //

    /* Eloquent Relationships */
    public function designers()
    {
        return $this->belongsToMany(Administrator::class, 'demo_designers', 'demo_id', 'admin_user_id', 'id', 'id', 'designers');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
