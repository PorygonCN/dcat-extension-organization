<?php

namespace Porygon\Organization\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Porygon\Organization\Models\Department;
use Porygon\Organization\Models\InCharge;

trait HasOrganization
{
    public $department_foreign_key = null;
    public $department_local_key   = null;
    public $department_class       = Department::class;

    public $in_charge_foreign_key = null;
    public $in_charge_local_key   = null;
    public $in_charge_class       = InCharge::class;


    public function department(): BelongsTo
    {
        return $this->belongsTo($this->department_class, $this->department_foreign_key, $this->department_local_key);
    }

    public function in_charges(): HasMany
    {
        return $this->hasMany($this->in_charge_class, $this->in_charge_foreign_key, $this->in_charge_local_key);
    }
}
