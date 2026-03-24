<?php

namespace App\Filament\Resources\Citas\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CitasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('paciente.nombre')
                    ->label('Paciente')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Médico')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('dia')
                    ->sortable(),
                TextColumn::make('hora_inicio')
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('hora_fin')
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
                DeleteBulkAction::make()
                    ->visible(fn() => auth()->user()->hasRole('admin')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
