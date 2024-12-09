@foreach($subcategories as $subcategory)
<tr>
  <td></td>
  <td class="aligncenter">
    @if($subcategory->image != NULL)<a href="{{ route('coursephoto.show', ['imageName' => $subcategory->image]) }}" data-fancybox="gallery"><img src="{{ route('coursephoto.show', ['imageName' => $subcategory->image]) }}" alt="image" width="50" /></a>@endif
  </td>
  <td>- {{$subcategory->title}}</td>
  <td>{{$subcategory->getbranch->title}}</td>
  <td>
    @if(Helper::getfacilitatorbycourseid($subcategory->id)->count() != NULL)
    <ul>
      @foreach(Helper::getfacilitatorbycourseid($subcategory->id) as $facilitator)
        <li>{{$facilitator->name}}</li>
      @endforeach
    </ul>
    @endif
  </td>
  <td>
    @if($subcategory->status == 'Active') <span class="badge badge-light-success">Active</span> @endif
    @if($subcategory->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
  </td>
  <td class="text-end">
    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
    <i class="ki-outline ki-down fs-5 ms-1"></i></a>
    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
      @if (Route::currentRouteName() == 'coursetrash')
      @can('course-delete')
      <div class="menu-item px-3">
        <a href="{{ route('courserestore', $subcategory->id)}}" class="btn btn-light d-block">Restore</a>
      </div>
      <div class="menu-item px-3">
        <form action="{{ route('courses.destroy', $subcategory->id)}}" method="post">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete">Permanently Delete</button>
        </form>
      </div>
      @endcan
      @else
      @can('course-edit')
      <div class="menu-item px-3">
        <a href="{{ route('courses.edit', $subcategory->id)}}" class="btn btn-light d-block">Edit</a>
      </div>
      @endcan
      @can('course-delete')
      <div class="menu-item px-3">
        <a href="{{ route('coursemovetotrash', $subcategory->id)}}" class="btn btn-light d-block">Trash</a>
      </div>
      @endcan
      @endif
    </div>
  </td>
</tr>
@if(count($subcategory->subcategory))
  @include('backend.courses.subCategoryList',['subcategories' => $subcategory->subcategory])
@endif
@endforeach
