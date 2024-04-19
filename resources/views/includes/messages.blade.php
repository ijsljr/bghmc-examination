@if (Session::has('success'))
<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>{{ session('success') }}</strong>
  </div>
@endif

@if (Session::has('danger'))
<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>{{ session('danger') }}</strong>
  </div>
@endif

@if ($message = Session::get('success-password'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert"><b class="fas fa-times-circle" style="color:red"></b></button>    
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert"><b class="fas fa-times-circle" style="color:red"></b></button>
    <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert"><b class="fas fa-times-circle" style="color:red"></b></button>
    <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
    <button type="button" class="close" data-dismiss="alert"><b class="fas fa-times-circle" style="color:red"></b></button>
    <strong>{{ $message }}</strong>
</div>
@endif


@if ($errors->any())
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert"><b class="fas fa-times-circle" style="color:red"></b></button>
    Please check the form below for errors
</div>
@endif

@if ($message = Session::get('delete'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert"><b class="fas fa-times-circle" style="color:red"></b></button>
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($message = Session::get('scanned'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert"><b class="fas fa-times-circle"></b></button>
    <strong>User has been scanned successfully.</strong>
</div>
@endif