<?php
	if(isset($Cole['Data']['Content']['PermissionsLocked'])){
		if($Cole['Data']['Content']['PermissionsLocked']==1){
			$lockout = 'lockout';
		}
	}
?>
<label>Account permissions</label>
@isset($Cole['Data']['Content']['PermissionsLocked'])
    @if($Cole['Data']['Content']['PermissionsLocked']==1)
        <p>Sorry, Permissions have been locked for this user. Please contact your administrator to make alterations.</p>
    @else
        <p>To alter permissions for this user, Click the relative icons to enable the permission.</p>
    @endif
@endisset
    <table class="table table-striped table-bordered permissions {{$lockout or ''}}">
    @if(!isset($Cole['Data']['Plugin']['UserPermissions']))
        <tbody><td>Unable to adjust account permissions. If you are creating a new user please save changes first.</td></tbody>
    @else
        <thead>
            <tr>
                <td class="Corner"></td>
                <td data-permission="get"><i class="zmdi zmdi-eye"></i>Get</td>
                <td data-permission="create"><i class="zmdi zmdi-file-plus"></i>Create</td>
                <td data-permission="save"><i class="zmdi zmdi-check"></i>Save</td>
                <td data-permission="delete"><i class="zmdi zmdi-delete"></i>Delete</td>
            </tr>
        </thead>
        <tbody>
        @foreach($Cole['Data']['Plugin']['UserPermissions'] as $Key => $Permission)
            @if($Key!='today')
                <tr data-module="{{$Key}}">
                    <td class="Module"><i class="zmdi {{$Permission['ModuleInfo']['Icon']}}"></i> {{$Permission['ModuleInfo']['ModuleName']}}</td>
                    <td data-permission="get">
                        @if(in_array('get',$Permission['Permissions']))
                            <input type="checkbox" checked/>
                            <i class="zmdi zmdi-eye Active"></i>
                        @else
                            <input type="checkbox" />
                            <i class="zmdi zmdi-eye"></i>						
                        @endif
                    </td>
                    <td data-permission="create">
                        @if(in_array('create',$Permission['Permissions']))
                            <input type="checkbox" checked/>
                            <i class="zmdi zmdi-file-plus Active"></i>
                        @else
                            <input type="checkbox" />
                            <i class="zmdi zmdi-file-plus"></i>						
                        @endif						
                    </td>
                    <td data-permission="save">
                        @if(in_array('save',$Permission['Permissions']))
                            <input type="checkbox" checked/>
                            <i class="zmdi zmdi-check Active"></i>
                        @else
                            <input type="checkbox" />
                            <i class="zmdi zmdi-check"></i>						
                        @endif												
                    </td>
                    <td data-permission="delete">
                        @if(in_array('delete',$Permission['Permissions']))
                            <input type="checkbox" checked/>
                            <i class="zmdi zmdi-delete Active"></i>
                        @else
                            <input type="checkbox" />
                            <i class="zmdi zmdi-delete"></i>						
                        @endif						
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    @endif
</table>