<?php

namespace App\Exports;

use App\Aset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class AsetExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($column, $filter) {
        $arr = collect([
            'id' => 'tr_aset.id as id',
            'registration_number' => 'registration_number',
            'item_id' => 'item_id',
            'tipe_id' => 'tipe_id',
            'status_id' => 'status_id',
            'npk' => 'npk',
            'permintaan_pengeluaran_barang_id' => 'permintaan_pengeluaran_barang_id',
            'status_pengeluaran_barang_id' => 'status_pengeluaran_barang_id',
            'teknisi_npk' => 'teknisi_npk',
            'pic' => 'pic',
            'catatan' => 'catatan',
            'klasifikasi_aset' => 'klasifikasi_aset',
            'kasie_layanan_in_on' => 'kasie_layanan_in_on',
            'kasie_layanan_in_by' => 'kasie_layanan_in_by',
            'teknisi_in_on' => 'teknisi_in_on',
            'teknisi_in_by' => 'teknisi_in_by',
            'kontrol_aset_in_on' => 'kontrol_aset_in_on',
            'kontrol_aset_in_by' => 'kontrol_aset_in_by',
            'kabag_layanan_in_on' => 'kabag_layanan_in_on',
            'kabag_layanan_in_by' => 'kabag_layanan_in_by',
            'approved_by_kabag_layanan_on' => 'approved_by_kabag_layanan_on',
            'approved_by_kabag_layanan_by' => 'approved_by_kabag_layanan_by',
            'rejected_by_kabag_layanan_on' => 'rejected_by_kabag_layanan_on',
            'rejected_by_kabag_layanan_by' => 'rejected_by_kabag_layanan_by',
            'approved_by_kepala_unit_kerja_on' => 'approved_by_kepala_unit_kerja_on',
            'approved_by_kepala_unit_kerja_by' => 'approved_by_kepala_unit_kerja_by',
            'barang_diserahkan_ke_pengguna_on' => 'barang_diserahkan_ke_pengguna_on',
            'barang_diserahkan_ke_pengguna_by' => 'barang_diserahkan_ke_pengguna_by',
            'signature_url' => 'signature_url',
            'nama_pengambil_barang' => 'nama_pengambil_barang',
            'created_on' => 'tr_aset.created_on',
            'created_by' => 'tr_aset.created_by',
            'updated_on' => 'tr_aset.updated_on',
            'updated_by' => 'tr_aset.updated_by',
            'deleted_on' => 'tr_aset.deleted_on',
            'deleted_by' => 'tr_aset.deleted_by',    
            'item_nama' => 'tr_item.nama as nama_item'
        ]);

        $this->column = $column;
        $this->filter = $filter;
        $arr = $arr->only($column);
       
        $this->filteredColumn = $arr->values();
        // dd($this->filteredColumn);
    }


    public function collection()
    {
        $aset = Aset::select($this->filteredColumn->toArray());
        if($this->filter['filterByDate']) {
            if($this->filter['from'])
                $aset = $aset->whereRaw("DATE(".$this->filter['filterByDate'].") >= '".$this->filter['from']."'");
            if($this->filter['to'])
                $aset = $aset->whereRaw("DATE(".$this->filter['filterByDate'].") <= '".$this->filter['to']."'");
        }
        $aset = $aset->join('tr_item', 'tr_aset.item_id', '=', 'tr_item.id')
                    ->get();
        return $aset;
    }

    public function headings(): array
    {
        return $this->column;
    }
}
