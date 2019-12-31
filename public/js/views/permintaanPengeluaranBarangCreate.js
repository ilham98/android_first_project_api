var purchase_order_id = null;
var permintaanPengeluaranBarangItems = [];
var statusIds = [];
var tanggalMulaiPeminjaman = [];
var tanggalSelesaiPeminjaman = [];
var selectedAsetId = null;
var editMode = false;

$('#po_number').select2({
    ajax: {
      url: '/ajax/purchase-order',
      dataType: 'json',
      type: 'GET',
      processResults: function (data) {
          return {
              results: $.map(data, function(item) {
                return {
                    id: item.id,
                    text: item.po_number
                }
              })
          }
      }
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
  });

  $('#po_number').on('select2:select', function (e) {
    $('#item').val(null).trigger('change');
    var data = e.params.data;
    purchase_order_id = data.id;
});

$('#item').select2({
    ajax: {
      url: '/ajax-action/get-item-and-stock-for-pengeluaran-barang',
      dataType: 'json',
      type: 'GET',
      data: function(data) {
          return {
            q: data.term,
            purchase_order_id: purchase_order_id,
            asetIds: JSON.stringify(permintaanPengeluaranBarangItems)
          }
         
      },
      processResults: function (data) {
          return {
              results: $.map(data, function(item) {
                return {
                    id: item.id,
                    text: item.registration_number + ' | ' + item.nama + ' | ' + 'Stok: ' + item.stok
                }
              })
          }
      }
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
  });

  $('#item').on('select2:select', function (e) {
    var data = e.params.data;
  });

  $('#departemen').select2({
    ajax: {
      url: '/ajax/departemen',
      dataType: 'json',
      type: 'GET',
      processResults: function (data) {
          return {
              results: $.map(data, function(item) {
                return {
                    id: item.KodeUnitKerja,
                    text: item.UnitKerja
                }
              })
          }
      }
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
  });

$("#permintaanPengeluaranBarangForm").validate({
    ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
    rules: {
        no_surat: "required",
        po_number: "required",
        item: "required",
        status: "required",
        departemen: "required",
        user: "required", 
    },
    errorPlacement: function(label, element) {
        label.addClass('jquery-validate-error-message');
        label.insertAfter(element);
    },
    wrapper: 'div',
    submitHandler: function(form) {
        var aset_id = $('#item').val()
        var len = $('#tableTbody').children().length + 1
        $.ajax({
            url: '/ajax/item/' + $('#item').val(),
            success: function(res) { 
                var itemName = $('#item option:selected').text().split("|")[0];
                if(editMode == false) {  
                    if(typeof fromEditForm !== 'undefined') {
                        if(fromEditForm) {
                            $.ajax({
                                url: '/ajax/permintaan-pengeluaran-barang/' + permintaan_pengeluaran_barang_id + '/aset/' + $('#item').val(),
                                method: 'POST',
                                data: {
                                    _token: csrf_token,
                                    status_id: $('#status').val()
                                },
                                success: function(res) {
                                    Swal.fire(
                                        'Berhasil Menambahkan Aset!',
                                        'Aset telah berhasil ditambahkan.',
                                        'success'
                                    )
                                }
                            })
                        }
                    }

                    $('#tableTbody').append(`
                        <tr data-id="${ aset_id }">
                            <td></td>
                            <td class='tableItemTipeNama'>${ res.tipe.nama }</td>
                            <td class='tablePoNumber'>${ $('#po_number option:selected').text() }</td>
                            <td class='tableRegistrationNumber'>${ res.registration_number }</td>
                            <td class='tableItem'>${ itemName }</td>
                            <td class='tableStatus'>${ $( "#status option:selected" ).text() }</td>
                            <td>
                                <span class="btnEdit"><i class="pe-7s-pen text-success"></i></span>
                                <span class="btnDelete"><i class="pe-7s-trash text-danger"></i></span>
                            </td>
                        </tr>
                    `)    
                } else {
                    if(typeof fromEditForm !== 'undefined') {
                        if(fromEditForm) {
                            $.ajax({
                                url: '/ajax/permintaan-pengeluaran-barang/' + permintaan_pengeluaran_barang_id + '/aset/' + aset_id,
                                method: 'PUT',
                                data: {
                                    prevAsetId: selectedAsetId,
                                    aset_id,
                                    status_id: $('#status').val(),
                                    _token: csrf_token
                                },
                                success: function(res) {
                                    Swal.fire(
                                        'Berhasil Mengedit Aset!',
                                        'Aset telah berhasil diedit.',
                                        'success'
                                    )
                                }
                            })
                        }
                    } else {
                        permintaanPengeluaranBarangItems = permintaanPengeluaranBarangItems.filter(function(p, i) {
                            console.log(i);
                            if(p == selectedAsetId) {
                                statusIds.splice(i, 1);
                                tanggalMulaiPeminjaman.splice(i, 1);
                                tanggalSelesaiPeminjaman.splice(i, 1);
                            }
                                
                            return p != selectedAsetId;
                        });
                    }

                    $(`#tableTbody tr[data-id="${selectedAsetId}"]`).html(`
                            <td></td>
                            <td class='tableItemTipeNama'>${ res.tipe.nama }</td>
                            <td class='tablePoNumber'>${ $('#po_number option:selected').text() }</td>
                            <td class='tableRegistrationNumber'>${ res.registration_number }</td>
                            <td class='tableItem'>${ itemName }</td>
                            <td class='tableStatus'>${ $( "#status option:selected" ).text() }</td>
                            <td>
                                <span class="btnEdit"><i class="pe-7s-pen  text-success"></i></span>
                                <span class="btnDelete"><i class="pe-7s-trash  text-danger"></i></span>
                            </td>
                    `);
                    
                    $(`#tableTbody tr[data-id="${selectedAsetId}"]`).attr('data-id', aset_id);
                    $('#buttonTambahAset').show();
                    $('#buttonUpdateAset').hide();
                    editMode = false;
                    $('.btnEdit').show();
                    $('.btnDelete').show();
                }

                permintaanPengeluaranBarangItems.push(aset_id); 
                statusIds.push($('#status').val());
                tanggalMulaiPeminjaman.push($('input[name="peminjaman_start_date"]').val());
                tanggalSelesaiPeminjaman.push($('input[name="peminjaman_end_date"]').val());
                console.log(permintaanPengeluaranBarangItems, statusIds);

                $('#po_number').val(null).trigger('change');
                $('#item').val(null).trigger('change');
                $('#status').val('');
                $('input[name="peminjaman_start_date"]').val('');
                $('input[name="peminjaman_end_date"]').val('');
            }
        })  
    }
});

if($('#status').val() == 3) {
    $('.peminjamanContainer').show();
} else {
    $('.peminjamanContainer').hide();
}

$('#status').change(function() {
    if($('#status').val() == 3) {
        $('.peminjamanContainer').show();
        $("#permintaanPengeluaranBarangForm").validate();
        $('#peminjaman_start_date').rules("add", {
            required: true
        });
        $('#peminjaman_end_date').rules("add", {
            required: true
        });
    } else {
        $('.peminjamanContainer').hide();
        $('input[name="peminjaman_start_date"]').rules("remove", 'required');
        $('input[name="peminjaman_end_date"]').rules("remove", 'required')
    }
});

$('body').on('click', '.btnEdit', function() {
    $('#buttonTambahAset').hide();
    $('#buttonUpdateAset').show();
    editMode = true;
    var id  = $(this).closest('tr').data('id');
    var poNumber = $(this).parent().siblings('.tablePoNumber').html();
    var tableItem = $(this).parent().siblings('.tableItem').html();
    var tableStatus = $(this).parent().siblings('.tableStatus').html();
    selectedAsetId = id;

    $('#po_number').html('');
    $('#po_number').append(`<option value='defaultVal'>${poNumber}</option>`);
    $('#po_number').val('defaultVal');
    
    $('#item').html('');
    $('#item').append(`<option value='${id}'>${tableItem}</option>`);
    $('#item').val(id);
    
    $('#test').find('option[text="B"]').val();
    var status_val = $(`#status option:contains('${tableStatus}')`).val();
    $('#status').val(status_val);
    if(status_val == 3) {
        $('.peminjamanContainer').show();
        $("#permintaanPengeluaranBarangForm").validate();
        $('#peminjaman_start_date').rules("add", {
            required: true
        });
        $('#peminjaman_end_date').rules("add", {
            required: true
        });
    } else {
        $('.peminjamanContainer').hide();
        $('input[name="peminjaman_start_date"]').rules("remove", 'required');
        $('input[name="peminjaman_end_date"]').rules("remove", 'required')
    }

    $('.btnEdit').hide();
    $('.btnDelete').hide();
});

$('#btnSave').click(function() {
    if(typeof fromEditForm !== 'undefined') {
        if(fromEditForm) {
            $.ajax({
                url: '/ajax/permintaan-pengeluaran-barang/'+permintaan_pengeluaran_barang_id,
                method: 'PUT',
                data: {
                    no_surat: $('#no_surat').val(),
                    departemen_id: $('#departemen').val(),
                    _token: csrf_token
                },
                success: function(res) {
                    $('#tableTbody').html('');
                    $('#po_number').val(null).trigger('change');
                    $('#item').val(null).trigger('change');
                    $('#status').val('');
                    Swal.fire(
                        'Sukses',
                        'Data berhasil disimpan',
                        'success'
                    );   
                }
            })  
        }
    } else {
        $.ajax({
            url: '/ajax/permintaan-pengeluaran-barang',
            method: 'POST',
            data: {
                no_surat: $('#no_surat').val(),
                departemen_id: $('#departemen').val(),
                itemIds: JSON.stringify(permintaanPengeluaranBarangItems),
                statusIds: JSON.stringify(statusIds),
                tanggalMulaiPeminjaman: JSON.stringify(tanggalMulaiPeminjaman),
                tanggalSelesaiPeminjaman: JSON.stringify(tanggalSelesaiPeminjaman),
                _token: csrf_token
            },
            success: function(res) {
                $('#tableTbody').html('');
                $('#po_number').val(null).trigger('change');
                $('#item').val(null).trigger('change');
                $('#departemen').val(null).trigger('change');
                $('#no_surat').val('');
                $('#status').val('');
                Swal.fire(
                    'Sukses',
                    'Data berhasil disimpan',
                    'success'
                );
                
            }
        })  
    }
    
});

if($('#status').val() == 3) {
    
}