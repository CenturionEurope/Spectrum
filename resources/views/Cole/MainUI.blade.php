@include('Cole.Globals.Header')
@include('Cole.Globals.TopNav')
@include('Cole.Globals.SideNav')
<div class="content-page"></div>

<footer class="footer text-right">
	&copy; Cole CMS {{ date('Y') }} | <a href="/credits">Credits</a> <span>Version {{ $Cole->Settings->SystemVersion }}</span>
</footer>

@include('Cole.Globals.Footer')
