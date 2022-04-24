<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class GPAChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($schoolYearSemester, $gpaGroup, $average): array
    {
        return $this->chart->areaChart()
            ->setTitle($schoolYearSemester)
            ->addData('Number of students (%)', $average)
            ->setXAxis($gpaGroup)
            ->setGrid(false, '#3F51B5', 0.1)
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10)
            ->setFontFamily('DM Sans')
            ->toVue();
    }
}
