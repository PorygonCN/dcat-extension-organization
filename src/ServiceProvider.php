<?php

namespace Porygon\Organization;

use Dcat\Admin\Extend\ServiceProvider as ExtendServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Porygon\Base\Models\User;
use Porygon\Organization\Models\Department;
use Porygon\Organization\Models\InCharge;

class ServiceProvider extends ExtendServiceProvider
{
    protected $js = [];
    protected $css = [];

    // 定义菜单
    protected $menu = [
        [
            'title' => 'Organization',
            'uri'   => '',
            'icon'  => '',               // 图标可以留空
        ],
        [
            "parent" => "Organization",
            'title'  => 'Department',
            'uri'    => 'organization/departments',
            'icon'   => '',              // 图标可以留空
        ],
        [
            "parent" => "Organization",
            'title'  => 'Post',
            'uri'    => 'organization/posts',
            'icon'   => '',              // 图标可以留空
        ],
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'p-organization');

        User::macro("department", function (): BelongsTo {
            return $this->belongsTo(config("p-organization.model.relation.department.class"), config("p-organization.model.relation.department.foreign_key"), config("p-organization.model.relation.department.local_key"));
        });

        User::macro("in_charge", function (): HasMany {
            return $this->hasMany(config("p-organization.model.relation.inCharge.class"), config("p-organization.model.relation.inCharge.foreign_key"), config("p-organization.model.relation.inCharge.local_key"));
        });
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        require __DIR__ . "/Admin/bootstrap.php";

        $this->loadRoutes();

        $this->publishes([__DIR__ . '/../config/config.php' => config_path('p-organization.php'),], "p-organization-config");

        $this->loadTranslationsFrom(__DIR__ . "/../resources/lang", "p-organization");
        $this->publishes([__DIR__ . "/../resources/lang" => app()->langPath()], "porygon-organization-lang");
    }
    public function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->registerRoutes(__DIR__ . "/Admin/routes.php");
    }
}
