<div class="box-body">
    <div class="form-group">
        <label>Judul</label>
        {!! Form::text('judul', null, array('placeholder' => 'Judul','class' => 'form-control', 'maxlength' => '255')) !!}
    </div>
    <div class="form-group">
        @if(!empty($data->gambar))
            <label>Gambar</label><br>
            <img src="{{ asset('upload/gambar_artikel/'.$data->gambar) }}" alt="Tidak ada gambar"><br><br>
        @endif
        <label><i class="fa fa-picture-o"></i> Input Gambar</label>
        {!! Form::file('gambar') !!}
        <p class="help-block">Format yang didukung : jpeg, png, bmp, gif, svg<br>Ukuran gambar maksimal : 2MB</p>
    </div>
    <div class="form-group">
        <label>Status</label><br>
        {!! Form::radio('status', '1', true) !!} Terbit &emsp;
        {!! Form::radio('status', '0') !!} Tidak Terbit
    </div>
    <div class="form-group">
        <label>Kategori</label>
        {!! Form::select('id_kategori', $kategori, null, ['class' => 'form-control']) !!}
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
            {!! Form::textarea('konten', null, array('placeholder' => 'Konten', 'id' => 'ckeditor')) !!}
        </div>
    </div>
    <div class="form-group">
        <label>Input File</label>
        <input type="file" name="file[]" multiple>
        <p class="help-block">(Supported format : .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf)</p>
        @if(!empty($daftarFile))            
            <label>Daftar File</label>
            @foreach($daftarFile as $x)
                <p>{{ $x->file }}</p>
            @endforeach
        @endif
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('artikel.index') }}">
            <button type="button" class="btn btn-danger">Batal</button>
        </a>
    </div>
</div>