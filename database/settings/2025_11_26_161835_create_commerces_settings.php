<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('commerces.default_vat_rate', 20);
        $this->migrator->add('commerces.devis_prefix', 'DE');
        $this->migrator->add('commerces.devis_day_retention', 15);
        $this->migrator->add('commerces.cvg');
    }
};
