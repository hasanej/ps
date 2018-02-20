@extends('admin.template')

@section('content')
<div class="row">
    <div class="col-md-12 m-t-20">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
    </div>
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Daftar Konten</h3>
                <span class="pull-right">
                    <a href="{{ route('konten.create') }}">
                        <button type="button" class="btn btn-success">Tambah Konten</button>
                    </a>
                </span>
            </div>

            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penulis</th>
                            <th>Judul</th>
                            <th>Konten</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $konten)
                        <tr>
                            <td>{{ ++$number }}</td>
                            <td>{{ $konten->penulis }}</td>
                            <td>{{ $konten->judul }}</td>
                            <td>{{ $konten->konten  }}</td>
                            <td style="white-space: nowrap">
                                <a href="{{ route('konten.edit',$konten->id) }}"><button title="Edit" type="button" class="btn btn-primary">
                                    <i class="fa fa-pencil-square-o"></i>
                                </button></a>
                                <a href="{{ route('konten.destroy',$konten->id) }}"><button title="Hapus" type="button" class="btn btn-danger" >
                                    <i class="fa fa-trash-o"></i>
                                </button></a>
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