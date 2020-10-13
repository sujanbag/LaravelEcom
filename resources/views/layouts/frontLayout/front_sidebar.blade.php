<?php
use App\Section;
$sections=Section::sections();
?>
<div class="left-sidebar">
    <h2>Category</h2>
    
    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
        
        @foreach($sections as $section)
        @if(count($section['categories'])>0)
        <div style="padding-left: 10px; font-size:20px;"><a  data-toggle = "collapse" href = "#test">{{$section['name']}} <span class="badge pull-right"><i class="fa fa-plus"></i></span></a></div>
        <div id = "test" class="panel panel-default panel-collapse collapse">
            
            @foreach($categories as $cat)
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a  data-toggle="collapse" data-parent="#accordian" href="#{{$cat->id}}">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            &nbsp; &nbsp; {{$cat->category_name}}
                        </a>
                    </h4>
                </div>
                
                @if(count($cat->categories)>0)
                <div id="{{$cat->id}}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            
                            @foreach($cat->categories as $subcat)
                            <li><a href="{{asset('/products/'.$subcat->url)}}">&nbsp; &nbsp; &nbsp; &nbsp;{{$subcat->category_name}}</a></li>
                            @endforeach
                            
                        </ul>
                    </div>
                </div>
                @endif
               
            @endforeach
            
        </div>
        <br>
        @endif
        @endforeach
    </div><!--/category-products-->
    

</div>