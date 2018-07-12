
@include('Globals.Notifications')
</div>

     </div>
        <!-- END wrapper -->



        <!-- jQuery  -->
        <script src="/Cole/Javascript/Plugins/jquery.js"></script>
        <script src="/Cole/Javascript/Plugins/jquery-ui.min.js"></script>
        
		<!-- Cole Plugins -->        
        <script src="/Cole/Javascript/Plugins/Cookie.js"></script>
        <script src="/Cole/Javascript/Plugins/nouislider.min.js"></script>
        <script src="/Cole/Javascript/Plugins/bootstrap.min.js"></script>
        <script src="/Cole/Javascript/Plugins/morris.min.js"></script>
        <script src="/Cole/Javascript/Plugins/raphael-min.js"></script>
        <script src="/Cole/Javascript/Plugins/SweetAlert/sweetalert2.all.js"></script>
        <script src="/Cole/Javascript/Plugins/datatables.js"></script>
        <script src="/Cole/Javascript/Plugins/RichText/trumbowyg.min.js"></script>
		<script src="/Cole/Javascript/Plugins/jstree.min.js"></script>

		<!-- Cole JS -->
		<script src="/Cole/Javascript/core.cole.js?rand={{ time() }}"></script>
		 
		 @isset($Cole->User)
			@if(!empty($Cole->Settings->Timeout))
				@include('Prebuilt.Timeout')
			@endif
		 @endisset
       
		 @isset($Cole->PageReference)
		 	@if($Cole->PageReference=="install")
				<script src="/Cole/Javascript/Plugins/Slick/slick.min.js"></script>				 
				<script src="/Cole/Javascript/install.cole.js?rand={{ time() }}"></script>				 
		 	@endif
		 	@if($Cole->PageReference=="update")
 				<script src="/Cole/Javascript/update.cole.js?rand={{ time() }}"></script>
		 	@endif
		 @endisset

		 @isset($Cole->User)
			<input type="text" class="Cole" id="ColeUserEmail" value="{{$Cole->User->Email}}" style="display:none;" />
			<input type="hidden" class="Cole FEUrl" value="{{$Cole->Settings->SiteURL}}" />
		 @endisset

		 

    </body>
</html>