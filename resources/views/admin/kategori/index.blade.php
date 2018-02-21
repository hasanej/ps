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
                <h3 class="box-title">Daftar Kategori</h3>
                <span class="pull-right">
                    <a href="{{ route('kategori.create') }}">
                        <button type="button" class="btn btn-success">Tambah Kategori</button>
                    </a>
                </span>
            </div>

            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $kategori)
                        <tr>
                            <td>{!! ++$number !!}</td>
                            <td>{!! str_limit(($kategori->nama), 30) !!}</td>
                            </td>
                            <td>
                                <a href="{{ route('kategori.edit',$kategori->id) }}"><button title="Edit" type="button" class="btn btn-success">
                                    <i class="fa fa-pencil-square-o"></i>
                                </button></a>
                                {!! Form::open(['method' => 'DELETE','route' => ['kategori.destroy', $kategori->id],'style'=>'display:inline']) !!}
                                    <button title="Hapus" type="submit" class="btn btn-danger" data-confirm="Hapus data ?" >
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                {!! Form::close() !!}
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