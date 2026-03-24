<?php

namespace App\Filament\Resources\Citas;

use App\Filament\Resources\Citas\Pages\CreateCita;
use App\Filament\Resources\Citas\Pages\EditCita;
use App\Filament\Resources\Citas\Pages\ListCitas;
use App\Filament\Resources\Citas\Pages\ViewCita;
use App\Filament\Resources\Citas\Schemas\CitaForm;
use App\Filament\Resources\Citas\Schemas\CitaInfolist;
use App\Filament\Resources\Citas\Tables\CitasTable;
use App\Models\Cita;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CitaResource extends Resource
{
    protected static ?string $model = Cita::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'paciente_id';

    public static function form(Schema $schema): Schema
    {
        return CitaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CitaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CitasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user->hasRole('doctor')) {
            return $query->where('user_id', $user->id);
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCitas::route('/'),
            'create' => CreateCita::route('/create'),
            'view' => ViewCita::route('/{record}'),
            'edit' => EditCita::route('/{record}/edit'),
        ];
    }
}
