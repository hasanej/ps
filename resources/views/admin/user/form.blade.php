<div class="box-body">
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label>Nama</label>
        {!! Form::text('name', null, array('class' => 'form-control', 'maxlength' => '255')) !!}
    </div>
    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
        <label>Username</label>
        {!! Form::text('username', null, array('class' => 'form-control', 'maxlength' => '255')) !!}
    </div>
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label>Alamat E-Mail</label>
        {!! Form::text('email', null, array('type' => 'email', 'class' => 'form-control', 'maxlength' => '255')) !!}
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label>Password</label>
        {!! Form::password('password', array('class' => 'form-control', 'maxlength' => '255')) !!}
    </div>
    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label>Konfirmasi Password</label>
        {!! Form::password('password_confirmation', array('class' => 'form-control', 'maxlength' => '255')) !!}
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('user.index') }}">
            <button type="button" class="btn btn-danger">Batal</button>
        </a>
    </div>
</div>