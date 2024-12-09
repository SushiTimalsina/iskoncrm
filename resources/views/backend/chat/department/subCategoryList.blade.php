@foreach($subcategories as $subcategory)
<tr>
  <td></td>
  <td>— <a href="{{ route('department.show', $list->id)}}">{{$subcategory->title}}</a></td>
  <td>{{$subcategory->getbranch->title}}</td>
  <td>{{Helper::getdevoteeonservicedepartment($subcategory->id)->count()}}</td>
  <td>
    @if($list->status == 'Active') <span class="badge badge-light-success">Active</span> @endif
    @if($list->status == 'Draft') <span class="badge badge-light-info">Draft</span> @endif
  </td>
  <td class="text-end">
    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
    <i class="ki-outline ki-down fs-5 ms-1"></i></a>
    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
      @can('department-list')
      <div class="menu-item px-3">
        <a href="{{ route('department.show', $subcategory->id)}}" class="btn btn-light d-block"><i class="ki-outline ki-eye fs-2"></i> View</a>
      </div>
      @endcan
      @if (Route::currentRouteName() == 'departmenttrash')
      @can('department-delete')
      <div class="menu-item px-3">
        <a href="{{ route('departmentrestore', $subcategory->id)}}" class="btn btn-light d-block">Restore</a>
      </div>
      <div class="menu-item px-3">
        <form action="{{ route('department.destroy', $subcategory->id)}}" method="post">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-light d-block w-100" onclick="return confirm('Are you sure to delete this data?')" title="Delete">Permanently Delete</button>
        </form>
      </div>
      @endcan
      @else
      @can('department-edit')
      <div class="menu-item px-3">
        <a href="{{ route('department.edit', $subcategory->id)}}" class="btn btn-light d-block">Edit</a>
      </div>
      @endcan
      @can('department-delete')
      <div class="menu-item px-3">
        <a href="{{ route('departmentmovetotrash', $subcategory->id)}}" class="btn btn-light d-block">Trash</a>
      </div>
      @endcan
      @endif
    </div>
  </td>
</tr>
@if(count($subcategory->subcategory))
  @include('backend.department.subCategoryList',['subcategories' => $subcategory->subcategory])
@endif
@endforeach
