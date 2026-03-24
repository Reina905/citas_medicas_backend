<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class CitasChart extends ChartWidget
{
    protected ?string $heading = 'Citas Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
