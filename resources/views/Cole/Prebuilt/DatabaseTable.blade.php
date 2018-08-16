<table id="datatable" class="Datatable <?php if(count((array)$Cole->Module->ModuleContent->Content)==0){echo 'NoContent';} ?> table table-striped table-bordered">
<?php
	if(count((array)$Cole->Module->ModuleContent->Content)!=0){
?>
    <thead>
        <tr>
        @php
			$HeaderData = (array)$Cole->Module->ModuleContent->Content;
			$HeaderData = (array)$HeaderData[0];
        @endphp


        	@foreach($HeaderData as $Heading => $Value)
	        	@php
		            $ShowCol = true;
	        	@endphp

				@foreach((array)$Cole->Module->ModuleTableViewMapper as $Mapper)
					@if($Heading==$Mapper->ColName)
						@php
							$Heading = $Mapper->EnglishName;
			                $FoundTVM = true;
			            @endphp

			            @if($Mapper->Show==1)
			            	@php
			            		$ShowCol = true;
			            	@endphp
			            @elseif($Mapper->Show==0)
			            	@php
				            	$ShowCol = false;
			            	@endphp
			            @endif

						@php
			                $isArray = $Mapper->isArray;
						@endphp

					@endif
				@endforeach
				@if(!isset($ShowCol))
					@php
						$ShowCol = true;
					@endphp
				@endif
				@if($ShowCol)
					@php
	                if(!empty($Heading)){
		                if(!isset($isArray)){
			                $isArray = false; // define as false if not set
		                }
		                if(!$isArray){ // hide col if an array
           					@endphp
	           					<th>{!! $Heading !!}</th>
	           				@php
						}
            		}
					@endphp
				@endif

            @endforeach


            <th>
	            Manage
            </th>
        </tr>
    </thead>
<?php
	}else{
?>
    <thead>
	    <tr></tr>
    </thead>
<?php		
	}
?>


    <tbody>

@if((array)$Cole->Module->ModuleContent->Content)
	@php
		$DataPackages = $Cole->Module->ModuleContent->Content;
	@endphp

	<?php

        foreach($DataPackages as $DataPackage){
	?>
		<tr>
	<?php
        foreach($DataPackage as $Key => $Value){

	    $ModuleTableViewMapper = (array)$Cole->Module->ModuleTableViewMapper;
	    unset($MatchedRow);
	    foreach($ModuleTableViewMapper as $Mapper){
		  $ShowCol = true;
		  	if($Mapper->ColName==$Key){

			  	$MatchedRow = $Mapper;

			}

	    }

	    if(!isset($MatchedRow)){
		    $MatchedRow = (object)array();
		    $ShowCol = true;
	    }else{
		    if($MatchedRow->Show==1){
			    $ShowCol = true;
		    }else{
			    $ShowCol = false;
		    }
	    }


	    // Boolean conversion
	    if(isset($MatchedRow->IsBoolean)){
	    	if($MatchedRow->IsBoolean==1){
		    	if($Value==1){
			    	$Value = 'Yes';
		    	}else if($Value==0){
			    	$Value = 'No';
		    	}
	    	}
	    }

	     // Currency conversion
	    if(isset($MatchedRow->Currency)){
	    	if($MatchedRow->Currency==1){
		    	$Value = '&pound;'.number_format($Value,2);
	    	}
	    }

	     // Date conversion
	    if(isset($MatchedRow->isDate)){
	    	if($MatchedRow->isDate==1){
		    	$Value = date("d/m/Y", strtotime($Value));
		    	if($Value=="30/11/-0001"){
			    	$Value = 'Date not set';
		    	}
	    	}
	    }

	    // Thumb conversion
	    if(isset($MatchedRow->isThumb)){
	    	if($MatchedRow->isThumb==1){
		    	$Value = '<img src="'.$Value.'" class="ColeConstructThumbnail" onerror="$(this).remove();" />';
	    	}
	    }



	    // Flag conversion
	    if(!empty($MatchedRow->isFlag)){
		    $FlagDecoderPlugin = $MatchedRow->FlagDecoderPlugin;
		    $Controller = $Cole->Module->ModuleData->Controller;
			if(method_exists($Controller, $FlagDecoderPlugin)){
				$Value = app($Controller)->$FlagDecoderPlugin($Value);
			}
	    }






	        if($ShowCol){

		        if($Key=="Url"){
			        $PageURL = $Value;
		        }

    	?>
    			<td data-key="{{ $Key }}">{!! $Value !!}</td>
		<?php
			}
        }

        ?>


        	<td data-itemid="<?php echo $DataPackage->id; ?>" data-module="<?php echo $Cole->Module->ModuleData->Codename; ?>" style="width:120px;">

    			    @if($Cole->Module->ModuleData->Codename=="pages")
    					<div class="btn btn-warning btn-xs ColeModuleTrigger" data-control="pagemanage" onclick="window.open('{{ $Cole->Settings->SiteURL }}/<?php if($PageURL!='/'){ echo $PageURL; } ?>?ColeEdit={{ $Cole->User->Secret }}&Affector={{ $Cole->User->id }}');">
    						<i class="zmdi zmdi-file-text"></i>
    					</div>
						<div class="btn btn-info btn-xs ColeModuleTrigger" data-control="pagevisit" onclick="window.open('{{ $Cole->Settings->SiteURL }}/<?php if($PageURL!='/'){ echo $PageURL; } ?>');">
    						<i class="zmdi zmdi-eye"></i>
    					</div>
						
    				@endif

    	    	<div class="btn btn-success btn-xs ColeModuleTrigger" data-control="edit">
    		    	<i class="zmdi zmdi-edit"></i>
    		    </div>
    	    	<div class="btn btn-danger btn-xs ColeModuleTrigger" data-control="delete">
    		    	<i class="zmdi zmdi-delete"></i>
    		    </div>

        	</td>

    		</tr>


        <?php
        }
    ?>





@else
	<td style="text-align: center;">No items exist</td>
@endif



    </tbody>
</table>
