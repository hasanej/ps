@extends('admin.template')

@section('content')
<div class="row">
    <div class="col-md-12 m-t-20">
        <!-- session -->
    </div>
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Komentar Berita</h3>
            </div>

            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Komentar</th>
                            <th>Berita</th>
                                <th>Penulis</th>
                                <th style="display:none;">Penulis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $x = 1;
                        @endphp
                            <tr>
                                <td>{{ $x }}</td>
                                    <td></td>
                                    <td style="display:none;"></td>
                                <td></td>
                                <td></td>
                                <td style="white-space: nowrap">
                                    <a href=""><button title="Edit" type="button" class="btn btn-primary">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button></a>
                                    <a href=""><button title="Delete" type="button" class="btn btn-danger" data-confirm="Delete this data ?" >
                                        <i class="fa fa-trash-o"></i>
                                    </button></a>
                                </td>
                            </tr>
                        @php    
                        $x++;
                        @endphp
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection