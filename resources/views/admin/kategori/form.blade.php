<div class="box-body">
    <div class="form-group">
        <label>Nama Kategori</label>
        {!! Form::text('nama', null, array('placeholder' => 'Nama Kategori','class' => 'form-control', 'maxlength' => '255')) !!}
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('kategori.index') }}">
            <button type="button" class="btn btn-danger">Batal</button>
        </a>
    </div>
</div>