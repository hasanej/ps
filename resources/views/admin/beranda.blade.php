@extends('admin.template')

@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $data['jumlahAdmin'] }}</h3>
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
                <h3>{{ $data['jumlahUser'] }}</h3>
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
                <h3>{{ $data['jumlahBeritaTerbit'] }}</h3>
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
                <h3>{{ $data['jumlahArtikelTerbit'] }}</h3>
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
                <h3>{{ $data['jumlahBerita'] }}</h3>
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
                <h3>{{ $data['jumlahArtikel'] }}</h3>
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

<hr style="border-color: #9E9E9E;">

<div class="box-header with-border">
    <h3 class="box-title">Halaman Beranda</h3>
</div>

<div class="col-md-12 m-t-20">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Perhatian</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<div class="col-md-12 m-t-20">
    @if ($message = Session::get('feedback'))
        {!! $message !!}
    @endif
</div>
{!! Form::open(array('route'=>'beranda.store', 'method'=>'POST')) !!}
    <div class="box-body">
        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" placeholder="Judul" class="form-control" maxlength="255" @if(!empty($data)) value="{!! $data['beranda']->judul !!}" @endif> 
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Konten</h3>
                <div class="pull-right box-tools">
                    <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body pad">
                <textarea name="konten" id="ckeditor">@if(!empty($data)) {!! $data['beranda']->konten !!} @endif</textarea>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('berita.index') }}">
                <button type="button" class="btn btn-danger">Batal</button>
            </a>
        </div>
    </div>
{!! Form::close() !!}
@endsection