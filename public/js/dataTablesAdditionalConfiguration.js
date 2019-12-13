var dt = $(`${tableId}`).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            'url': url,
        },
        columns: columns
    });

    // Array to track the ids of the details displayed rows
    var detailRows = [];

    $(`${tableId} tbody`).on('click', 'tr td.details-control', function() {
        
        var tr = $(this).closest('tr');
        var row = dt.row(tr);
        var idx = $.inArray(tr.attr('id'), detailRows);

        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice(idx, 1);
        } else {
            tr.addClass('details');
            row.child(format(row.data())).show();

            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }
        }
    });

    // On each draw, loop over the `detailRows` array and show any child rows
    dt.on('draw', function() {
        $.each(detailRows, function(i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        });
    });