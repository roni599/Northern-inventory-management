<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings,WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Order::with('product')->get();
    }
    public function map($order): array
    {
        return [
            $order->id,
            $order->product->quantity,
            $order->status === '0' || $order->status === null ? 'Pending' : ($order->status === '1' ? 'Approved' : 'Rejected'),
            $order->comments,
            $order->bill_id,
            $order->product->product_name,
            $order->product->role->role_name,
            $order->product->role->role_name,
            Carbon::parse($order->created_at)->format('Y-m-d H:i:s'),
            Carbon::parse($order->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
    public function headings(): array
    {
        return [
            'Order ID',
            'Quantity',
            'Status',
            'Comments',
            'Bill_id',
            'Product Name',
            'Orderer Name',
            'Designation',
            'Created At',
            'Updated At'
        ];
    }
}
