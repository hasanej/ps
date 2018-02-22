@php 
    use App\User;
    use App\Berita;
    use App\Artikel;
    
    $jumlahAdmin = User::where('id_role', '<', 3)->count();
    $jumlahUser = User::where('id_role', '>=', 3)->count();
    $jumlahBerita = Berita::get()->count();
    $jumlahBeritaTerbit = Berita::where('status', '=', 1)->count();
    $jumlahArtikel = Artikel::get()->count();
    $jumlahArtikelTerbit = Artikel::where('status', '=', 1)->count();
@endphp

@extends('admin.template')

@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $jumlahAdmin }}</h3>
                <p>Administrator</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $jumlahUser }}</h3>
                <p>Pengguna Terdaftar</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{ $jumlahBeritaTerbit  }}</h3>
                <p>Berita Diterbitkan</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-paper"></i>
            </div>
        </div>
    </div>
     <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{ $jumlahArtikelTerbit  }}</h3>
                <p>Artikel Diterbitkan</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-clipboard"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-orange">
            <div class="inner">
                <h3>{{ $jumlahBerita  }}</h3>
                <p>Total Berita</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-paper-outline"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-orange">
            <div class="inner">
                <h3>{{ $jumlahArtikel  }}</h3>
                <p>Total Artikel</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-clipboard"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>150</h3>
                <p>Video Terdaftar</p>
            </div>
            <div class="icon">
              <i class="ion ion-videocamera"></i>
            </div>
        </div>
    </div>
</div>
@endsection