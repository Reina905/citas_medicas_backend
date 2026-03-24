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
        $diasMap = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo',
        ];

        $diaHoy = $diasMap[now()->format('l')];

        return [
            Stat::make('Total Pacientes', Paciente::count())
                ->description('Registrados en el sistema')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Citas Hoy', Cita::where('dia', $diaHoy)->count())
                ->description('Agendadas para ' . $diaHoy)
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),

            Stat::make('Médicos Activos', User::where('rol', 'doctor')->count())
                ->description('En el sistema')
                ->descriptionIcon('heroicon-m-heart')
                ->color('warning'),
        ];
    }
}