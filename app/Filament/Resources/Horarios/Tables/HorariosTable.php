<?php

namespace App\Filament\Resources\Horarios\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HorariosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Médico')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('dia')
                    ->label('Día')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hora_inicio')
                    ->label('Hora Inicio')
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('hora_fin')
                    ->label('Hora Fin')
                    ->time('H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Filtrar por Médico')
                    ->options(
                        User::where('rol', 'doctor')->pluck('name', 'id')
                    )
                    ->visible(fn() => !auth()->user()->hasRole('doctor')),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
