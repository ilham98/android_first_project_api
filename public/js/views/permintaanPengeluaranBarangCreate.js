var purchase_order_id = null;
var permintaanPengeluaranBarangItems = [];
var statusIds = [];

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
            purchase_order_id: purchase_order_id,
            asetIds: JSON.stringify(permintaanPengeluaranBarangItems)
          }
         
      },
      processResults: function (data) {
          console.log(purchase_order_id)
          return {
              results: $.map(data, function(item) {
                return {
                    id: item.id,
                    text: item.nama + ' | ' + 'Stok: ' + item.stok
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
                    id: item.id,
                    text: item.nama
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
        // tipe: "required",
        status: "required",
        departemen: "required",
        user: "required"
    },
    errorPlacement: function(label, element) {
        label.addClass('jquery-validate-error-message');
        label.insertAfter(element);
    },
    wrapper: 'div',
    submitHandler: function(form) {
        permintaanPengeluaranBarangItems.push($('#item').val());   
        statusIds.push($('#status').val());   
        $.ajax({
            url: '/ajax/item/' + $('#item').val(),
            success: function(res) {
                console.log(res);
                $('#tableTbody').append(`
                    <tr>
                        <td>1</td>
                        <td>${ res.tipe.nama }</td>
                        <td>${ $('#po_number').val() }</td>
                        <td>${ $('#item').val() }</td>
                        <td>${ $( "#status option:selected" ).text() }</td>
                    </tr>
                `)
                
                $('#po_number').val(null).trigger('change');
                $('#item').val(null).trigger('change');
                $('#status').val('');
            }
        })  
    }
});

$('#btnSave').click(function() {
    $.ajax({
        url: '/ajax/permintaan-pengeluaran-barang',
        method: 'POST',
        data: {
            no_surat: $('#no_surat').val(),
            departemen_id: $('#departemen').val(),
            itemIds: JSON.stringify(permintaanPengeluaranBarangItems),
            statusIds: JSON.stringify(statusIds),
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
});