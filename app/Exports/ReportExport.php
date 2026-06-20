<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection, WithHeadings
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'WhatsApp',
            'Total Harga',
            'Status',
            'Tanggal'
        ];
    }

    public function collection()
    {
        $query = Order::select(
            'id',
            'name',
            'whatsapp',
            'total_price',
            'status',
            'created_at'
        )->where('status', 'completed');

        if ($this->type == 'daily') {
            $query->whereDate('created_at', today());
        } elseif ($this->type == 'monthly') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } elseif ($this->type == 'yearly') {
            $query->whereYear('created_at', now()->year);
        }

        return $query->get();
    }
}