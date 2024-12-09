@foreach($subcategories as $subcategory)
<option value="{{$subcategory->id}}" {{ $edit->occupations == $subcategory->id ? 'selected' : '' }}>— {{$subcategory->title}}</option>
@if(count($subcategory->subcategory))
  @include('devotees.suboccupation',['subcategories' => $subcategory->subcategory])
@endif
@endforeach
