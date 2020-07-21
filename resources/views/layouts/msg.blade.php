@if ($errors->any())
    @if(is_array($errors->all())&&count($errors->all())>0)
        <div class="alert alert-danger">
            <button type="button" aria-hidden="true" class="close" onclick="this.parentElement.style.display='none'">×</button>
            <span>
              <ul style="list-style-type: none">
                @foreach ($errors->all() as $error)
                  @if(is_array($error)&&count($error)>0)
                    @foreach ($error as $erro)
                      <li>{{ $erro }}</li>
                    @endforeach
                  @else
                    <li>{{ $error }}</li>
                  @endif
                @endforeach

              </ul>
            </span>
        </div>

    @else
      <div class="alert alert-danger">
          <button type="button" aria-hidden="true" class="close" onclick="this.parentElement.style.display='none'">×</button>
          <span>
            <ul style="list-style-type: none">

                  <li>{{ $errors->all() }}</li>


            </ul>
          </span>
      </div>
    @endif

@endif


@if(session('successMsg'))
    <div class="alert alert-success">
        <button type="button" aria-hidden="true" class="close" onclick="this.parentElement.style.display='none'">×</button>
        <span>
                {{ session('successMsg') }}</span>
    </div>
@endif


@if(session('error'))
        <div class="alert alert-danger">
            <button type="button" aria-hidden="true" class="close" onclick="this.parentElement.style.display='none'">×</button>
            <span>
              {!! session('error') !!}
            </span>
        </div>
@endif
