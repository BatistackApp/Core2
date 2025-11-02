<?php

declare(strict_types=1);

namespace App\Models\Core;

use App\Services\Batistack;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Module extends Model
{

    protected $appends = ['name_formated', 'info_module'];
    
    protected $guarded = [];

    private array $cast = [
        'is_active' => 'boolean',
    ];

    public function getNameFormatedAttribute(): string
    {
        return Str::replace('Module', '', $this->name);
    }

    public function getInfoModuleAttribute()
    {
        return app(Batistack::class)->get('/modules/module-' . $this->slug);
    }
}
