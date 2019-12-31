<?php

// set_time_limit(1800);

// use Illuminate\Support\Facades\DB;

// $data = DB::connection('mysql2')
//         ->select('select * from v_karyawan_posisi_valid');

// foreach($data as $d) {
//     DB::connection('sqlsrv2')->insert('insert into v_karyawan_posisi_valid
//         (npk, nama, valid_from, valid_to, position_id, hierarchy_code, kode_unit_kerja, unit_kerja) 
//         values (?, ?, ?, ?, ?, ?, ?, ?)', 
//         [$d->npk, $d->nama, $d->valid_from, $d->valid_to, $d->position_id, $d->hierarchy_code, $d->kode_unit_kerja, $d->unit_kerja]
//      );
// }