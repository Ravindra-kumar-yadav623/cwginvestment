@extends('admin.admin-layout')

@section('content')
<div class="container">
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Deposit Management</h3>
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
                <a href="#">Deposits</a>
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
            <h4 class="card-title mb-0">All Deposits</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    id="basic-datatables"
                    class="display table table-striped table-hover align-middle">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>User</th>
                            <th>Amount (USDT)</th>
                            <th>Proof</th>
                            <th>Date Time</th>
                            <th>Status</th>
                            <th>Admin Remark</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deposits as $deposit)
                            <tr>
                                <td>
                                    <strong>{{ $deposit->user->name }}</strong><br>
                                    <small class="text-muted">{{ $deposit->user->email }}</small><br>
                                    <small class="text-muted">User Code: {{ $deposit->user->user_code }}</small>
                                </td>

                                <td>
                                    ${{ number_format($deposit->amount, 2) }}
                                </td>

                                <td>
                                    @if($deposit->proof_image)
                                        <a href="{{ asset('storage/' . $deposit->proof_image) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $deposit->proof_image) }}"
                                                 alt="Proof"
                                                 style="height:40px;width:auto;border-radius:4px;">
                                        </a>
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $deposit->created_at->format('d/m/Y, g:i a') }}
                                </td>

                                <td>
                                    @if($deposit->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($deposit->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($deposit->status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($deposit->status) }}</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $deposit->admin_remark ?: '-' }}
                                </td>

                                <td class="text-center">
                                    @if($deposit->status === 'pending')
                                        <button
                                            type="button"
                                            class="btn btn-success btn-sm mb-1 approve-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#approveModal"
                                            data-id="{{ $deposit->id }}"
                                            data-amount="{{ $deposit->amount }}"
                                            data-user="{{ $deposit->user->name }}"
                                        >
                                            Approve
                                        </button>

                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm reject-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rejectModal"
                                            data-id="{{ $deposit->id }}"
                                            data-amount="{{ $deposit->amount }}"
                                            data-user="{{ $deposit->user->name }}"
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
            <h5 class="modal-title" id="approveModalLabel">Approve Deposit</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>
                Are you sure you want to <strong>approve</strong> this deposit?
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
            <h5 class="modal-title" id="rejectModalLabel">Reject Deposit</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p>
                Are you sure you want to <strong>reject</strong> this deposit?
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
        // DataTable init (you already use this ID in your other page)
        if ($('#basic-datatables').length && $.fn.DataTable) {
            $('#basic-datatables').DataTable({
                pageLength: 10,
                order: [[3, 'desc']] // sort by Date Time desc
            });
        }

        // Base URLs from Laravel routes
        const approveBaseUrl = @json(url('/admin/deposits/approve'));
        const rejectBaseUrl  = @json(url('/admin/deposits/reject'));

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
