<!-- @extends('admin.layout')

@section('content')
<div class="container">
    <div class="page-inner">

        <div class="d-flex flex-md-row flex-column align-items-md-center pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-2">Welcome, {{ $user->name }}</h3>
                <h6 class="op-7 mb-2">Capital Wealth Growth</h6>
            </div>

            <div class="ms-md-auto">
                <div class="input-group mb-3">
                    <input type="text" class="form-control"
                        id="refLink"
                        value="{{ $referralLink }}"
                        readonly>
                    <button class="input-group-text btn-primary"
                        onclick="navigator.clipboard.writeText(document.getElementById('refLink').value)">
                        Copy Referral Link
                    </button>
                </div>
            </div>

            <div class="ms-md-auto">
                <a href="{{ route('deposit.create') }}" class="btn btn-primary">Deposit</a>
            </div>
        </div>

        {{-- Wallet Summary --}}
        <div class="row">
            <div class="col-md-3">
                <div class="card card-round card-stats">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <p class="card-category">Income Wallet</p>
                            <h4>${{ number_format($incomeWallet, 2) }}</h4>
                        </div>
                        <i class="fas fa-wallet fa-2x text-success"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-round card-stats">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <p class="card-category">Pocket Wallet</p>
                            <h4>${{ number_format($pocketWallet, 2) }}</h4>
                        </div>
                        <i class="fas fa-briefcase fa-2x text-info"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-round card-stats">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <p class="card-category">Total Income</p>
                            <h4>${{ number_format($totalIncome, 2) }}</h4>
                        </div>
                        <i class="fas fa-chart-line fa-2x text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-round card-stats">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <p class="card-category">Total Withdrawal</p>
                            <h4>${{ number_format($totalWithdrawal, 2) }}</h4>
                        </div>
                        <i class="fas fa-money-bill-wave fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Info --}}
        <div class="card mt-4">
            <div class="card-header"><h4>User Info</h4></div>
            <div class="card-body">
                <table class="table">
                    <tr><td>User Code</td><td>{{ $user->user_code }}</td></tr>
                    <tr><td>Status</td><td>{{ ucfirst($user->status) }}</td></tr>
                    <tr><td>Country</td><td>{{ $user->country }}</td></tr>
                    <tr><td>Registered</td><td>{{ $user->created_at->format('d/m/Y h:i A') }}</td></tr>
                </table>
            </div>
        </div>

        {{-- Business --}}
        <div class="card mt-4">
            <div class="card-header"><h4>Network / Business</h4></div>
            <div class="card-body">
                <table class="table">
                    <tr><td>Direct Team</td><td>{{ $directTeamCount }}</td></tr>
                    <tr>
                        <td>Current Business (L/R)</td>
                        <td>${{ $leftRightBusiness['left'] }}/ ${{ $leftRightBusiness['right'] }}</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection -->

