@extends('admin.admin-layout')

@section('content')
<div class="container">
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Withdrawal Management</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Withdrawals</a>
            </li>
        </ul>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">All Withdrawals</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="basic-datatables"
                    class="display table table-striped table-hover align-middle">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>User</th>
                            <th>Amount ({{ $withdrawals->first()->currency ?? 'USDT' }})</th>
                            <th>Payout Method</th>
                            <th>Wallet Address</th>
                            <th>Date Time</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($withdrawals as $withdrawal)
                            @php
                                $details = is_array($withdrawal->payout_details)
                                    ? $withdrawal->payout_details
                                    : json_decode($withdrawal->payout_details ?? '[]', true);
                            @endphp
                            <tr>
                                {{-- User --}}
                                <td>
                                    <strong>{{ $withdrawal->user->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $withdrawal->user->email ?? '' }}</small><br>
                                    <small class="text-muted">User Code: {{ $withdrawal->user->user_code ?? '' }}</small>
                                </td>

                                {{-- Amount --}}
                                <td>
                                    ${{ number_format($withdrawal->amount, 2) }}
                                </td>

                                {{-- Payout Method --}}
                                <td>
                                    {{ $withdrawal->payout_method ?? 'N/A' }}
                                </td>

                                {{-- Wallet Address from JSON --}}
                                <td>
                                    {{ $details['wallet_address'] ?? '-' }}
                                </td>

                                {{-- Date --}}
                                <td>
                                    {{ $withdrawal->created_at->format('d/m/Y, g:i a') }}
                                </td>

                                {{-- Status --}}
                                <td>
                                    @if($withdrawal->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($withdrawal->status === 'processing')
                                        <span class="badge bg-info text-dark">Processing</span>
                                    @elseif($withdrawal->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($withdrawal->status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($withdrawal->status) }}</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="text-center">
                                    @if($withdrawal->status === 'pending' || $withdrawal->status === 'processing')
                                        <button
                                            type="button"
                                            class="btn btn-success btn-sm mb-1 approve-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#approveModal"
                                            data-id="{{ $withdrawal->id }}"
                                            data-amount="{{ $withdrawal->amount }}"
                                            data-user="{{ $withdrawal->user->name ?? 'N/A' }}"
                                        >
                                            Approve
                                        </button>

                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm reject-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rejectModal"
                                            data-id="{{ $withdrawal->id }}"
                                            data-amount="{{ $withdrawal->amount }}"
                                            data-user="{{ $withdrawal->user->name ?? 'N/A' }}"
                                        >
                                            Reject
                                        </button>
                                    @else
                                        <span class="text-muted">No actions</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> {{-- table-responsive --}}
        </div>
    </div>

</div>
</div>

{{-- APPROVE MODAL --}}
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" id="approveForm">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="approveModalLabel">Approve Withdrawal</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>
                Are you sure you want to <strong>approve</strong> this withdrawal?
            </p>
            <ul class="list-unstyled mb-0">
                <li><strong>User:</strong> <span id="approveUser"></span></li>
                <li><strong>Amount:</strong> $<span id="approveAmount"></span></li>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Yes, Approve</button>
          </div>
        </div>
    </form>
  </div>
</div>

{{-- REJECT MODAL --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" id="rejectForm">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="rejectModalLabel">Reject Withdrawal</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>
                Are you sure you want to <strong>reject</strong> this withdrawal?
            </p>
            <ul class="list-unstyled">
                <li><strong>User:</strong> <span id="rejectUser"></span></li>
                <li><strong>Amount:</strong> $<span id="rejectAmount"></span></li>
            </ul>

            <div class="mt-3">
                <label class="form-label">Reason (Admin Remark) <span class="text-danger">*</span></label>
                <textarea name="admin_remark" id="rejectRemark" rows="3" class="form-control" required
                          placeholder="Enter reason for rejection"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Yes, Reject</button>
          </div>
        </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // DataTable init (same as deposit page)
        if ($('#basic-datatables').length && $.fn.DataTable) {
            $('#basic-datatables').DataTable({
                pageLength: 10,
                order: [[4, 'desc']] // sort by Date Time (5th column)
            });
        }

        // Base URLs from Laravel routes (adjust if your routes differ)
        const approveBaseUrl = @json(url('/admin/withdrawals/approve'));
        const rejectBaseUrl  = @json(url('/admin/withdrawals/reject'));

        // Approve button click
        $('.approve-btn').on('click', function () {
            const id     = $(this).data('id');
            const amount = $(this).data('amount');
            const user   = $(this).data('user');

            $('#approveUser').text(user);
            $('#approveAmount').text(amount);

            $('#approveForm').attr('action', approveBaseUrl + '/' + id);
        });

        // Reject button click
        $('.reject-btn').on('click', function () {
            const id     = $(this).data('id');
            const amount = $(this).data('amount');
            const user   = $(this).data('user');

            $('#rejectUser').text(user);
            $('#rejectAmount').text(amount);
            $('#rejectRemark').val('');

            $('#rejectForm').attr('action', rejectBaseUrl + '/' + id);
        });
    });
</script>
@endpush
