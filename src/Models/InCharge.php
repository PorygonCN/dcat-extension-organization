<?php

namespace Porygon\Organization\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Porygon\User\Traits\BelongsToUser;

class InCharge extends Model
{
    use HasFactory, BelongsToUser;

    protected $guarded = [];
    protected $table   = "in_charge";
    protected $with    = ["user", "department", "post"];
    public function config($key)
    {
        return  config("jorganization.database.$key");
    }
    public function getTable()
    {
        return $this->config("prefix") . $this->config("tables.in_charge");
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
