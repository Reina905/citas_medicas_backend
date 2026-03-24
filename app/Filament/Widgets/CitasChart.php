<?php

namespace App\Filament\Widgets;

use App\Models\Cita;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CitasChart extends ChartWidget
{
    protected ?string $heading = 'Citas por Día de la Semana';
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $diasNombres = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        
        // Contar citas agrupadas por día de la semana (0=Domingo, 1=Lunes, etc.)
        $citasPorDia = Cita::query()
            ->select(DB::raw('EXTRACT(DOW FROM dia) as dia_semana'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('EXTRACT(DOW FROM dia)'))
            ->orderBy(DB::raw('EXTRACT(DOW FROM dia)'))
            ->get();

        // Mapear resultados a array [0=>0, 1=>5, 2=>3, ...]
        $conteos = [];
        foreach ($citasPorDia as $dia) {
            $conteos[(int)$dia->dia_semana] = (int)$dia->total;
        }

        // Asegurar que todos los días tengan un valor (rellenar con 0 si no hay citas)
        for ($i = 0; $i < 7; $i++) {
            if (!isset($conteos[$i])) {
                $conteos[$i] = 0;
            }
        }
        ksort($conteos);

        return [
            'datasets' => [
                [
                    'label' => 'Citas agendadas',
                    'data' => array_values($conteos),
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#1d4ed8',
                ]
            ],
            'labels' => $diasNombres,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
