@extends('layouts.main')
@section('container')
<div class="card">
  <div class="card-header">
    <div class="col-lg-4 col-md-6">
      <div class="mt-3">
      @can('admin')
        <a href="/barang/create" class="btn btn btn-outline-primary ml-3" data-bs-toggle="modal" data-bs-target="#modalCenter">
          <i class="tf-icons bx bx-plus me-1 "></i>
          Barang
        </a>
      @endcan
        <!-- Modal -->
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Tambah Data Barang</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <form method="post" action="/barang">
              @csrf
              <div class="modal-body">
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameWithTitle" class="form-label">Kode</label>
                    <input type="text" name="kode" id="kode" class="form-control" placeholder="Masukkan Kode Barang" required autofocus/>
                  </div>
                </div>
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameWithTitle" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Barang" required/>
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col mb-0">
                    <label for="emailWithTitle" class="form-label">Tipe</label>
                    <select name="tipe" id="tipe" class="form-select">
                      <option value="">Pilih Tipe Barang</option>
                      <option value="Barang Biasa">Barang Biasa</option>
                      <option value="Barang Khusus">Barang Khusus</option>
                    </select>
                  </div>
                  <div class="col mb-0">
                    <label for="dobWithTitle" class="form-label">Jumlah</label>
                    <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Masukkan Jumlah Barang" required/>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                  Close
                </button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-barang');

        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {

              const barangId = this.getAttribute('data-barang-id');
                const barangKode = this.getAttribute('data-barang-kode');
                const barangNama = this.getAttribute('data-barang-nama');
                const barangTipe = this.getAttribute('data-barang-tipe');
                const barangJumlah = this.getAttribute('data-barang-jumlah');

                const modalId = `#modalCenter2_${barangId}`;
                const modal = document.querySelector(modalId);

                modal.querySelector('#kode').value = barangKode;
                    modal.querySelector('#nama').value = barangNama;
                    modal.querySelector('#tipe').value = barangTipe;
                    modal.querySelector('#jumlah').value = barangJumlah;

                new bootstrap.Modal(modal).show();
            });
        });
    });
</script>

@foreach ($barangs as $barang)
  <div class="modal fade" id="modalCenter2_{{ $barang->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCenterTitle">Edit Data User</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <form method="post" action="/barang/{{ $barang->kode }}">
          @method('put')
          @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameWithTitle" class="form-label">Kode</label>
              <input type="text" name="kode" id="kode" class="form-control" value="{{ old('kode', $barang->kode) }}" placeholder="Masukkan Nama" required/>
            </div>
          </div>          
          <div class="row">
            <div class="col mb-3">
              <label for="nameWithTitle" class="form-label">Nama</label>
              <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $barang->nama) }}" placeholder="Masukkan Kode" required/>
            </div>
          </div>
          <div class="row g-2">
            <div class="col mb-0">
              <label for="emailWithTitle" class="form-label">Tipe</label>
              <select name="tipe" id="tipe" class="form-select" @selected(true)>
                <option value="Barang Biasa">Barang Biasa</option>
                <option value="Barang Khusus">Barang Khusus</option>
              </select>
            </div>
            <div class="col mb-0">
              <label for="dobWithTitle" class="form-label">Jumlah</label>
              <input type="text" name="jumlah" id="jumlah" class="form-control" {{ old('jumlah', $barang->jumlah) }} placeholder="Masukkan Password Baru" required/>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
      </div>
    </div>
  </div>
@endforeach
  <div class="container p-5">
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="table-responsive">
    <table id="table" class="display" style="">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Tipe</th>
            <th>Jumlah</th>
            @can('admin')
            <th>Actions</th>
            @endcan
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
        @foreach ($barangs as $barang)

          <tr>
            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $loop->iteration }} </strong></td>
            <td>{{ $barang->kode }}</td>
            <td>{{ $barang->nama }}</td>
            <td>{{ $barang->tipe }}</td>
            <td>{{ $barang->jumlah }}</td>
            @can('admin')
            <td >
              <div class=" d-flex ">
                <a href="#" class="btn rounded-pill btn-outline-warning edit-barang" data-bs-toggle="modal" data-bs-target="#modalCenter2" data-barang-id="{{ $barang->id }}" data-barang-kode="{{ $barang->kode }}" data-barang-nama="{{ $barang->nama }}"data-barang-tipe="{{ $barang->tipe }}"data-barang-jumlah="{{ $barang->jumlah }}">
                  <span class="tf-icons bx bx-edit"></span>&nbsp; Edit
                </a>&nbsp;&nbsp;
                <form action="/barang/{{ $barang->id }}" method="post">
                  @method('delete')
                  @csrf
                <button class="btn rounded-pill btn-outline-danger">
                  <span class="tf-icons bx bx-trash"></span>&nbsp; Delete
                </button>
                </form>
              </div>
            </td>
            @endcan
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div> 
@endsection