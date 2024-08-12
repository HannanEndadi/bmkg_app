@extends('layouts.main')
@section('container')
<div class="card">
    <div class="container p-5">
      @if(session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <div class="table-responsive">
      <table id="table" class="display">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Nama</th>
              <th>Tipe</th>
              <th>Jumlah</th>
              <th>Status</th>
              <th>Borrower</th>
              <th>Tanggal Dipinjam</th>
              <th>Returner</th>
              <th>Tanggal Dikembalikan</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
          @foreach ($riwayats as $riwayat)
          
            <tr>
              <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $loop->iteration }} </strong></td>
              <td>{{ $riwayat->kode }}</td>
              <td>{{ $riwayat->nama }}</td>
              <td>{{ $riwayat->tipe }}</td>
              <td>{{ $riwayat->jumlah }}</td>
              <td>{{ $riwayat->status }}</td>
              <td>{{ $riwayat->created_by }}</td>
              <td>{{ $riwayat->created_at }}</td>
              <td>{{ $riwayat->updated_by }}</td>
              <td>{{ $riwayat->updated_at }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div> 
@endsection