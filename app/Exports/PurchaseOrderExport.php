<?php

namespace App\Exports;

use App\Aset;
use App\PurchaseOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class PurchaseOrderExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($column, $filter) {
        $arr = collect([
            'id' => 'id',
            'po_number' => 'po_number',
            'date' => 'date',
            'vendor_id' => 'vendor_id',
            'created_by' => 'created_by',
            'created_on' => 'created_on',
            'updated_by' => 'updated_by',
            'updated_on' => 'updated_on',
            'deleted_by' => 'deleted_by',
            'deleted_on' => 'deleted_on'
        ]);

        $this->column = $column;
        $this->filter = $filter;
        $arr = $arr->only($column);
       
        $this->filteredColumn = $arr->values();
        // dd($this->filteredColumn);
    }


    public function collection()
    {
        $purchaseOrder = PurchaseOrder::select($this->filteredColumn->toArray());
        if($this->filter['filterByDate']) {
            if($this->filter['from'])
                $purchaseOrder = $purchaseOrder->whereRaw("DATE(".$this->filter['filterByDate'].") >= '".$this->filter['from']."'");
            if($this->filter['to'])
                $purchaseOrder = $purchaseOrder->whereRaw("DATE(".$this->filter['filterByDate'].") <= '".$this->filter['to']."'");
        }
        $purchaseOrder = $purchaseOrder->get();
        return $purchaseOrder;
    }

    public function headings(): array
    {
        return $this->column;
    }
}
