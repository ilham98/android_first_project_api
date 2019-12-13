var purchase_order_id = null;

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
      url: '/ajax-action/get-item-and-stock-for-asset',
      dataType: 'json',
      type: 'GET',
      data: function(data) {
          return {
            purchase_order_id: purchase_order_id
          }
         
      },
      processResults: function (data) {
          console.log(purchase_order_id)
          return {
              results: $.map(data, function(item) {
                console.log(item);
                return {
                    id: item.id,
                    text: item.item_order + ' | ' + item.nama + ' | ' + 'Stok: ' + item.stok
                }
              })
          }
      }
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
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

  $('#user').select2({
    ajax: {
      url: '/ajax/karyawan',
      dataType: 'json',
      type: 'GET',
      data: function(data) {
        return {
            departemen_id: $("#departemen").val()
        }  
      },
      processResults: function (data) {
          return {
              results: $.map(data, function(item) {
                return {
                    id: item.npk,
                    text: item.nama
                }
              })
          }
      }
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
  });

  $("#asetForm").validate({
    ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
    rules: {
        registration_number: "required",
        po_number: "required",
        item: "required",
        tipe: "required",
        status: "required",
        departemen: "required",
        user: "required"
    },
    errorPlacement: function(label, element) {
        label.addClass('jquery-validate-error-message');
        label.insertAfter(element);
    },
    wrapper: 'div'
  });