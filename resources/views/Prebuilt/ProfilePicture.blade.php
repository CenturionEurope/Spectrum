@isset($Cole['Data']['Content']['id'])
    @if($Cole['Data']['Content']['id'] == app('App\Http\Controllers\ColeController')->AccountDetails()->id)
        <label>Set profile picture</label>
        <div class="ProfilePictures">
            
            @php
                $Images = scandir('Cole/Images/ProfilePictures');
                $Images = array_diff($Images, array('.','..','.DS_Store'));
                $Images = array_values($Images);
            @endphp
            
            <img class="New" src="Cole/Images/New.png" />
            @if($Cole['Data']['Content']['FacebookID']!=0)
                <img class="Facebook" src="https://graph.facebook.com/{{ $Cole['Data']['Content']['FacebookID'] }}/picture?width=1000&height=1000" />
            @endif
            
            @if(file_exists('Storage/ProfilePictures/'.$Cole['Data']['Content']['id'].'_ProfilePicture.jpg'))
                <img class="Facebook" src="/Storage/ProfilePictures/{{ $Cole['Data']['Content']['id'] }}_ProfilePicture.jpg" />
            @endif
            

            @foreach($Images as $Image)
                <img src="Cole/Images/ProfilePictures/{{ $Image }}" />
            @endforeach
            
        </div>
        <p><small>To upload a custom profile picture, Select the Plus icon. For best results, upload an image that is the same dimensions in width and height</small></p>

        <form id="ColeUpload" action="/api/me/profilepicture/upload" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" accept="image/jpeg">
            <input type="submit" name="submit">
        </form>
    @endif
@endisset