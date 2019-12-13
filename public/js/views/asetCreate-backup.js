    var purchase_order_id = null;
    var po_number = $('#po_number').selectize({
        valueField: 'id',
        labelField: 'po_number',
        searchField: 'po_number',
        options: [],
        create: false,
        render: {
            option: function(item, escape) {
                return `
                    <div style="margin: 10px 0;">
                        <span>${item.po_number}</span>
                    </div>
                `;
            }
        },
        load: function(query, callback) {
            // if (!query.length) return callback();
            $.ajax({
                url: '/ajax/purchase-order',
                type: 'GET',
                error: function(err) {
                    console.log('error', err)
                    callback();
                },
                success: function(res) {
                    callback(res);
                }
            });
        }
    });

    var item = $('#item').selectize({
        valueField: 'id',
        labelField: 'nama',
        searchField: 'nama',
        options: [],
        create: false,
        render: {
            option: function(item, escape) {
                return `
                    <div style="margin: 10px 0;">
                        <span>${item.nama} | Stok: ${item.stok}</span>
                    </div>
                `;
            }
        },
        load: function(query, callback) {
            // if (!query.length) return callback();
            $.ajax({
                url: '/ajax-action/get-item-and-stock-for-asset',
                type: 'GET',
                data: {
                    q: query,
                    purchase_order_id: purchase_order_id
                },
                error: function(err) {
                    console.log('error', err)
                    callback();
                },
                success: function(res) {
                    callback(res);
                }
            });
        }
    });

    var departemen = $('#departemen').selectize({
        valueField: 'id',
        labelField: 'nama',
        searchField: 'nama',
        options: [],
        create: false,
        render: {
            option: function(item, escape) {
                return `
                    <div style="margin: 10px 0;">
                        <span>${item.nama}</span>
                    </div>
                `;
            }
        },
        load: function(query, callback) {
            // if (!query.length) return callback();
            $.ajax({
                url: '/ajax/departemen',
                type: 'GET',
                data: {
                    q: query    
                },
                error: function(err) {
                    console.log('error', err)
                    callback();
                },
                success: function(res) {
                    callback(res);
                }
            });
        }
    });

    var karyawan = $('#user').selectize({
        valueField: 'npk',
        labelField: 'nama',
        searchField: ['npk', 'nama'],
        options: [],
        create: false,
        render: {
            option: function(item, escape) {
                return `
                    <div style="margin: 10px 0;">
                        <span>${item.npk} - ${item.nama}</span>
                    </div>
                `;
            }
        },
        load: function(query, callback) {
            // if (!query.length) return callback();
            $.ajax({
                url: '/ajax/karyawan',
                type: 'GET',
                data: {
                    q: query,
                    departemen_id: $("#departemen").val()
                },
                error: function(err) {
                    console.log('error', err)
                    callback();
                },
                success: function(res) {
                    callback(res);
                }
            });
        }
    });

    item[0].selectize.disable();
    karyawan[0].selectize.disable();
    departemen[0].selectize.onSearchChange('');
    po_number[0].selectize.onSearchChange('');
    

    $('#po_number').change(function() {
        item[0].selectize.clear();
        purchase_order_id = $(this).val();  
        item[0].selectize.enable();
        item[0].selectize.onSearchChange('');
    })
    
    $('#departemen').change(function() {
        karyawan[0].selectize.clear();
        karyawan[0].selectize.enable();
        karyawan[0].selectize.onSearchChange('');
    })
    
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