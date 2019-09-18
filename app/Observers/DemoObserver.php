<?php

namespace App\Observers;

use App\Models\Demo;
use Illuminate\Support\Str;

class DemoObserver
{
    /*Eloquent 的模型触发了几个事件，可以在模型的生命周期的以下几点进行监控：
    retrieved、creating、created、updating、updated、saving、saved、deleting、deleted、restoring、restored
    事件能在每次在数据库中保存或更新特定模型类时轻松地执行代码。*/

    /*当模型已存在，不是新建的时候，依次触发的顺序是:
    saving -> updating -> updated -> saved(不会触发保存操作)
    当模型不存在，需要新增的时候，依次触发的顺序则是:
    saving -> creating -> created -> saved(不会触发保存操作)*/

    /**
     * Handle the demo "created" event.
     *
     * @param  \App\Models\Demo $demo
     * @return void
     */
    public function created(Demo $demo)
    {
        //
    }

    public function saving(Demo $demo)
    {
        /*if ($demo->slug) {
            $demo->slug .= Str::random();
        }*/
    }

    /**
     * Handle the demo "updated" event.
     *
     * @param  \App\Models\Demo $demo
     * @return void
     */
    public function updated(Demo $demo)
    {
        //
    }

    /**
     * Handle the demo "deleted" event.
     *
     * @param  \App\Models\Demo $demo
     * @return void
     */
    public function deleted(Demo $demo)
    {
        //
    }

    /**
     * Handle the demo "restored" event.
     *
     * @param  \App\Models\Demo $demo
     * @return void
     */
    public function restored(Demo $demo)
    {
        //
    }

    /**
     * Handle the demo "force deleted" event.
     *
     * @param  \App\Models\Demo $demo
     * @return void
     */
    public function forceDeleted(Demo $demo)
    {
        //
    }

    public function slugging(Demo $demo)
    {
        /*if ($demo->slug) {
            $demo->slug .= Str::random();
        }*/
    }

    public function slugged(Demo $demo)
    {
        /*if ($demo->slug) {
            $demo->slug .= Str::random();
            $demo->save();
        }*/
    }
}
