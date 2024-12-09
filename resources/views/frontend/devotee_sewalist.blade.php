@extends('frontend.layouts.app')
@section('content')
    <div class="card">
        <h5 class="card-header">Sewa details</h5>
        <div class="table-responsive text-nowrap">

            @if ($attendsewas->count() != null)
                <table class="table">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Branch</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $i = $attendsewas->perPage() * ($attendsewas->currentPage() - 1) + 1; ?>
                        @foreach ($attendsewas as $attendsewa)
                            <tr>
                                <td>
                                    <span class="fw-medium">{{ $i }}</span>
                                </td>
                                <td>{{ $attendsewa->getbranch->title }}</td>
                                <td>{{ $attendsewa->getdepartment->title }}</td>
                                <td>{{ $attendsewa->designation }}</td>
                                <td>{{ $attendsewa->date }}</td>

                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-2">{!! $attendsewas->links() !!}</div>
            @else
                <div class="demo-spacing-0">
                    <div class="alert alert-primary" role="alert">
                        <div class="alert-body">No Sewa Found!</div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
