<div class="card-block">
  <div class="card-body">
    <h4 class="card-title">Select Category Level</h4>

          <select class="form-control" name="parent_id" id="parent_id">
            <option value="0" @if(isset($categorydata['parent_id']) && $categorydata['parent_id']==0) selected="" @endif>Select Option</option>
            @if(!empty($getCategories))
        @foreach($getCategories as $category)
            <option value="{{$category['id']}}" @if(isset($categorydata['parent_id'])&&$categorydata['parent_id']==$category['id']) selected="" @endif> {{$category['category_name']}}</option>
            @if(!empty($category['subcategories']))
              @foreach($category['subcategories'] as $subcategory)
                  <option value="{{$subcategory['id']}}">&nbsp;&raquo;&nbsp;{{$category['category_name']}}</option>
                  
              @endforeach
            @endif
        @endforeach
      @endif
          </select>    
  </div>
</div>