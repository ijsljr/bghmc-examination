<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('home') }}">BGHMC</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admissions.index') }}">ADMISSIONS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('patients.index') }}">PATIENTS</a>
              </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('wards.index') }}">WARDS</a>
              </li>
          </ul>
        </div>
      </nav>
</div>