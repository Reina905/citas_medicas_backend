<?php

namespace App\Filament\Widgets;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $hoy = now()->toDateString();

        return [
            Stat::make('Total Pacientes', Paciente::count())
                ->description('Registrados en el sistema')
                ->color('success'),

            Stat::make('Citas Hoy', Cita::whereDate('dia', $hoy)->count())
                ->description('Agendadas para ' . now()->format('Y-m-d'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),

            Stat::make('Médicos Activos', User::where('rol', 'doctor')->count())
                ->description('En el sistema')
                ->color('warning'),
        ];
    }
}