<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class AsetChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(array $data): \ArielMejiaDev\LarapexCharts\BarChart
    {
        return $this->chart->barChart()
            ->setTitle('Data Peminjaman Barang')
            ->setSubtitle('Total Peminjaman Barang Setiap Minggu')
            ->addData('Total Peminjaman', $data['totalBorrowings'])
            ->addData('Total Pengembalian', $data['totalReturns'])
            ->setHeight(300)
            ->setXAxis($data['weekLabels']);
    }
}