<?php

namespace Porygon\Organization\Admin\Repositories;

use Porygon\Organization\Models\Department as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Department extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
