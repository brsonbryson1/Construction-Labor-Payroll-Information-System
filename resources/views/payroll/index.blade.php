<x-app-layout>
    @section('page-title', 'Process Payroll')

    {{-- Page Header --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #1f2937;">Payroll Processing</h2>
            <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">Generate and manage employee paychecks</p>
        </div>
        <button onclick="generatePayroll()" style="display: inline-flex; align-items: center; gap: 8px; background: #A99066; color: white; font-weight: 600; padding: 10px 20px; border-radius: 10px; border: none; cursor: pointer; font-size: 14px;">
            <i class="bi bi-plus-lg"></i> Generate Payroll
        </button>
    </div>

    {{-- Pay Period Selection --}}
    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600; color: #1f2937;">Select Pay Period</h3>
        <div class="date-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
            <div>
                <label style="display: block; font-size: 12px; font-weight: 500; color: #6b7280; margin-bottom: 6px;">Start Date</label>
                <input type="date" id="pay_start" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
            </div>
            <div>
                <label style="display: block; font-size: 12px; font-weight: 500; color: #6b7280; margin-bottom: 6px;">End Date</label>
                <input type="date" id="pay_end" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
            </div>
            <div>
                <label style="display: block; font-size: 12px; font-weight: 500; color: #6b7280; margin-bottom: 6px;">Pay Date</label>
                <input type="date" id="pay_date" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    @php
        $employees = \App\Models\User::where('role', 'Employee')->get();
        $pendingPaychecks = \App\Models\Paycheck::where('status', 'Pending')->count();
        $thisMonthTotal = \App\Models\Paycheck::whereMonth('pay_date', now()->month)->sum('net_pay');
    @endphp
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px;">
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Employees</p>
            <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #1f2937;">{{ $employees->count() }}</p>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">Pending Paychecks</p>
            <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #d97706;">{{ $pendingPaychecks }}</p>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">This Month Total</p>
            <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #16a34a;">₱{{ number_format($thisMonthTotal, 2) }}</p>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">Avg Per Employee</p>
            <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #1f2937;">₱{{ $employees->count() > 0 ? number_format($thisMonthTotal / max($employees->count(), 1), 2) : '0.00' }}</p>
        </div>
    </div>

    {{-- Employee Payroll List --}}
    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">Employee Payroll Summary</h3>
        </div>

        {{-- Mobile Card View --}}
        <div class="mobile-records" style="display: block;">
            @foreach($employees as $employee)
                @php
                    $hoursThisMonth = \App\Models\TimeRecord::where('user_id', $employee->id)
                        ->whereMonth('clock_in', now()->month)
                        ->sum('hours_worked');
                    $hourlyRate = 100;
                    $grossPay = $hoursThisMonth * $hourlyRate;
                    $deductions = $grossPay * 0.1;
                    $netPay = $grossPay - $deductions;
                @endphp
                <div style="padding: 16px; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; background: rgba(169,144,102,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person" style="color: #A99066; font-size: 18px;"></i>
                            </div>
                            <div>
                                <p style="margin: 0; font-size: 14px; font-weight: 600; color: #1f2937;">{{ $employee->name }}</p>
                                <p style="margin: 2px 0 0 0; font-size: 12px; color: #6b7280;">{{ $employee->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 12px;">
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Hours</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 500; color: #1f2937;">{{ number_format($hoursThisMonth, 1) }} hrs</p>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Gross Pay</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 500; color: #1f2937;">₱{{ number_format($grossPay, 2) }}</p>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Deductions</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 500; color: #ef4444;">-₱{{ number_format($deductions, 2) }}</p>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Net Pay</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 700; color: #16a34a;">₱{{ number_format($netPay, 2) }}</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button onclick="previewPaycheck({{ $employee->id }}, '{{ $employee->name }}', '{{ $employee->email }}', {{ $hoursThisMonth }}, {{ $grossPay }}, {{ $deductions }}, {{ $netPay }})" 
                                style="flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px; background: rgba(169,144,102,0.1); color: #A99066; padding: 10px; border-radius: 8px; border: none; cursor: pointer; font-size: 13px; font-weight: 500;">
                            <i class="bi bi-eye"></i> Preview
                        </button>
                        <button onclick="generateForEmployee({{ $employee->id }}, '{{ $employee->name }}', {{ $grossPay }}, {{ $deductions }}, {{ $netPay }})" 
                                style="flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px; background: #A99066; color: white; padding: 10px; border-radius: 8px; border: none; cursor: pointer; font-size: 13px; font-weight: 500;">
                            <i class="bi bi-check-lg"></i> Generate
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Desktop Table View --}}
        <div class="desktop-records" style="display: none; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Employee</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Hours Worked</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Gross Pay</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Deductions</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Net Pay</th>
                        <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        @php
                            $hoursThisMonth = \App\Models\TimeRecord::where('user_id', $employee->id)
                                ->whereMonth('clock_in', now()->month)
                                ->sum('hours_worked');
                            $hourlyRate = 100;
                            $grossPay = $hoursThisMonth * $hourlyRate;
                            $deductions = $grossPay * 0.1;
                            $netPay = $grossPay - $deductions;
                        @endphp
                        <tr style="border-top: 1px solid #e5e7eb;">
                            <td style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 36px; height: 36px; background: rgba(169,144,102,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person" style="color: #A99066;"></i>
                                    </div>
                                    <div>
                                        <p style="margin: 0; font-size: 14px; font-weight: 500; color: #1f2937;">{{ $employee->name }}</p>
                                        <p style="margin: 0; font-size: 12px; color: #6b7280;">{{ $employee->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: #1f2937;">{{ number_format($hoursThisMonth, 1) }} hrs</td>
                            <td style="padding: 16px; font-size: 14px; color: #1f2937;">₱{{ number_format($grossPay, 2) }}</td>
                            <td style="padding: 16px; font-size: 14px; color: #ef4444;">-₱{{ number_format($deductions, 2) }}</td>
                            <td style="padding: 16px; font-size: 14px; font-weight: 700; color: #16a34a;">₱{{ number_format($netPay, 2) }}</td>
                            <td style="padding: 16px; text-align: center;">
                                <button onclick="previewPaycheck({{ $employee->id }}, '{{ $employee->name }}', '{{ $employee->email }}', {{ $hoursThisMonth }}, {{ $grossPay }}, {{ $deductions }}, {{ $netPay }})" style="background: none; border: none; color: #A99066; cursor: pointer; padding: 6px;" title="Preview">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button onclick="generateForEmployee({{ $employee->id }}, '{{ $employee->name }}', {{ $grossPay }}, {{ $deductions }}, {{ $netPay }})" style="background: #A99066; color: white; padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 12px;">
                                    Generate
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        @media (min-width: 768px) {
            .mobile-records { display: none !important; }
            .desktop-records { display: block !important; }
        }
        @media (max-width: 767px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr) !important; }
            .date-grid { grid-template-columns: 1fr !important; }
        }
    </style>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            
            document.getElementById('pay_start').value = firstDay.toISOString().split('T')[0];
            document.getElementById('pay_end').value = lastDay.toISOString().split('T')[0];
            document.getElementById('pay_date').value = today.toISOString().split('T')[0];
        });

        function previewPaycheck(id, name, email, hours, gross, deductions, net) {
            Swal.fire({
                title: '<span style="color: #1f2937;"><i class="bi bi-eye" style="color: #A99066;"></i> Paycheck Preview</span>',
                html: `
                    <div style="text-align: left; padding: 10px 0;">
                        <div style="background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; padding: 16px; border-radius: 10px 10px 0 0; margin: -20px -20px 16px -20px;">
                            <p style="margin: 0; font-size: 18px; font-weight: 600;">${name}</p>
                            <p style="margin: 4px 0 0 0; font-size: 13px; opacity: 0.9;">${email}</p>
                        </div>
                        <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden;">
                            <div style="display: flex; justify-content: space-between; padding: 12px 16px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
                                <span style="color: #6b7280;">Hours Worked</span>
                                <span style="font-weight: 600; color: #1f2937;">${hours.toFixed(1)} hrs</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">
                                <span style="color: #6b7280;">Hourly Rate</span>
                                <span style="font-weight: 600; color: #1f2937;">₱100.00</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">
                                <span style="color: #6b7280;">Gross Pay</span>
                                <span style="font-weight: 600; color: #1f2937;">₱${gross.toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">
                                <span style="color: #6b7280;">Deductions (10%)</span>
                                <span style="font-weight: 600; color: #ef4444;">-₱${deductions.toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 14px 16px; background: rgba(169,144,102,0.1);">
                                <span style="font-weight: 700; color: #1f2937;">Net Pay</span>
                                <span style="font-weight: 700; color: #16a34a; font-size: 18px;">₱${net.toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
                            </div>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-lg"></i> Generate Paycheck',
                cancelButtonText: 'Close',
                confirmButtonColor: '#A99066',
                cancelButtonColor: '#6b7280',
                width: '420px'
            }).then((result) => {
                if (result.isConfirmed) {
                    generateForEmployee(id, name, gross, deductions, net);
                }
            });
        }

        function generatePayroll() {
            const startDate = document.getElementById('pay_start').value;
            const endDate = document.getElementById('pay_end').value;
            const payDate = document.getElementById('pay_date').value;

            if (!startDate || !endDate || !payDate) {
                Swal.fire({ icon: 'warning', title: 'Missing Dates', text: 'Please select pay period dates first.', confirmButtonColor: '#A99066' });
                return;
            }

            Swal.fire({
                title: 'Generate Payroll?',
                html: `<p style="margin: 0;"><strong>Pay Period:</strong> ${startDate} to ${endDate}</p><p style="margin: 8px 0 0 0;"><strong>Pay Date:</strong> ${payDate}</p>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-lg"></i> Generate All',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#A99066',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Generating...', html: 'Please wait...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

                    fetch('/payroll/generate', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ start_date: startDate, end_date: endDate, pay_date: payDate })
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({ icon: 'success', title: 'Payroll Generated!', text: data.message, confirmButtonColor: '#A99066' }).then(() => location.reload());
                    })
                    .catch(error => {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to generate payroll.', confirmButtonColor: '#A99066' });
                    });
                }
            });
        }

        function generateForEmployee(id, name, gross, deductions, net) {
            const startDate = document.getElementById('pay_start').value;
            const endDate = document.getElementById('pay_end').value;
            const payDate = document.getElementById('pay_date').value;

            if (!startDate || !endDate || !payDate) {
                Swal.fire({ icon: 'warning', title: 'Missing Dates', text: 'Please select pay period dates first.', confirmButtonColor: '#A99066' });
                return;
            }

            Swal.fire({
                title: `Generate Paycheck`,
                html: `<p style="margin: 0 0 12px 0; font-size: 16px;"><strong>${name}</strong></p>
                    <div style="background: #f9fafb; padding: 12px; border-radius: 8px; text-align: left;">
                        <p style="margin: 0 0 8px 0; display: flex; justify-content: space-between;"><span style="color: #6b7280;">Net Pay:</span><span style="font-weight: 700; color: #16a34a;">₱${net.toLocaleString('en-PH', {minimumFractionDigits: 2})}</span></p>
                    </div>`,
                icon: 'info',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: '<i class="bi bi-check-lg"></i> Generate',
                denyButtonText: '<i class="bi bi-printer"></i> Generate & Print',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#A99066',
                denyButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed || result.isDenied) {
                    fetch(`/payroll/generate/${id}`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ start_date: startDate, end_date: endDate, pay_date: payDate })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (result.isDenied && data.paycheck) {
                            window.open('/paystub/' + data.paycheck.id + '/download', '_blank');
                        }
                        Swal.fire({ icon: 'success', title: 'Paycheck Generated!', text: data.message, confirmButtonColor: '#A99066' }).then(() => location.reload());
                    })
                    .catch(error => {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to generate paycheck.', confirmButtonColor: '#A99066' });
                    });
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
