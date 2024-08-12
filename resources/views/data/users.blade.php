@extends('layouts.main')
@section('container')
<div class="card">
  <div class="card-header">
    <div class="col-lg-4 col-md-6">
      <div class="mt-3">
        @can('superadmin')
        <a href="/users/create" class="btn btn btn-outline-primary ml-3" data-bs-toggle="modal" data-bs-target="#modalCenter">
          <i class="tf-icons bx bx-user-plus me-1 "></i>
          User
        </a>
        @endcan
        <!-- Modal -->
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Tambah Data User</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <form method="post" action="/users">
              @csrf
              <div class="modal-body">
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameWithTitle" class="form-label">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan Nama" required autofocus/>
                  </div>
                </div>
                <div class="row g-2">
                  <div class="col mb-0">
                    <label for="emailWithTitle" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan Username" required/>
                  </div>
                  <div class="col mb-0">
                    <label for="dobWithTitle" class="form-label">Password</label>
                    <input type="text" name="password" id="password" class="form-control" placeholder="Masukkan Password" required/>
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
          const editButtons = document.querySelectorAll('.edit-user');
  
          editButtons.forEach(function (button) {
              button.addEventListener('click', function () {

                  const userId = this.getAttribute('data-user-id');
                  const userName = this.getAttribute('data-user-name');
                  const userUsername = this.getAttribute('data-user-username');
  
                  const modalId = `#modalCenter2_${userId}`;
                  const modal = document.querySelector(modalId);
  
                  modal.querySelector('#name').value = userName;
                  modal.querySelector('#username').value = userUsername;
  
                  new bootstrap.Modal(modal).show();
              });
          });
      });
  </script>

  @foreach ($users as $user)
    <div class="modal fade" id="modalCenter2_{{ $user->id }}" tabindex="-1" aria-hidden="true">
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
          <form method="post" action="/users/{{ $user->id }}">
            @method('put')
            @csrf
          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <label for="nameWithTitle" class="form-label">Nama</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" placeholder="Masukkan Nama" required/>
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-0">
                <label for="emailWithTitle" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" {{ old('username', $user->username) }} placeholder="Masukkan Username" required/>
              </div>
              <div class="col mb-0">
                <label for="dobWithTitle" class="form-label">Password</label>
                <input type="text" name="password" id="password" class="form-control" placeholder="Masukkan Password Baru" required/>
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
      <table id="table" class="display">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Username</th>
              {{-- <th>Password</th> --}}
        @can('superadmin')

              <th>Actions</th>
              @endcan
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
          @foreach ($users as $user)

            <tr>
              <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $loop->iteration }} </strong></td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->username }}</td>
              {{-- <td>{{ $user->password }}</td> --}}
        @can('superadmin')

              <td >
                <div class=" d-flex ">
                  <a href="#" class="btn rounded-pill btn-outline-warning edit-user" data-bs-toggle="modal" data-bs-target="#modalCenter2" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-username="{{ $user->username }}">
                    <span class="tf-icons bx bx-edit"></span>&nbsp; Edit
                  </a>&nbsp;&nbsp;
                  <form action="/users/{{ $user->id }}" method="post">
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