@extends('admin.layout')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div>
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <h6 class="op-7 mb-2">Capital Wealth Growth</h6>
      </div>

      {{-- Referral link --}}
      <div class="ms-md-auto py-2 py-md-0">
        <div class="d-flex mb-3">
          <div class="input-group mb-3 input-primary">
            <input type="text" id="refLink"
                   value="{{ $referralLink }}"
                   class="form-control" readonly>
            <a onclick="navigator.clipboard.writeText(document.getElementById('refLink').value)"
               class="input-group-text">Copy Referral Link</a>
          </div>
        </div>
      </div>

      <div class="ms-md-auto py-2 py-md-0">
        <a href="{{ route('deposit.create') }}" class="btn btn-primary btn-round">Deposit</a>
      </div>
    </div>

    {{-- Top cards --}}
    <div class="row">
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-primary bubble-shadow-small">
                  <i class="fas fa-wallet"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Income Wallet</p>
                  <h4 class="card-title">${{ number_format($incomeWallet, 2) }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-info bubble-shadow-small">
                  <i class="fas fa-briefcase"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Pocket Wallet</p>
                  <h4 class="card-title">${{ number_format($pocketWallet, 2) }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-success bubble-shadow-small">
                  <i class="fas fa-chart-line"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Total Income</p>
                  <h4 class="card-title">${{ number_format($totalIncome, 2) }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                  <i class="far fa-money-bill-alt"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Total Withdrawal</p>
                  <h4 class="card-title">${{ number_format($totalWithdrawal, 2) }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- USER INFO CARD --}}
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{ $user->name }}</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <tr>
                <td>Member Id</td>
                <td>{{ $user->user_code }}</td>
              </tr>
              <tr>
                <td>Active Status</td>
                <td>{{ ucfirst($user->status) }}</td>
              </tr>
              {{-- 🔹 CWG Investment (added after status) --}}
              <tr>
                <td>CWG Investment</td>
                <td>${{ number_format($cwgInvestment, 2) }}</td>
              </tr>
              <tr>
                <td>Country</td>
                <td>{{ $user->country }}</td>
              </tr>
              <tr>
                <td>Registered Date</td>
                <td>{{ $user->created_at->format('d/m/Y h:i:s A') }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- BUSINESS DETAILS CARD --}}
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Business Details</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <tr>
                <td>Direct Team</td>
                <td>{{ $directTeamCount }}</td>
              </tr>
              <tr>
                <td>CWG Investment Business</td>
                <td>${{ number_format($leftBusiness + $rightBusiness, 2) }}</td>
              </tr>
              <tr>
                <td>Current CWG Investment (Left/Right)</td>
                <td>${{ number_format($leftBusiness, 2) }} / ${{ number_format($rightBusiness, 2) }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- REFER & EARN CHART --}}
    <div class="col-md-12">
      <div class="card card-round">
        <div class="card-header">
          <h4 class="card-title">Refer &amp; Earn Overview</h4>
          <p class="card-category">Direct signups in last 6 months</p>
        </div>
        <div class="card-body">
          <canvas id="referChart" height="100"></canvas>
        </div>
      </div>
    </div>

    {{-- NETWORK TREE VIEW --}}
    <div class="col-md-12">
      <div class="card card-round">
        <div class="card-header">
          <h4 class="card-title">Network Tree (Binary View)</h4>
          <p class="card-category">Immediate downline under you</p>
        </div>
        <div class="card-body">
          <div class="row">
            {{-- LEFT TEAM --}}
            <div class="col-md-6">
              <h5>Left Team</h5>
              @if($leftDownline->isEmpty())
                <p class="text-muted">No members on left side.</p>
              @else
                <ul class="list-group">
                  @foreach($leftDownline as $node)
                    <li class="list-group-item d-flex justify-content-between">
                      <div>
                        <strong>{{ $node->user->name ?? 'N/A' }}</strong><br>
                        <small>ID: {{ $node->user->user_code ?? '' }}</small><br>
                        <small>Status: {{ ucfirst($node->user->status ?? '') }}</small>
                      </div>
                      <div class="text-end">
                        <small>Level: {{ $node->level }}</small><br>
                        <small>Position: {{ ucfirst($node->position) }}</small>
                      </div>
                    </li>
                  @endforeach
                </ul>
              @endif
            </div>

            {{-- RIGHT TEAM --}}
            <div class="col-md-6">
              <h5>Right Team</h5>
              @if($rightDownline->isEmpty())
                <p class="text-muted">No members on right side.</p>
              @else
                <ul class="list-group">
                  @foreach($rightDownline as $node)
                    <li class="list-group-item d-flex justify-content-between">
                      <div>
                        <strong>{{ $node->user->name ?? 'N/A' }}</strong><br>
                        <small>ID: {{ $node->user->user_code ?? '' }}</small><br>
                        <small>Status: {{ ucfirst($node->user->status ?? '') }}</small>
                      </div>
                      <div class="text-end">
                        <small>Level: {{ $node->level }}</small><br>
                        <small>Position: {{ ucfirst($node->position) }}</small>
                      </div>
                    </li>
                  @endforeach
                </ul>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('referChart').getContext('2d');

    const labels = @json($referChartLabels);
    const data   = @json($referChartCounts);

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Direct Signups',
          data: data,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  });
</script>
@endpush
