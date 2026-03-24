<?php

namespace App\Filament\Widgets;

use App\Models\Cita;
use Filament\Widgets\ChartWidget;

class CitasChart extends ChartWidget
{
    protected ?string $heading = 'Citas por Día de la Semana';
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        $conteos = collect($dias)
            ->map(fn($dia) => Cita::where('dia', $dia)->count())
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Citas agendadas',
                    'data' => $conteos,
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#1d4ed8',
                ]
            ],
            'labels' => $dias,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
