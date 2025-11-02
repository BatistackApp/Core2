<?php

namespace App\Livewire\Core;

use App\Models\Core\Module;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ConfigModule extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions, InteractsWithSchemas, InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Action::make('ordering')
                    ->label('Commander un nouveau module')
                    ->url("https://saas.".config('batistack.domain').'/client/account/cart/module')
            ])
            ->query(Module::query())
            ->columns([
                TextColumn::make('name')
                    ->label('Module')
                    ->formatStateUsing(function (?Model $record) {
                        $info = $record->info_module;
                        ob_start()
                        ?>
                        <div class="flex items-center gap-2">
                            <div class="size-10 relative">
                                <img src="<?= $record->img_url ?>" alt="" class="rounded-md">
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="font-bold text-md"><?= $record->name_formated ?></span>
                                <span class="text-sm text-slate-500 w-[100px]"><?= $record->description ?></span>
                            </div>
                        </div>
                        <?php
                        return ob_get_clean();
                    })
                    ->html(),

                IconColumn::make('is_active')
                    ->label('Etat')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedCheckBadge)
                    ->falseIcon(Heroicon::OutlinedXCircle)
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->recordActions([
                Action::make('activate')
                    ->iconButton()
                    ->tooltip('Activer')
                    ->icon(Heroicon::OutlinedCheckBadge)
                    ->color('success')
                    ->visible(fn (Module $record) => !$record->is_active)
                    ->action(function (Module $record) {
                        $record->update(['is_active' => true]);
                    }),

                Action::make('deactivate')
                    ->iconButton()
                    ->tooltip('Désactiver')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (Module $record) => $record->is_active)
                    ->action(function (Module $record) {
                        $record->update(['is_active' => false]);
                    }),
            ]);
    }

    public function render()
    {
        return view('livewire.core.config-module');
    }
}
