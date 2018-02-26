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
                <h3 class="box-title">Daftar Publikasi</h3>
                <span class="pull-right">
                    <a href="{{ route('publikasi.create') }}">
                        <button type="button" class="btn btn-success">Tambah Publikasi</button>
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
                        @foreach($data as $publikasi)
                        <tr>
                            <td>{!! ++$number !!}</td>
                            <td>{!! str_limit(($publikasi->penulis), 30) !!}</td>
                            <td>{!! str_limit(($publikasi->judul), 50) !!}</td>
                            <td>{!! str_limit(($publikasi->konten), 80) !!}</td>
                            <td>
                                @if(($publikasi->status)==1)
                                    Terbit
                                @else
                                    Tidak Terbit
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                <a href="{{ route('publikasi.show',$publikasi->id) }}"><button title="Komentar" type="button" class="btn btn-primary">
                                    <i class="fa fa-comments"></i>
                                </button></a>
                                <a href="{{ route('publikasi.edit',$publikasi->id) }}"><button title="Edit" type="button" class="btn btn-success">
                                    <i class="fa fa-pencil-square-o"></i>
                                </button></a>
                                {!! Form::open(['method' => 'DELETE','route' => ['publikasi.destroy', $publikasi->id],'style'=>'display:inline']) !!}
                                    <button title="Hapus" type="submit" class="btn btn-danger" data-confirm="Hapus publikasi ?" >
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