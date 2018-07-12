@include('Globals.Header')
@include('Globals.TopNav')
@include('Globals.SideNav')
<div class="content-page"></div>

<footer class="footer text-right">
	&copy; Cole CMS {{ date('Y') }} | <a href="/credits">Credits</a> <span>Version {{ $Cole->Settings->SystemVersion }}</span>
</footer>

@include('Globals.Footer')
