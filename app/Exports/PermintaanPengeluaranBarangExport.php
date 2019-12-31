<?php

namespace App\Exports;

use App\PermintaanPengeluaranBarang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PermintaanPengeluaranBarangExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($column, $filter) {
        $arr = collect([
            'id' => 'id',
            'no_surat' => 'no_surat',
            'kode_unit_kerja' => 'kode_unit_kerja',
            'created_on' => 'created_on',
            'created_by' => 'created_by',
            'updated_on' => 'updated_on',
            'updated_by' => 'updated_by',
            'deleted_on' => 'deleted_on',
            'deleted_by' => 'deleted_by'
        ]);

        $this->column = $column;
        $this->filter = $filter;
        $arr = $arr->only($column);
       
        $this->filteredColumn = $arr->values();
        // dd($this->filteredColumn);
    }


    public function collection()
    {
        $permintaanPengeluaranBarang = PermintaanPengeluaranBarang::select($this->filteredColumn->toArray());
        if($this->filter['filterByDate']) {
            if($this->filter['from'])
                $permintaanPengeluaranBarang = $permintaanPengeluaranBarang->whereRaw("DATE(".$this->filter['filterByDate'].") >= '".$this->filter['from']."'");
            if($this->filter['to'])
                $permintaanPengeluaranBarang = $permintaanPengeluaranBarang->whereRaw("DATE(".$this->filter['filterByDate'].") <= '".$this->filter['to']."'");
        }
        return $permintaanPengeluaranBarang->get();
    }

    public function headings(): array
    {
        return $this->column;
    }
}
