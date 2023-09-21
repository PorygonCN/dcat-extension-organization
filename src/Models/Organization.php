<?php

namespace Porygon\Organization\Models;

use Dcat\Admin\Traits\ModelTree;
use Laravel\Sanctum\HasApiTokens;
use Porygon\Base\Models\Model;
use App\Models\User;
use Spatie\EloquentSortable\Sortable;

class Organization extends Model
{
    protected $config = "p-organization";

    public function getTable()
    {
        return $this->config("prefix") . $this->config("tables.organizations");
    }
}
