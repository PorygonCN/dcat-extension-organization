<?php

namespace Porygon\Organization\Models;

use Dcat\Admin\Traits\ModelTree;
use Porygon\Base\Models\Model;
use Porygon\User\Models\User;
use Spatie\EloquentSortable\Sortable;

class Department extends Model implements Sortable
{
    use  ModelTree;
    protected $with    = ["parent"];
    protected $config = "p-organization";

    public function getTable()
    {
        return $this->config("prefix") . $this->config("tables.departments");
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    public function departments()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    public function in_charge_persons()
    {
        return $this->hasMany(InCharge::class);
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class, "in_charge");
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getFullTitleAttribute()
    {
        $title = $this->title;
        if ($this->parent) {
            $title = $this->parent->full_title . '-' . $this->title;
        }
        return $title;
    }
}
