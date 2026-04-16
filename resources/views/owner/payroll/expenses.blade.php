@extends('layouts.owner')

@section('title', 'Expenses')

@section('content')
    @php
        use Carbon\Carbon;
    @endphp

    <div class="ui-hero p-4 mb-1">

        <div
            class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3 p-2">
            <div>
                <h4 class="fw-bold mb-1">Expenses Ledger</h4>
                <div class="text-muted small">Track fuel, credits, and balance.</div>
            </div>
        </div>
    </div>

    {{-- Expense Summary (Indicators) --}}
    <div class="row mb-2 p-2">

        {{-- Total Debit --}}
        <div class="col-12 col-md-6 col-lg-3 d-flex">
            <div class="card ui-card border-0 ui-indicator ui-indicator-danger ui-kpi-card h-80 w-100">
                <div class="card-body text-center ui-kpi-body">

                    <div class="ui-kpi-label">
                        Total Debit 💸
                    </div>

                    <div id="debitTotal" class="ui-kpi-number text-danger">
                        PHP{{ number_format($totalDebit, 2) }}
                    </div>

                </div>
            </div>
        </div>

        {{-- Total Credit --}}
        <div class="col-12 col-md-6 col-lg-3 d-flex">
            <div class="card ui-card border-0 ui-indicator ui-indicator-success ui-kpi-card h-80 w-100">
                <div class="card-body text-center ui-kpi-body">

                    <div class="ui-kpi-label">
                        Total Credit 💰
                    </div>

                    <div id="totalCredit" class="ui-kpi-number text-success">
                        PHP{{ number_format($totalCredit, 2) }}
                    </div>

                </div>
            </div>
        </div>

        {{-- Balance --}}
        <div class="col-12 col-md-6 col-lg-3 d-flex">
            <div class="card ui-card border-0 ui-indicator ui-indicator-primary ui-kpi-card h-80 w-100">
                <div class="card-body text-center ui-kpi-body">

                    <div class="ui-kpi-label">
                        Balance 🏦
                    </div>

                    <div id="creditBalance" class="ui-kpi-number text-primary">
                        PHP{{ number_format($balance, 2) }}
                    </div>

                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3 d-flex">
            <div class="card ui-card border-0 ui-indicator ui-indicator-warning ui-kpi-card h-80 w-100">
                <div class="card-body text-center ui-kpi-body">

                    <div class="ui-kpi-label">
                        Avg Fuel Efficiency ⛽
                    </div>

                    <div class="ui-kpi-number text-warning">
                        {{ $avgKmPerLiter }} km/L
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div style="padding: 10px;">

        <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">

            {{-- LEFT SIDE BUTTONS --}}
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                    + Add Expense
                </button>

                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#addCreditModal">
                    + Add Credit
                </button>
            </div>

            {{-- RIGHT SIDE FILTER --}}
            <form method="GET" action="{{ route('owner.payroll.expenses') }}" class="expenses-filter">

                <select name="month" class="form-select form-select-sm" style="width:140px;">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month', now()->month) == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endforeach
                </select>

                <select name="year" class="form-select form-select-sm" style="width:100px;">
                    @foreach (range(now()->year - 2, now()->year + 5) as $y)
                        <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>

                <button class="btn btn-sm btn-primary">
                    Apply
                </button>

            </form>

        </div>

        <div class="row g-3">

            {{-- EXPENSES --}}
            <div class="col-lg-7">

                <div class="card ui-card border-0 h-100">

                    <div class="card-header bg-white border-0 pb-0">
                        <h6 class="fw-semibold mb-0">Expenses Ledger</h6>
                        <div class="text-muted small">Fuel and operational expenses</div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-hover" id="expensesTable">

                                <thead style="background-color:#f3f4f6; color:#374151;">
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Plate #</th>
                                        <th class="text-end">Debit</th>
                                        <th>Receipt (Y/N)</th>
                                        <th>Remarks</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($expenses as $i => $row)
                                        @php
                                            $d = \Carbon\Carbon::parse($row->date);
                                        @endphp

                                        <tr style="display:{{ $i < 10 ? 'table-row' : 'none' }};">

                                            <td class="fw-semibold text-center">{{ $d->format('d') }}</td>

                                            <td>
                                                {{ $row->time ? \Carbon\Carbon::parse($row->time)->format('h:i A') : '' }}
                                            </td>

                                            <td>{{ $row->plate_number ?? '.......' }}</td>

                                            <td class="text-end debit">
                                                {{ number_format($row->debit, 2) }}
                                            </td>

                                            <td class="text-center">
                                                {{ $row->receipt_surrendered ?? '' }}
                                            </td>

                                            <td>{{ $row->remarks ?? '' }}</td>

                                            <td class="text-center d-flex justify-content-center gap-2">

                                                <!-- EDIT BUTTON -->
                                                <button class="btn btn-sm btn-primary edit-expense-btn"
                                                    data-id="{{ $row->id }}" data-plate="{{ $row->plate_number }}"
                                                    data-date="{{ $row->date }}" data-time="{{ $row->time }}"
                                                    data-liters="{{ $row->liters }}" data-debit="{{ $row->debit }}"
                                                    data-start="{{ $row->start_odometer }}"
                                                    data-odometer="{{ $row->odometer }}"
                                                    data-receipt="{{ $row->receipt_surrendered }}"
                                                    data-remarks="{{ $row->remarks }}" data-bs-toggle="modal"
                                                    data-bs-target="#editExpenseModal" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <!-- DELETE BUTTON -->
                                                <button class="btn btn-sm btn-outline-danger delete-expense-btn"
                                                    data-id="{{ $row->id }}" data-plate="{{ $row->plate_number }}"
                                                    data-date="{{ $row->date }}" data-liters="{{ $row->liters }}"
                                                    data-debit="{{ $row->debit }}" data-bs-toggle="modal"
                                                    data-bs-target="#deleteExpenseModal" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </td>

                                        </tr>
                                    @endforeach

                                    @if (count($expenses) === 0)
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                No expenses recorded yet.
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>

                            </table>

                        </div>



                    </div>

                </div>

            </div>

            {{-- CREDIT HISTORY --}}
            <div class="col-lg-5">
                <div class="card ui-card border-0 h-100">

                    <div class="card-header bg-white border-0 pb-0">
                        <h6 class="fw-semibold mb-0">Credit History</h6>
                        <div class="text-muted small">
                            All added credits are listed here.
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-bordered table-striped" id="creditsTable">

                                <thead style="background-color:#f3f4f6; color:#374151;">
                                    <tr>
                                        <th>DATE</th>
                                        <th class="text-end">AMOUNT</th>
                                        <th class="text-center">ACTION</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($credits ?? [] as $c)
                                        @php
                                            $cd = isset($c->date) ? \Carbon\Carbon::parse($c->date) : null;
                                        @endphp

                                        <tr>

                                            <td class="fw-semibold text-center">
                                                {{ $cd ? $cd->format('d') : '-' }}
                                            </td>

                                            <td class="text-end credit-amount">
                                                {{ number_format($c->amount ?? 0, 2) }}
                                            </td>

                                            <td class="text-center">

                                                <!-- EDIT BUTTON -->
                                                <button class="btn btn-sm btn-primary edit-credit-btn"
                                                    data-id="{{ $c->id }}" data-date="{{ $c->date }}"
                                                    data-amount="{{ $c->amount }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <!-- DELETE BUTTON -->
                                                <button class="btn btn-sm btn-danger delete-credit-btn"
                                                    data-id="{{ $c->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </td>

                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
                                                No credits recorded yet.
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header fw-bold">
            Fuel Consumption Analysis 🚛
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Plate #</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Liters</th>
                            <th>Distance (km)</th>
                            <th>KM/L</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $e)
                            <tr>
                                <td>{{ $e->date }}</td>
                                <td>{{ $e->plate_number }}</td>
                                <td>{{ $e->start_odometer ?? '-' }}</td>
                                <td>{{ $e->odometer ?? '-' }}</td>
                                <td>{{ $e->liters }}</td>
                                <td>{{ $e->distance ?? '-' }}</td>
                                <td>
                                    @if ($e->km_per_liter)
                                        <span class="badge bg-primary">
                                            {{ $e->km_per_liter }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Add Expense Modal -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="expenseForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">Plate Number</label>
                                <select name="plate_number" class="form-select" required>
                                    <option value="">Select Plate Number</option>
                                    @foreach ($trucks ?? [] as $truck)
                                        <option value="{{ $truck->plate_number }}">
                                            {{ $truck->plate_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Time</label>
                                <input type="time" name="time" class="form-control">
                            </div>
                            <!-- START / END ODOMETER -->
                            <div class="col-6">
                                <label class="form-label">Start Odometer</label>
                                <input type="number" name="start_odometer" class="form-control">
                            </div>

                            <div class="col-6">
                                <label class="form-label">End Odometer</label>
                                <input type="number" name="odometer" class="form-control">
                            </div>

                            <!-- LITERS -->
                            <div class="col-6">
                                <label class="form-label">Liters</label>
                                <input type="number" step="0.01" name="liters" class="form-control" required>
                            </div>

                            <!-- AMOUNT + RECEIPT MAGKATABI -->
                            <div class="col-6">
                                <label class="form-label">Amount (PHP)</label>
                                <input type="number" step="0.01" name="debit" class="form-control" required>
                            </div>

                            <div class="col-6">
                                <label class="form-label">Receipt</label>
                                <select name="receipt_surrendered" class="form-select">
                                    <option value="">Select</option>
                                    <option value="YES">Yes</option>
                                    <option value="NO">No</option>
                                </select>
                            </div>

                            <!-- REMARKS FULL WIDTH -->
                            <div class="col-12">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="saveExpense" type="button" form="expenseForm" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Credit Modal -->
    <div class="modal fade" id="addCreditModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Credit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="creditForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Amount (PHP)</label>
                                <input type="number" step="0.01" name="amount" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" class="form-control"
                                    placeholder="e.g. Payment received">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="saveCredit" type="button" form="creditForm" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT CREDIT MODAL -->
    <div class="modal fade" id="editCreditModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Credit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="editCreditForm">
                        @csrf

                        <input type="hidden" id="editCreditId">

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" id="editCreditDate" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount (PHP)</label>
                            <input type="number" step="0.01" id="editCreditAmount" class="form-control" required>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="updateCreditBtn">Update</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Alert Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" id="alertHeader">
                    <h5 class="modal-title" id="alertTitle">Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="alertBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Expense Confirmation Modal -->
    <div class="modal fade" id="deleteExpenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Confirm Delete
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Are you sure you want to delete this expense?</p>
                    <div class="alert alert-warning">
                        <strong>Expense Details:</strong><br>
                        <span id="deleteExpenseDetails"></span>
                    </div>
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteExpense">
                        <i class="bi bi-trash me-1"></i>
                        Delete Expense
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Expense Modal -->
    <div class="modal fade" id="editExpenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editExpenseForm">
                        @csrf
                        <input type="hidden" name="id" id="editExpenseId">
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">Plate Number</label>
                                <select id="editPlateNumber" class="form-select" disabled>
                                    <option value="">Select Plate Number</option>
                                    @foreach ($trucks ?? [] as $truck)
                                        <option value="{{ $truck->plate_number }}">
                                            {{ $truck->plate_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Date</label>
                                <input type="date" name="date" id="editDate" class="form-control" required
                                    readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Time</label>
                                <input type="time" name="time" id="editTime" class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Liters Filled</label>
                                <input type="number" step="0.01" name="liters" id="editLiters"
                                    class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Amount (PHP)</label>
                                <input type="number" step="0.01" name="debit" id="editDebit" class="form-control"
                                    required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Start Odometer (KM)</label>
                                <input type="number" name="start_odometer" id="editStartOdo" class="form-control">
                            </div>

                            <div class="col-6">
                                <label class="form-label">End Odometer (KM)</label>
                                <input type="number" name="odometer" id="editOdometer" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Receipt Surrendered</label>
                                <select name="receipt_surrendered" id="editReceiptSurrendered" class="form-select">
                                    <option value="">Select</option>
                                    <option value="YES">Yes</option>
                                    <option value="NO">No</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" id="editRemarks" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="updateExpense" type="button" form="editExpenseForm"
                        class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
    
    

@endsection



@push('scripts')
<script>
    const lastOdoUrl = "{{ url('/owner/payroll/expenses/last-odometer') }}";
</script>
    <script>
        let totalCredit = {{ $totalCredit }};
        let totalDebit = {{ $totalDebit }};

        function formatPHP(num) {
            return 'PHP' + Number(num).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        function showAlert(message, type = 'info', title = 'Alert') {
            const header = document.getElementById('alertHeader');
            const titleEl = document.getElementById('alertTitle');
            const body = document.getElementById('alertBody');

            if (!header || !titleEl || !body) {
                alert(message);
                return;
            }

            header.className = 'modal-header';

            if (type === 'success') {
                header.classList.add('bg-success', 'text-white');
                titleEl.textContent = '✓ Success';
            } else if (type === 'error') {
                header.classList.add('bg-danger', 'text-white');
                titleEl.textContent = '✗ Error';
            } else {
                header.classList.add('bg-info', 'text-white');
                titleEl.textContent = title;
            }

            body.innerHTML = `<p class="mb-0">${message}</p>`;

            const modalEl = document.getElementById('alertModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }

        // 🔥 FORCE FIX MODAL BUG
        function closeModal(modalId) {
            const modalEl = document.getElementById(modalId);
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();

            // cleanup backdrop bug
            document.body.classList.remove('modal-open');
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        }

        // ======================
        // UPDATE DISPLAY
        // ======================
        function updateBalanceDisplay() {
            const balance = totalCredit - totalDebit;
            document.getElementById('creditBalance').textContent = formatPHP(balance);
        }

        function updateDebitDisplay() {
            const el = document.getElementById('debitTotal');
            if (el) el.textContent = formatPHP(totalDebit);
        }

        function updateTotalCreditDisplay() {
            const el = document.getElementById('totalCredit');
            if (el) el.textContent = formatPHP(totalCredit);
        }

        // ======================
        // UPDATE EXPENSE
        // ======================
        document.getElementById('updateExpense').addEventListener('click', function() {
            fetch("{{ route('owner.payroll.expenses.update') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: document.getElementById('editExpenseId').value,
                        liters: document.getElementById('editLiters').value,
                        debit: document.getElementById('editDebit').value,
                        start_odometer: document.getElementById('editStartOdo').value,
                        odometer: document.getElementById('editOdometer').value,
                        receipt_surrendered: document.getElementById('editReceiptSurrendered').value,
                        remarks: document.getElementById('editRemarks').value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        showAlert(data.message || "Update failed", 'error');
                    }
                })
                .catch(() => showAlert("Something went wrong", 'error'));
        });

        // ======================
        // CONFIRM DELETE EXPENSE
        // ======================
        document.getElementById('confirmDeleteExpense').addEventListener('click', function() {
            const id = this.dataset.id;

            fetch("{{ url('/owner/payroll/expenses') }}/" + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Close modal properly
                        const modalEl = document.getElementById('deleteExpenseModal');
                        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modal.hide();

                        // FIX BACKDROP BUG
                        document.body.classList.remove('modal-open');
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                        showAlert('Expense deleted successfully!', 'success');
                        setTimeout(() => location.reload(), 500);
                    } else {
                        showAlert(data.message || 'Delete failed', 'error');
                    }
                })
                .catch(() => showAlert('Something went wrong', 'error'));
        });

        // ======================
        // SAVE EXPENSE
        // ======================
        document.getElementById('saveExpense').addEventListener('click', function(e) {
            e.preventDefault();

            const form = document.getElementById('expenseForm');
            const formData = new FormData(form);
            const token = form.querySelector('input[name="_token"]').value;

            fetch('{{ route('owner.payroll.expenses.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    body: formData
                })
                .then(r => r.json())
                .then(data => {
                    if (!data.success) {
                        return showAlert(data.message || 'Failed to save expense', 'error');
                    }

                    showAlert('Expense added successfully!', 'success');

                    setTimeout(() => {
                        location.reload(); // 🔥 clean solution
                    }, 500);

                    closeModal('addExpenseModal');
                })
                .catch(err => showAlert(err.message, 'error'));
        });

        // ======================
        // ADD EXPENSE MODAL DEFAULTS
        // ======================
        document.getElementById('addExpenseModal').addEventListener('show.bs.modal', function() {

    // Set default date to today
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('#addExpenseModal input[name="date"]').value = today;

    // Set default time
    const now = new Date();
    const timeString = now.getHours().toString().padStart(2, '0') + ':' +
        now.getMinutes().toString().padStart(2, '0');
    document.querySelector('#addExpenseModal input[name="time"]').value = timeString;

    // ❌ DO NOT CLEAR plate_number (important fix)
    // document.querySelector('#addExpenseModal select[name="plate_number"]').value = '';

    // Clear other fields
    document.querySelector('#addExpenseModal input[name="start_odometer"]').value = '';
    document.querySelector('#addExpenseModal input[name="odometer"]').value = '';
    document.querySelector('#addExpenseModal input[name="liters"]').value = '';
    document.querySelector('#addExpenseModal input[name="debit"]').value = '';
    document.querySelector('#addExpenseModal select[name="receipt_surrendered"]').value = '';
    document.querySelector('#addExpenseModal input[name="remarks"]').value = '';

});

document.addEventListener('change', function (e) {

    if (e.target.matches('#addExpenseModal select[name="plate_number"]')) {

        const plate = e.target.value;

        if (!plate) return;

        fetch(`${lastOdoUrl}/${plate}`)
            .then(res => res.json())
            .then(data => {

                document.querySelector('#addExpenseModal input[name="start_odometer"]').value =
                    data.odometer ?? '';
                    
                console.log('ODOMETER:', data);

            })
            .catch(() => {
                console.log('Error fetching odometer');
            });
    }

});

        // ======================
        // ADD CREDIT MODAL DEFAULTS
        // ======================
        document.getElementById('addCreditModal').addEventListener('show.bs.modal', function() {
            // Set default date to today
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('#addCreditModal input[name="date"]').value = today;

            // Clear other fields
            document.querySelector('#addCreditModal input[name="amount"]').value = '';
            document.querySelector('#addCreditModal input[name="remarks"]').value = '';
        });

        // ======================
        // SAVE CREDIT (FIXED)
        // ======================
        document.getElementById('saveCredit').addEventListener('click', function(e) {
            e.preventDefault();

            const form = document.getElementById('creditForm');
            const formData = new FormData(form);
            const token = form.querySelector('input[name="_token"]').value;

            fetch('{{ route('owner.payroll.credits.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    body: formData
                })
                .then(r => r.json())
                .then(data => {
                    console.log("CREDIT RESPONSE:", data);

                    if (!data.success) {
                        return showAlert(data.message || 'Failed to save credit', 'error');
                    }

                    showAlert('Credit added successfully!', 'success');

                    setTimeout(() => {
                        location.reload(); // 🔥 reliable update
                    }, 500);

                    closeModal('addCreditModal');
                })
                .catch(err => {
                    console.error(err);
                    showAlert(err.message, 'error');
                });
        });
        

        // OPEN EDIT MODAL
        document.addEventListener('click', function(e) {

            // ✅ EDIT EXPENSE
            if (e.target.closest('.edit-expense-btn')) {
                const btn = e.target.closest('.edit-expense-btn');

                document.getElementById('editExpenseId').value = btn.dataset.id;
                document.getElementById('editPlateNumber').value = btn.dataset.plate;
                document.getElementById('editDate').value = btn.dataset.date;
                document.getElementById('editTime').value = btn.dataset.time;
                document.getElementById('editLiters').value = btn.dataset.liters;
                document.getElementById('editDebit').value = btn.dataset.debit;
                document.getElementById('editStartOdo').value = btn.dataset.start;
                document.getElementById('editOdometer').value = btn.dataset.odometer;
                document.getElementById('editReceiptSurrendered').value = btn.dataset.receipt;
                document.getElementById('editRemarks').value = btn.dataset.remarks;

                const modalEl = document.getElementById('editExpenseModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }

            // ✅ DELETE EXPENSE
            if (e.target.closest('.delete-expense-btn')) {
                const btn = e.target.closest('.delete-expense-btn');

                // Store the expense ID for deletion
                document.getElementById('confirmDeleteExpense').dataset.id = btn.dataset.id;

                // Populate modal with expense details
                const details = `
                    <strong>Plate:</strong> ${btn.dataset.plate}<br>
                    <strong>Date:</strong> ${btn.dataset.date}<br>
                    <strong>Liters:</strong> ${btn.dataset.liters}<br>
                    <strong>Amount:</strong> PHP ${parseFloat(btn.dataset.debit).toFixed(2)}
                `;
                document.getElementById('deleteExpenseDetails').innerHTML = details;

                const modalEl = document.getElementById('deleteExpenseModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }

            // ✅ EDIT CREDIT
            if (e.target.closest('.edit-credit-btn')) {
                const btn = e.target.closest('.edit-credit-btn');

                document.getElementById('editCreditId').value = btn.dataset.id;
                document.getElementById('editCreditDate').value = btn.dataset.date;
                document.getElementById('editCreditAmount').value = btn.dataset.amount;

                const modalEl = document.getElementById('editCreditModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }

            // ✅ DELETE CREDIT
            if (e.target.closest('.delete-credit-btn')) {
                const id = e.target.closest('.delete-credit-btn').dataset.id;

                if (!confirm('Delete this credit?')) return;

                fetch("{{ url('/owner/payroll/credits') }}/" + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showAlert('Deleted successfully!', 'success');
                            setTimeout(() => location.reload(), 500);
                        } else {
                            showAlert(data.message || 'Delete failed', 'error');
                        }
                    })
                    .catch(() => showAlert('Something went wrong', 'error'));
            }

        });


        // UPDATE CREDIT
        document.getElementById('updateCreditBtn').addEventListener('click', function() {

            fetch("{{ route('owner.payroll.credits.update') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        id: document.getElementById('editCreditId').value,
                        amount: document.getElementById('editCreditAmount').value,
                        date: document.getElementById('editCreditDate').value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {

                        // close modal properly
                        const modalEl = document.getElementById('editCreditModal');
                        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modal.hide();

                        // FIX BACKDROP BUG
                        document.body.classList.remove('modal-open');
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                        location.reload();

                    } else {
                        alert(data.message || "Update failed");
                    }
                })
                .catch(() => alert("Something went wrong"));
        });

        // ======================
        document.addEventListener('DOMContentLoaded', function() {
            updateBalanceDisplay();
            updateDebitDisplay();
            updateTotalCreditDisplay();
        });
    </script>
@endpush


@push('styles')
    <style>
        /* ===== Shipments-like UI ===== */
        .ui-card {
            border-radius: 18px;
            box-shadow: 0 14px 40px rgba(16, 24, 40, .08);
            transition: all .25s ease;
        }

        .ui-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(16, 24, 40, .12);
        }

        .ui-hero {
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, .05);
            background:
                radial-gradient(900px 500px at 10% 10%, rgba(99, 102, 241, .10), transparent 60%),
                radial-gradient(900px 500px at 90% 20%, rgba(16, 185, 129, .10), transparent 60%),
                linear-gradient(135deg, #ffffff, #f9fafb);
            box-shadow: 0 20px 40px rgba(17, 24, 39, .06);
        }

        .ui-divider {
            height: 1px;
            background: #edf0f4;
            width: 100%;
        }

        /* Search */
        .ui-search {
            position: relative;
        }

        .ui-search-input {
            height: 42px;
            border-radius: 999px;
            padding-left: 40px;
            border: 1px solid #e6e8ec;
            background: #fafbfc;
            transition: .2s ease;
        }

        .ui-search-input:focus {
            background: #fff;
            border-color: #cfd6ff;
            box-shadow: 0 0 0 .20rem rgba(13, 110, 253, .10);
        }

        .ui-search-icon {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #98a2b3;
            pointer-events: none;
        }

        /* pills */
        .ui-pill-btn {
            border-radius: 999px;
            padding: .45rem .90rem;
        }

        /* Make header buttons match input height */
        .ui-btn-wide,
        .ui-btn-equal {
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 1.1rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .ui-btn-wide {
            min-width: 140px;
        }

        /* Table */
        .ui-table-wrap {
            border: 1px solid #edf0f4;
            border-radius: 16px;
            background: #fff;
        }

        .ui-table-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 16px;
        }

        .ui-table thead th {
            background: #f8fafc;
            color: #667085;
            font-weight: 600;
            font-size: .80rem;
            letter-spacing: .02em;
            border-bottom: none !important;
            padding: 14px 16px;
            white-space: nowrap;
        }

        .ui-table tbody td {
            padding: 14px 16px;
            border-top: 1px solid #f1f3f6 !important;
            vertical-align: middle;
        }

        .ui-table tbody tr:hover {
            background: #fafcff;
        }

        /* top pagination */
        .ui-pager-top {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 6px;
        }

        .ui-pager-top .pagination {
            flex-wrap: nowrap;
            white-space: nowrap;
            margin-bottom: 0;
        }

        .ui-showing {
            white-space: nowrap;
        }

        /* Sort links */
        .table-sort {
            color: inherit;
            text-decoration: none;
            display: inline-flex;
            gap: .35rem;
            align-items: center;
            font-weight: 600;
        }

        .table-sort:hover {
            text-decoration: underline;
        }

        /* Status badges */
        .ui-badge {
            display: inline-flex;
            align-items: center;
            padding: .35rem .75rem;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 600;
            border: 1px solid transparent;
        }

        .ui-badge-draft {
            background: #f2f4f7;
            color: #344054;
            border-color: #eaecf0;
        }

        .ui-badge-dispatched {
            background: #e8f1ff;
            color: #175cd3;
            border-color: #cfe1ff;
        }

        .ui-badge-completed {
            background: #e7f8ef;
            color: #027a48;
            border-color: #bff0d4;
        }

        .ui-badge-cancelled {
            background: #ffeceb;
            color: #b42318;
            border-color: #ffd1cf;
        }

        .ui-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .ui-dot-draft {
            background: #667085;
        }

        .ui-dot-dispatched {
            background: #175cd3;
        }

        .ui-dot-completed {
            background: #027a48;
        }

        .ui-dot-cancelled {
            background: #b42318;
        }

        .ui-dot-pulse {
            position: relative;
        }

        .ui-dot-pulse::after {
            content: "";
            position: absolute;
            inset: -4px;
            border-radius: 999px;
            border: 1px solid rgba(23, 92, 211, .35);
            animation: uiPulse 1.6s ease-out infinite;
        }

        @keyframes uiPulse {
            0% {
                transform: scale(.65);
                opacity: .9;
            }

            100% {
                transform: scale(1.25);
                opacity: 0;
            }
        }

        .ui-action-btn {
            border-radius: 999px;
            padding: .25rem .5rem;
            font-weight: 600;
        }

        .ui-icon-btn {
            border-radius: 12px;
            border: 1px solid #f1f3f6;
            background: #fff;
            padding: .35rem .6rem;
        }

        .ui-icon-btn:hover {
            background: #f8fafc;
        }

        /* Available cards */
        .ui-available-card {
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(16, 24, 40, .06);
            transition: .2s ease;
        }

        .ui-available-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(16, 24, 40, .10);
        }

        .ui-available-number {
            font-size: 30px;
            font-weight: 800;
            line-height: 1;
        }

        .ui-eye-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid #d0d5dd;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .2s ease;
        }

        .ui-eye-btn i {
            font-size: 16px;
            color: #344054;
        }

        .ui-eye-btn:hover {
            background: #f2f4f7;
        }

        .ui-available-dropdown {
            margin-top: 6px;
        }

        .ui-list-controls .btn {
            border-radius: 999px;
            padding: .25rem .7rem;
        }

        .ui-mobile-trip {
            border-radius: 16px;
        }

        .ui-mobile-trip .card-body {
            padding: 14px 14px;
        }

        @media (max-width: 575.98px) {
            .ui-btn-wide {
                width: 100%;
            }

            .ui-btn-equal {
                width: 100%;
            }
        }

        @media (min-width:1200px) {
            .col-xl-5col {
                width: 20%;
                flex: 0 0 20%;
                max-width: 20%;
            }
        }

        #newTripModal .select2-container {
            width: 100% !important;
        }

        #newTripModal .select2-container--default .select2-selection--single {
            height: calc(2.375rem + 8px);
            padding: .375rem .75rem;
            border: 1px solid var(--bs-border-color, #ced4da);
            border-radius: .5rem;
            background-color: #fff;
            display: flex;
            align-items: center;
        }

        #newTripModal .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 0 !important;
            line-height: 1.5;
            color: var(--bs-body-color, #212529);
        }

        #newTripModal .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            right: .5rem;
        }

        #newTripModal .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        }

        #newTripModal .select2-dropdown {
            border: 1px solid var(--bs-border-color, #ced4da);
            border-radius: .5rem;
            overflow: hidden;
        }

        #newTripModal .select2-search__field {
            border-radius: .375rem;
            border: 1px solid var(--bs-border-color, #ced4da) !important;
            padding: .375rem .5rem;
            outline: none;
        }

        .person-stack {
            display: flex;
            align-items: center;
        }

        .person-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            border: 2px solid #fff;
        }

        .person-avatar:not(:first-child) {
            margin-left: -10px;
        }

        .trip-ticket {
            font-weight: 700;
            font-size: 15px;
            color: #4f46e5;
            background: #eef2ff;
            padding: 4px 10px;
            border-radius: 8px;
            display: inline-block;
        }

        .trip-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* top icons */
        .trip-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        /* equal icon buttons */
        .trip-icons .btn {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* dispatch full width */
        .trip-dispatch button {
            width: 100%;
            height: 42px;
            border-radius: 10px;
            font-weight: 600;
        }

        .trip-actions .btn {
            border-radius: 10px;
        }

        .trip-actions .btn-primary {
            padding-left: 14px;
            padding-right: 14px;
        }

        /* mobile optimization */
        @media (max-width:420px) {

            .trip-actions {
                justify-content: space-between;
            }

            .trip-actions .btn-primary {
                flex: 1;
            }

        }

        @media (max-width: 320px) {
            .ui-available-card .card-body {
                padding: 10px 12px;
            }
        }

        .person-avatar {
            position: relative;
            cursor: pointer;
        }

        /* tooltip */
        .person-avatar::after {
            content: attr(data-name);
            position: absolute;
            bottom: 120%;
            left: 50%;
            transform: translateX(-50%);
            background: #111827;
            color: white;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: 0.2s ease;
        }

        /* show on hover */
        .person-avatar:hover::after {
            opacity: 1;
        }

        .trip-status-row {
            display: flex;
            gap: 6px;
            margin-top: 6px;
        }

        .trip-status {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 8px;
            background: #f1f3f6;
            color: #344054;
        }

        /* delivery */
        .trip-status.delivery {
            background: #eef2ff;
            color: #4f46e5;
        }

        /* billing */
        .trip-status.billing {
            background: #fff7ed;
            color: #ea580c;
        }

        /* payment */
        .trip-status.payment {
            background: #ecfdf5;
            color: #16a34a;
        }

        .person-avatar.color-1 {
            background: #fee2e2;
            color: #991b1b;
        }

        .person-avatar.color-2 {
            background: #dbeafe;
            color: #1e3a8a;
        }

        .person-avatar.color-3 {
            background: #dcfce7;
            color: #166534;
        }

        .person-avatar.color-4 {
            background: #fef9c3;
            color: #854d0e;
        }

        .person-avatar.color-5 {
            background: #ede9fe;
            color: #5b21b6;
        }

        .person-avatar.color-6 {
            background: #fce7f3;
            color: #9d174d;
        }

        .person-avatar.color-7 {
            background: #cffafe;
            color: #155e75;
        }

        .person-avatar.color-8 {
            background: #f3f4f6;
            color: #374151;
        }

        .billing-unbilled {
            background: #fff7ed;
            color: #ea580c;
        }

        .billing-billed {
            background: #e0f2fe;
            color: #0369a1;
        }

        @media (max-width: 768px) {

            .ui-available-number {
                font-size: 24px;
            }

            .card-body {
                padding: 14px;
            }

            table th,
            table td {
                font-size: 13px;
                padding: 10px;
            }

        }

        @media (max-width: 576px) {

            .ui-available-card .card-body {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

        }

        .ui-kpi-number {
            font-size: 20px;
            font-weight: 800;
            line-height: 1;
            /* eto ang nagtatanggal ng extra space */
            margin-top: 2px;
            margin-bottom: -2px;
            /* bawas lower space */
        }

        .ui-kpi-label {
            font-size: 14px;
            /* mas malaki */
            font-weight: 700;
            /* mas kapal */
            color: #4b5563;
            margin-bottom: 10px;
            /* maliit lang gap */
        }

        /* QUEUE HEADER */

        .queue-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .queue-range {
            font-size: 13px;
            color: #6b7280;
        }

        .queue-filter {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .queue-filter input {
            max-width: 140px;
        }

        /* MOBILE QUEUE CARDS */

        .queue-card {
            background: white;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
        }

        .queue-card-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .queue-name {
            font-weight: 600;
            font-size: 15px;
        }

        .queue-role {
            display: block;
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
        }

        .queue-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .queue-stat span {
            font-size: 12px;
            color: #6b7280;
            display: block;
        }

        .queue-stat strong {
            font-size: 15px;
        }

        .queue-btn {
            border-radius: 10px;
            font-weight: 600;
        }

        .queue-details {
            margin-bottom: 14px;
        }

        .queue-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .queue-row span {
            font-size: 13px;
            color: #6b7280;
        }

        .queue-row strong {
            font-size: 16px;
            font-weight: 700;
        }

        /* MOBILE HEADER STACK */

        @media (max-width:576px) {

            .queue-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .queue-title {
                width: 100%;
            }


            .queue-filter {
                flex-direction: column;
                width: 100%;
            }

            .queue-filter input {
                width: 100%;
                max-width: none;
            }

            .queue-filter button {
                width: 100%;
            }


            .queue-range {
                font-size: 13px;
                color: #6b7280;
                margin-top: 2px;
                margin-bottom: 8px;
            }

        }
        
        .expenses-filter {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap; /* 🔥 important */
}

/* inputs adaptive */
.expenses-filter select {
    flex: 1;
    min-width: 120px;
}

/* buttons fixed */
.expenses-filter button {
    flex-shrink: 0;
    white-space: nowrap;
}

@media (max-width:576px) {

    .expenses-filter {
        flex-direction: column;
        width: 100%;
    }

    .expenses-filter select,
    .expenses-filter button {
        width: 100%;
    }

}
    </style>
@endpush
