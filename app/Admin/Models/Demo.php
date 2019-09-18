<?php

namespace App\Admin\Models;

use App\Models\Demo as ProtoDemo;

class Demo extends ProtoDemo
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'designer_ids',
    ];

    /* Accessors */
    public function getDesignerIdsAttribute()
    {
        return $this->designers->pluck('id')->toArray();
    }

    /* Mutators */
    public function setDesignerIdsAttribute($value)
    {
        unset($this->attributes['designer_ids']);
    }
}
