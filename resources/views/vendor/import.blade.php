<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mb-3">
        <h5 class="my-3">Import Data Vendor</h5>
        <form action="" autocomplete="false">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Contact Person</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendor as $v)
                    <tr data-id="{{ $v->id }}">
                        <td data-id="{{ $v->id }}" class='val-nama'>{{ $v->nama }}</td>
                        <td data-id="{{ $v->id }}" class='val-contact_person'>{{ $v->contact_person }}</td>
                        <td>
                            <span data-id='{{ $v->id }}' class='btnEdit'><i class="pe-7s-pen text-success"></i></span>
                            <span data-id='{{ $v->id }}' class='btnDelete'><i class="pe-7s-trash text-danger"></i></span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
        <div class="d-flex justify-content-between">
            {{ $vendor->links() }}
            <div class="ml-auto">
                <button class="btn btn-primary" id="btnConfirm">Lanjutkan Proses Import</button>
            </div>
            @method('POST')
            @csrf
        </div>
    </div>
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Vendor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="importForm">
                        <div class="form-group">
                            <label>Nama</label>
                            <input id="nama" class="form-control" type="text" name="nama">
                        </div>
                        <div class="form-group">
                            <label>Contact Person</label>
                            <input id="contactPerson" class="form-control" type="text" name="contact_person">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnUpdate">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/scripts/main.js"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="{{ asset('js/jqueryValidation.min.js') }}"></script>
    <script>
        var id;
        $('.btnEdit').click(function() {
            id = $(this).data('id');
            var nama = $(`.val-nama[data-id="${id}"]`).html();
            var contactPerson = $(`.val-contact_person[data-id="${id}"]`).html();
            console.log(nama, contactPerson);
            $('#nama').val(nama);
            $('#contactPerson').val(contactPerson);
            $('#importModal').modal('show');
        });

        $('#btnUpdate').click(function() {
            $('#importForm').submit();
        });

        $('.btnDelete').click(function() {
            var id = $(this).data('id');
            $.ajax({
                url: `/ajax/vendor/temp/${id}`,
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function() {
                    $(`tr[data-id="${id}"]`).remove();
                    location.reload();
                }
            })
        });

        $("#importForm").validate({
            rules: {
                nama: "required",
                contact_person: "required"
            },
            submitHandler: function(form) {
                var nama = $('#nama').val();
                var contactPerson = $('#contactPerson').val();
                $.ajax({
                    url: `/ajax/vendor/temp/${id}`,
                    method: 'PUT',
                    data: {
                        nama,
                        contact_person: contactPerson,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        $('#importModal').modal('hide');
                        $(`.val-nama[data-id="${id}"]`).html(nama);
                        $(`.val-contact_person[data-id="${id}"]`).html(contactPerson);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data berhasil di update',
                            showConfirmButton: false,
                            timer: 800
                        })
                    }
                })
            }
        });

        $('#btnConfirm').click(function() {
            $.ajax({
                url: '/vendor/import?temp=false',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    window.close();
                    window.opener.location.reload();
                }
            })
        })
    </script>
</body>

</html>