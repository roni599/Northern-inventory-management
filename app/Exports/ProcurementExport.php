<?php

namespace App\Exports;

use App\Models\Procurement;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProcurementExport implements FromCollection,WithHeadings,WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Procurement::all();
        // $product= Procurement::all();
        // return $product;
        return Procurement::with('product')->get();
    }
    public function map($product): array
    {
        return [
            $product->id,
            $product->quantity,
            $product->price,
            $product->unit_price,
            $product->status === '0' || $product->status === null ? 'Available' : 'Not Available',
            $product->product->product_name,
            Carbon::parse($product->created_at)->format('Y-m-d H:i:s'),
            Carbon::parse($product->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
    public function headings(): array
    {
        return [
            'PROCUREMENT ID',
            'QUANTITY',
            'PRICE',
            'UNIT PRICE',
            'STATUS',
            'PRODUCT NAME',
            'Created At',
            'Updated At'
        ];
    }
}
