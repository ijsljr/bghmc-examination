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

@if (Session::has('warning'))
<div class="alert alert-warning alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>{{ session('warning') }}</strong>
  </div>
@endif