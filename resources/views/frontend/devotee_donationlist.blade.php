@extends('frontend.layouts.app')
@section('content')
    <div class="card">
        <h5 class="card-header">Donation details</h5>
        <div class="table-responsive text-nowrap">

            @if ($donations->count() != null)
                <table class="table">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Branch</th>
                            <th>Donation</th>
                            <th>Paid By</th>
                            <th>Status</th>
                            <th>Voucher</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php $i = ($donations->perPage() * ($donations->currentPage() - 1)) + 1;; @endphp
                        @foreach ($donations as $donation)
                            <tr>
                                <td>@php echo $i; @endphp</td>
                                <td>{{ $donation->getbranch->title }}</td>
                                <td>{{ $donation->donation }}</td>
                                <td>{{ $donation->donationtype }}</td>
                                <td>
                                    @if ($donation->status == 'Paid')
                                        <span class="badge bg-success bg-glow">Paid</span>
                                    @endif
                                    @if ($donation->status == 'Pending')
                                        <span class="badge bg-info bg-glow">Pending</span>
                                    @endif
                                    @if ($donation->status == 'Schedule')
                                        <span class="badge bg-secondary bg-glow">Schedule</span>
                                    @endif
                                    @if ($donation->status == 'Refund')
                                        <span class="badge bg-warning bg-glow">Refund</span>
                                    @endif
                                    @if ($donation->status == 'Cancelled')
                                        <span class="badge bg-danger bg-glow">Cancelled</span>
                                    @endif
                                </td>
                                <td>{{ $donation->voucher }}</td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-2">{!! $donations->links() !!}</div>
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
