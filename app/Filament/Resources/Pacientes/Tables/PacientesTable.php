<?php

namespace App\Filament\Resources\Pacientes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PacientesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('apellido')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('DUI')
                    ->label('DUI')
                    ->searchable(),
                TextColumn::make('fecha_nacimiento')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('genero'),
                TextColumn::make('expediente.tipo_sangre')
                    ->label('Tipo Sangre')
                    ->badge()
                    ->color('danger'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
