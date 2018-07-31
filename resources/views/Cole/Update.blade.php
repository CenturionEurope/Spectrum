@include('Cole.Globals.Header')
<div class="clearfix"></div>
<div class="wrapper-page Login">
    <div class="text-center">
        <a class="logo">
            <video width="240" autoplay muted>
                <source src="/Cole/Brand/ColeWelcomeSpin.m4v" type="video/mp4" />
            </video>
        </a>
    </div>

    <div class="SlickMe">
        <!-- Slide one -->
        <div class="card-box">
            <div class="panel-body">
                <div class="form-horizontal text-center">
                    <h1>Updating Cole...</h1>
                
                
                    <div class="form-group text-center m-t-30">
                        <div class="col-xs-12">	                            

                                
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" style="width: 0%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
    </div>



    <div class="row">
        <div class="col-sm-12 text-center">
            &copy; Cole {{ date('Y') }}
        </div>
    </div>
</div>
@include('Cole.Globals.Footer')