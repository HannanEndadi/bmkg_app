@extends('layouts.main')

@section('container')

<style>
  ul.timeline {
    list-style-type: none;
    position: relative;
}
ul.timeline:before {
    content: ' ';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 29px;
    width: 2px;
    height: 100%;
    z-index: 400;
}
ul.timeline > li {
    margin: 20px 0;
    padding-left: 20px;
}
ul.timeline > li:before {
    content: ' ';
    background: white;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 3px solid #22c0e8;
    left: 20px;
    width: 20px;
    height: 20px;
    z-index: 400;
}
</style>
<div class="container ">
  <div class="row mb-4">
    @can('superadmin')
    <div class="col">
      <div class="card border-0 zoom-in shadow-none p-3">
        <div class="text-center">
          <img src="{{ asset('assets/img/group.png') }}" width="50" height="50" class="mb-3" alt="">
          <h4 class="fw-semibold fs-3 mb-1">Pengguna</h4>
          <h5 class="fw-semibold mb-0">{{ $totalUsers }}</h5>
        </div>
      </div>
    </div>
    @endcan
    <div class="col">
      <div class="card border-0 zoom-in shadow-none p-3">
        <div class="text-center">
          <img src="{{ asset('assets/img/package.png') }}" width="50" height="50" class="mb-3" alt="">
          <h5 class="fw-semibold fs-3 mb-1">Barang</h5>
          <h5 class="fw-semibold mb-0">{{ $totalBarangs }}</h5>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card border-0 zoom-in shadow-none p-3">
        <div class="text-center">
          <img src="{{ asset('assets/img/history.png') }}" width="50" height="50" class="mb-3" alt="">
          <h4 class="fw-semibold fs-3 mb-1">Riwayat</h4>
          @can('admin')
          <h5 class="fw-semibold mb-0">{{ $totalRiwayatsA }}</h5>
          @elseif('superadmin')
          <h5 class="fw-semibold mb-0">{{ $totalRiwayatsA }}</h5>
          @else
          <h5 class="fw-semibold mb-0">{{ $totalRiwayats }}</h5>
          @endcan
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-8 mb-4">
      <div class="card w-100">
        <div class="card-body">
          <div id="chart" >
            {!! $chart->container() !!}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card w-100">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Barang sedang dipinjam</h4>
              @can('superadmin')
              @foreach ($riwayats as $riwayat)
              <ul class="timeline">
                <li>
                  <a target="" href="/riwayat">{{ $riwayat->nama }}</a>
                  <a href="#" class="float-right" style="color: black">,{{ $riwayat->created_at->format('D-m-Y') }}</a>
                  <p>{{ $riwayat->created_by }}</p>
                </li>
              </ul>
              @endforeach
              @endcan
              @can('admin')
              @foreach ($riwayats as $riwayat)
              <ul class="timeline">
                <li>
                  <a target="" href="/riwayat">{{ $riwayat->nama }}</a>
                  <a href="#" class="float-right" style="color: black">,{{ $riwayat->created_at->format('D-m-Y') }}</a>
                  <p>{{ $riwayat->created_by }}</p>
                </li>
              </ul>
              @endforeach
              @endcan
              @foreach ($riwayatsa as $riwayat)
              <ul class="timeline">
                <li>
                  <a target="" href="/riwayat">{{ $riwayat->nama }}</a>
                  <a href="#" class="float-right" style="color: black">,{{ $riwayat->created_at->format('D-m-Y') }}</a>
                  <p>{{ $riwayat->created_by }}</p>
                </li>
              </ul>
              @endforeach
            </div>
          </div>  
        </div>
      </div>
    </div>
  </div>
</div>


<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
@endsection