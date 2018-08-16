<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Modules -->
        <div id="sidebar-menu">
            <ul class="Modules">
                <li>
                    <a href="#" class="waves-effect active" data-module="today" data-custom="false">
                        <i class="zmdi zmdi-sun"></i> <span> Today </span>
                    </a>
                </li>                
                @foreach($Cole->Modules as $Module)
                    @if(!$Module->DoNotLoad==1)
                        <li @if($Module->Custom==1) data-custom="true" @else data-custom="false" @endif @if($Module->Codename=="me") style="display:none;" @endif >
                            <a href="#" class="waves-effect" data-module="{{ $Module->Codename }}">
                                <i class="zmdi {{ $Module->Icon }}"></i> <span>{{ $Module->ModuleName}}</span>                        
                                @php
                                    $ModuleCodename = $Module->Codename;
                                @endphp
                                @isset($Cole->Notifications->Notifications->$ModuleCodename)
                                    <span class="label label-primary pull-right">{{$Cole->Notifications->Notifications->$ModuleCodename->Count}}</span>
                                @endisset
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <div class="clearfix"></div>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->