@extends('layouts.main')
@section('container')
    <div class="card mb-4">
        <h5 class="card-header">Pengembalian Barang</h5>
        <div class="card-body">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <form method="post" action="/pengembalian/store">
            @csrf
                <div class="mb-3 row">
                    <label for="kode" class="col-md-2 col-form-label">Kode Barang</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="kode" id="kode" readonly />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="nama" class="col-md-2 col-form-label">Nama Barang</label>
                    <div class="col-md-10">
                        <select name="nama" id="nama" class="form-select">
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($kembalis as $kembali)
                                <option value="{{ $kembali->nama }}" data-id="{{ $kembali->id }}">{{ $kembali->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="tipe" class="col-md-2 col-form-label">Tipe Barang </label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="tipe" id="tipe" readonly />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="jumlah" class="col-md-2 col-form-label">Jumlah Barang Dipinjam</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" name="jumlah" id="jumlah" readonly />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="created_by" class="col-md-2 col-form-label">Nama Peminjam</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="created_by" id="created_by" readonly />
                    </div>
                </div>
                <input type="hidden" name="status" id="status" value="Dikembalikan" readonly />
                <div class="mb-3 row">
                    <div class="col-lg-2 m-2" ></div>
                    <button type="submit" class="btn btn-primary col-md-2 ">Kembalikan</button>
                </div>
            </form>
        </div>


    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#nama').on('change', function () {
                var selectedOption = $(this).find(':selected');
                var selectedId = selectedOption.data('id');
                $.ajax({
                    url: '/get-data-barang-kembali/' + selectedId,
                    type: 'GET',
                    success: function (data) {
                        $('#kode').val(data.kode);
                        $('#tipe').val(data.tipe);
                        $('#jumlah').val(data.jumlah);
                        $('#created_by').val(data.created_by);
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $('form').submit(function () {
                var selectedOption = $('#nama').find(':selected');
                var selectedNama = selectedOption.val();
                $('#nama').val(selectedNama); // Setel nilai select menjadi nama barang
            });
        });
    </script>
@endsection