@extends('layouts.main')
@section('container')
    <div class="card mb-4">
        <h5 class="card-header">Peminjaman Barang</h5>
        <div class="card-body">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <form method="post" action="/peminjaman/store">
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
                            @foreach ($pinjams as $pinjam)
                                <option value="{{ $pinjam->nama }}" data-id="{{ $pinjam->id }}">{{ $pinjam->nama }}</option>
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
                        <input class="form-control" type="number" name="jumlah" id="jumlah" placeholder="Masukkan Jumlah Barang" />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="stok" class="col-md-2 col-form-label">Stok</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" name="stok" id="stok" readonly />
                    </div>
                </div>
                <input type="hidden" name="status" id="status" value="Dipinjam" readonly />
                

                <div class="mb-3 row">
                    <div class="col-lg-2 m-2" ></div>
                    <button type="submit" class="btn btn-primary col-md-1 ">Pinjam</button>
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
                    url: '/get-data-barang/' + selectedId,
                    type: 'GET',
                    success: function (data) {
                        $('#kode').val(data.kode);
                        $('#tipe').val(data.tipe);
                        $('#stok').val(data.jumlah);
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