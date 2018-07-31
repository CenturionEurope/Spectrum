<!-- Right Sidebar -->
<div class="side-bar right-bar">
	<a href="javascript:void(0);" class="right-bar-toggle">
		<i class="zmdi zmdi-close-circle-o"></i>
	</a>
	<h4>Notifications</h4>
	<div class="notification-list nicescroll">
		<ul class="list-group list-no-border user-list">
			@isset($Cole->NotificationsList)
				@foreach($Cole->NotificationsList as $Notification)		
				<li class="list-group-item">
					<a href="#" class="user-list-item" onclick="$('ul.Modules li a[data-module={{$Notification->Module->Codename}}]').click();$('#wrapper').removeClass('right-bar-enabled');">
						<div class="icon bg-primary">
							<i class="zmdi {{$Notification->Module->Icon}}"></i>
						</div>
						<div class="user-desc">
							<span class="name">{{$Notification->Module->ModuleName}}</span>
							<span class="desc">{{$Notification->Notification}}</span>
							<span class="time">{{$Notification->Date}}</span>
						</div>
					</a>
				</li>
				@endforeach
				@if(count($Cole->NotificationsList)==0)
					<li class="list-group-item NoNotifications">
						<i class="zmdi zmdi-notifications"></i>
						<span>You don&apos;t have any notifications</span>
					</li>
				@endif
			@endisset
		</ul>
	</div>
</div>
<!-- /Right-bar -->
