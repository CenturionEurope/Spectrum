<pre>{{print_r($Cole)}}</pre>

@isset($Cole['SpecialMode'])
	@php
		$Content = $Cole['Data']['Content'];
		$RejiggedContent = array();
	@endphp
	@foreach($Content as $Item)
		@php
			$RejiggedContent[''.$Item.''] = '';
		@endphp
	@endforeach
	@php
		$Content = $RejiggedContent;
	@endphp
@else
	@php
		$Content = $Cole['Data']['Content'];
	@endphp
@endif


@foreach($Content as $Key => $Value)
<?php

// Check for a matching TVM DataPair
	$FoundMatchingTVM = false;

	if(!isset($Cole['Data']['TableViewMapper'])){
		$Cole['Data']['TableViewMapper'] = array(); // Fill with empty array if no TVMs
	}

	foreach($Cole['Data']['TableViewMapper'] as $TVMItem){
		if($TVMItem['ColName']==$Key){
			$FoundMatchingTVM = true;
			$MatchingTVM = $TVMItem;
		}
	}
	
	if($FoundMatchingTVM){ 
	
		$KeyName = $MatchingTVM['EnglishName'];
		$Show = $MatchingTVM['Show'];
		$Edit = $MatchingTVM['Edit'];
		
	
	}else{
		
		$KeyName = $Key;
		$Show = 1;
		$Edit = 1;
		$MatchingTVM = array(
			'isDate' => 0,
			'Currency' => 0,
			'isFlag' => 0,
			'IsBoolean' => 0,
			'isArray' => 0,
			'SaltedMD5' => 0,
			'isRTF' => 0,
			'isThumb' => 0,
			'MaxLength' => null,
			'isFile' => 0,
			'isImg' => 0,
			'isURL' => 0,
			'isTemplatePicker' => 0
		);
		
	}
	
	if($Edit==1){	
	?>
	<div class="m-t-20 form-group">
	<label>{!! $KeyName !!}</label>
	<?php
		
		if(isset($MatchingTVM['MaxLength'])){
			echo '<span class="MaxLength">'.$MatchingTVM['MaxLength'].'</span>';
		}
				
		if($MatchingTVM['isDate']==1){
			
			if (strpos($Value, ':') !== false) {
				$DateFormat = str_replace(' ','T',date("Y-m-d H:i", strtotime($Value)));
				echo '<input autocomplete="off" data-lpignore="true" class="form-control" id="'.$Key.'" type="datetime-local" placeholder="'.$KeyName.'" value="'.$DateFormat.'">';				
			}else{
				echo '<input autocomplete="off" data-lpignore="true" class="form-control" id="'.$Key.'" type="date" placeholder="'.$KeyName.'" value="'.$Value.'">';
			}
			
		}else if($MatchingTVM['Currency']==1){
			echo '<input autocomplete="off" data-lpignore="true" id="'.$Key.'" type="number" step="any" min="1" placeholder="'.$KeyName.'" value="'.number_format($Value,2).'">';
		}else if($MatchingTVM['IsBoolean']==1){
			echo '<select class="form-control" id="'.$Key.'">';
				echo '<option value="1"'; if($Value==1){echo ' selected';} echo '>Yes</option>';
				echo '<option value="0"'; if($Value==0){echo ' selected';} echo '>No</option>';					
			echo '</select>';
		}else if($MatchingTVM['isFlag']==1){
			$DecoderPlugin = $MatchingTVM['FlagDecoderPlugin'];
			echo app($Cole['ModuleData']->Controller)->$DecoderPlugin($Value,true);				
		}else if($MatchingTVM['isArray']==1){
			$DecoderPlugin = $MatchingTVM['ArrayDecoderPlugin'];
			$Value = json_decode($Value); // Turn JSON into an array
			$Value = (array)$Value; // Convert to an array over object
			$Array = app($Cole['ModuleData']->Controller)->$DecoderPlugin($Value,true);
			echo $Array; // Echo formatted array onto page
		}else if($MatchingTVM['SaltedMD5']==1){
			echo '<input autocomplete="off" data-lpignore="true" class="form-control" id="'.$Key.'" type="password" placeholder="'.$KeyName.'">';
		}else if($MatchingTVM['isThumb']==1){
			echo '<img class="ColeConstructThumbnailEdit" onerror="$(this).remove();" src="'.$Value.'" />';
		}else if($MatchingTVM['isRTF']==1){
			echo '<textarea class="ColeRichText" id="'.$Key.'">'.$Value.'</textarea>';
		}else if($MatchingTVM['isImg']==1){
		?>
			<div class="TreeContainer">
				<div class="col-xs-6">
				<div id="ajaxTree"></div>
				</div>
				<div class="col-xs-6">
					<img/>
				</div>
				<input type="hidden" class="Url" id="{{$Key}}" value="{{$Value}}" />				
			</div>
		<?php
		}else if($MatchingTVM['isURL']==1){
			echo '<input autocomplete="off" data-lpignore="true" class="form-control isURL" id="'.$Key.'" type="text" placeholder="'.$KeyName.'" value="'.$Value.'">';
		}else if($MatchingTVM['isTemplatePicker']==1){
			echo '<select class="form-control" id="'.$Key.'">';
				foreach(app('App\Http\Controllers\ColeControllers\PagesController')->PageTemplates() as $Template){
					echo '<option value="'.$Template->Template.'"'; if($Value==$Template->Template){echo ' selected';} echo '>'.$Template->Template.'</option>';
				}
			echo '</select>';		
		}else{
			echo '<input autocomplete="off" data-lpignore="true" class="form-control" id="'.$Key.'" type="text" placeholder="'.$KeyName.'" value="'.$Value.'" ';
			
			if(isset($MatchingTVM['MaxLength'])){echo 'maxlength="'.$MatchingTVM['MaxLength'].'"';}
			
			echo '>';
		}
	?>
	</div>
	<?php
		}// /edit
?>
@endforeach
@if($Cole['Data']['ModuleCodename']=="me")	
	@include('Prebuilt.ProfilePicture')
	@include('Prebuilt.Permissions')
@endif