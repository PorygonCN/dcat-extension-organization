<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function getConnection()
    {
        return $this->config('database.connection') ?: config('database.default');
    }

    public function config($key)
    {
        return config('porygon.database.migrate.organization.' . $key);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->config("prefix") . $this->config("tables.departments"), function (Blueprint $table) {
            $table->id();
            $table->string("icon")->nullable()->comment("图标");
            $table->string("title")->comment("部门名");
            $table->foreignId("parent_id")->comment("父级部门")->default(0);
            $table->integer("order")->nullable();
            $table->boolean("is_company")->comment("子公司")->default(false);
            $table->boolean("autonomy")->comment("是否能自行添加子部门")->default(false);
            $table->boolean("enable")->comment("是否启用")->default(true);
            $table->timestamps();
        });

        Schema::create($this->config("prefix") . $this->config("tables.posts"), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("parent_id")->default(0);
            $table->string("title");
            $table->integer("order")->nullable();
            $table->boolean("enable")->default(true);
            $table->timestamps();
        });

        Schema::create($this->config("prefix") . $this->config("tables.in_charge"), function (Blueprint $table) {
            $table->id();
            $table->foreignId("department_id");
            $table->foreignId("user_id");
            $table->foreignId("post_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->config("tables") as $table) {
            Schema::dropIfExists($this->config("prefix") . $table);
        }
    }
};
