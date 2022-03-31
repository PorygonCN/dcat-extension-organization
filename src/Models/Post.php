<?php

namespace Porygon\Organization\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasDateTimeFormatter, ModelTree;

    protected $guarded = [];
    public function config($key)
    {
        return  config("jorganization.database.$key");
    }
    public function getTable()
    {
        return $this->config("prefix") . $this->config("tables.posts");
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class, "organization_in_charge");
    }
    public function users()
    {
        return $this->belongsToMany(User::class, "organization_in_charge");
    }
}
