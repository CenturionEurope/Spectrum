<div class="content">
    <div class="container">
        <pre><?php print_r($Cole);?></pre>
        
        
        <div class="TableList">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <div class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">

                                <li><a href="#" class="CreateItem" data-module="<?php echo $Cole->Module->ModuleData->Codename; ?>"><i class="zmdi zmdi-file-plus"></i> Create</a></li>
                            </ul>
                        </div>                        
                        @include('Cole/Prebuilt/DatabaseTable')                       
                    </div>
                </div><!-- end col -->
            </div>
        </div>
        
        <div class="EditControls">
            <div class="row">
                <div class="col-sm-12">
                        <div class="card-box EditModule">
                        </div>
                    </div>
                </div>
            </div>
        
        
        
    </div>
        
</div> <!-- container -->