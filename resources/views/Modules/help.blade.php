<div class="content">
    <div class="container">
    <pre><?php print_r($Cole);?></pre>
       

    <div class="TableList">
        <div class="row">
            <div class="col-sm-12">
                
                
                <div class="card-box helpModule">
                   
                    
                    <div class="Index">
                        <i class="zmdi zmdi-help Headline"></i>
                        <h1 class="Intro">Welcome to Cole Help</h1>
                        <p class="Intro">Cole Help offers easy to follow guides that allow you to get the most out of your Cole System.</p>
                        <p class="Intro">To begin, Review the categories below and click a topic. Topics are rated in difficulty out of 3 stars, with 3 being the most difficult.</p>
                        
                        <div class="Categories">
                            @foreach($Cole->Module->ModuleContent->Plugin as $Item)
                            <div class="col-xs-12 col-sm-3 Category">    
                                <h2>{{ $Item->Category->Title }}</h2>
                                <ul>
                                    @foreach($Item->Data as $Article)
                                        <li data-template="{{ $Article->Template }}" data-title="{{ $Article->Title }}" data-score="{{$Article->Score}}">
                                            <i class="zmdi {{ $Article->Icon }}"></i> {{ $Article->Title }}
                                            <span class="Score" data-score="score{{$Article->Score}}">
                                                @if($Article->Score>=1)
                                                    <i class="zmdi zmdi-star"></i>
                                                @endif
                                                @if($Article->Score>=2)
                                                    <i class="zmdi zmdi-star"></i>
                                                @endif
                                                @if($Article->Score==3)
                                                    <i class="zmdi zmdi-star"></i>
                                                @endif
                                            </span>
                                        </li>
                                    @endforeach        
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="Content">
                        <div class="Title">
                            <h1 class="Left"></h1>
                            <h1 class="Right"></h1>
                        </div>
                        <div class="Body"></div>
                    </div>

                    <div class="btn btn-warning ColeCancelTrigger"><i class="zmdi zmdi-close"></i> Back to Today</div>
                    
                </div>

                
                
                
            </div><!-- end col -->
        </div>
    </div>
</div> <!-- container -->