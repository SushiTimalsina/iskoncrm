@foreach($subcategories as $subcategory)
<option value="{{$subcategory->id}}">— {{$subcategory->title}}</option>
@if(count($subcategory->subcategory))
  @include('attendsewa.subdepartment',['subcategories' => $subcategory->subcategory])
@endif
@endforeach
