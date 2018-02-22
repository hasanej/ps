@extends('admin.template')

@section('content')
<div class="row">
    <div class="col-md-12 m-t-20">
        @if ($message = Session::get('feedback'))
            {!! $message !!}
        @endif
    </div>
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Daftar Artikel</h3>
                <span class="pull-right">
                    <a href="{{ route('artikel.create') }}">
                        <button type="button" class="btn btn-success">Tambah Artikel</button>
                    </a>
                </span>
            </div>

            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penulis</th>
                            <th>Judul</th>
                            <th>Konten</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $artikel)
                        <tr>
                            <td>{!! ++$number !!}</td>
                            <td>{!! str_limit(($artikel->penulis), 30) !!}</td>
                            <td>{!! str_limit(($artikel->judul), 50) !!}</td>
                            <td>{!! str_limit(($artikel->konten), 80) !!}</td>
                            <td>
                                @if(($artikel->status)==1)
                                    Terbit
                                @else
                                    Tidak Terbit
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                <a href="{{ route('artikel.show',$artikel->id) }}"><button title="Komentar" type="button" class="btn btn-primary">
                                    <i class="fa fa-comments"></i>
                                </button></a>
                                <a href="{{ route('artikel.edit',$artikel->id) }}"><button title="Edit" type="button" class="btn btn-success">
                                    <i class="fa fa-pencil-square-o"></i>
                                </button></a>
                                {!! Form::open(['method' => 'DELETE','route' => ['artikel.destroy', $artikel->id],'style'=>'display:inline']) !!}
                                    <button title="Hapus" type="submit" class="btn btn-danger" data-confirm="Hapus artikel ?" >
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                {!! Form::close() !!}
                            </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection