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
                <h3 class="box-title">Daftar Pengguna</h3>
                <span class="pull-right">
                    <a href="{{ route('user.create') }}">
                        <button type="button" class="btn btn-success">Tambah Pengguna</button>
                    </a>
                </span>
            </div>

            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>E-mail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $user)
                        <tr>
                            <td>{!! ++$number !!}</td>
                            <td>{!! str_limit(($user->name), 30) !!}</td>
                            <td>{!! str_limit(($user->username), 30) !!}</td>
                            <td>{!! str_limit(($user->email), 30) !!}</td>
                            <td>
                                <a href="{{ route('user.edit',$user->id) }}"><button title="Edit" type="button" class="btn btn-success">
                                    <i class="fa fa-pencil-square-o"></i>
                                </button></a>
                                {!! Form::open(['method' => 'DELETE','route' => ['user.destroy', $user->id],'style'=>'display:inline']) !!}
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