<?php

namespace Porygon\Organization\Admin\Repositories;

use Porygon\Organization\Models\Post as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Post extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
