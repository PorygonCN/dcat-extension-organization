<?php

namespace Porygon\Organization\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Porygon\Base\Models\Model;
use Porygon\User\Traits\BelongsToUser;

class InCharge extends Model
{
    use HasFactory, BelongsToUser;

    protected $with    = ["user", "department", "post"];
    protected $config = "p-organization";

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
