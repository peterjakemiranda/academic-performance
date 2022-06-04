<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class GPAStudentChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($schoolYear, $schoolYearSemester, $average): array
    {
        return $this->chart->areaChart()
            ->setTitle($schoolYear)
            ->addData('GPA', $average)
            ->setXAxis($schoolYearSemester)
            ->setGrid(false, '#3F51B5', 0.1)
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10)
            ->setFontFamily('DM Sans')
            ->toVue();
    }
}
