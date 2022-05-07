<?php

namespace Porygon\Organization\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Porygon\Base\Models\Model;
use Porygon\Base\Models\User;

class Post extends Model
{
    use HasFactory, HasDateTimeFormatter, ModelTree;

    protected $config = "p-organization";

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
