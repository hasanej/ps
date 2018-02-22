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
                <h3 class="box-title">Daftar Konten</h3>
            </div>

            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Komentar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $komentar)
                        <tr>
                            <td>{{ ++$number }}</td>
                            <td>{{ $komentar->user }}</td>
                            <td>{{ $komentar->komentar }}</td>
                            <td style="white-space: nowrap">
                                {!! Form::open(['method' => 'DELETE','route' => ['komenBerita.destroy', $komentar->id],'style'=>'display:inline']) !!}
                                    <button title="Hapus" type="submit" class="btn btn-danger" data-confirm="Hapus komentar ?" >
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