@isset($Cole['Data']['Content']['id'])
    @if($Cole['Data']['Content']['id'] == app('App\Http\Controllers\Cole\ColeController')->AccountDetails()->id)
        <label>My account Profile Picture</label>

        <div class="ProfileContainerMain">
            <div class="ProfileContainer">
                <a href="https://gravatar.com" target="_blank">
                    <i class="zmdi zmdi-edit"></i>
                </a>
                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower($Cole['Data']['Content']['Email'])) }}?s=200" alt="user-img" title="{{ $Cole['Data']['Content']['FullName'] }} " class="img-circle" />
            </div>  
        </div>
        
    @endif
@endisset