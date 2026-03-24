<?php

namespace App\Filament\Resources\Citas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CitaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('paciente_id')
                    ->numeric(),
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('dia')
                    ->date(),
                TextEntry::make('hora_inicio')
                    ->time(),
                TextEntry::make('hora_fin')
                    ->time(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
