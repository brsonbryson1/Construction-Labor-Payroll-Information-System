<x-app-layout>
    @section('page-title', 'Reports')

    {{-- Page Header --}}
    <div style="margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #1f2937;">Reports & Analytics</h2>
        <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">View system reports and export data</p>
    </div>

    @php
        $totalEmployees = \App\Models\User::where('role', 'Employee')->count();
        $totalLaborers = \App\Models\Laborer::count();
        $totalPaychecks = \App\Models\Paycheck::count();
        $totalPaid = \App\Models\Paycheck::sum('net_pay');
        $totalHours = \App\Models\TimeRecord::sum('hours_worked');
        $thisMonthPayroll = \App\Models\Paycheck::whereMonth('pay_date', now()->month)->sum('net_pay');
    @endphp

    {{-- Summary Stats --}}
    <div class="summary-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px;">
        <div style="background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); border-radius: 12px; padding: 20px; color: white;">
            <p style="margin: 0; font-size: 14px; opacity: 0.9;">Total Payroll (All Time)</p>
            <p style="margin: 8px 0 0 0; font-size: 28px; font-weight: 700;">₱{{ number_format($totalPaid, 2) }}</p>
        </div>
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 14px; color: #6b7280;">This Month Payroll</p>
            <p style="margin: 8px 0 0 0; font-size: 28px; font-weight: 700; color: #16a34a;">₱{{ number_format($thisMonthPayroll, 2) }}</p>
        </div>
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 14px; color: #6b7280;">Total Hours Logged</p>
            <p style="margin: 8px 0 0 0; font-size: 28px; font-weight: 700; color: #1f2937;">{{ number_format($totalHours, 1) }}</p>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px;">
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: rgba(169,144,102,0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-people" style="color: #A99066; font-size: 18px;"></i>
                </div>
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Employees</p>
                    <p style="margin: 0; font-size: 20px; font-weight: 700; color: #1f2937;">{{ $totalEmployees }}</p>
                </div>
            </div>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #dcfce7; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-person-badge" style="color: #16a34a; font-size: 18px;"></i>
                </div>
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Laborers</p>
                    <p style="margin: 0; font-size: 20px; font-weight: 700; color: #1f2937;">{{ $totalLaborers }}</p>
                </div>
            </div>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #fef3c7; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-receipt" style="color: #d97706; font-size: 18px;"></i>
                </div>
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Paychecks</p>
                    <p style="margin: 0; font-size: 20px; font-weight: 700; color: #1f2937;">{{ $totalPaychecks }}</p>
                </div>
            </div>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #f3e8ff; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-clock-history" style="color: #9333ea; font-size: 18px;"></i>
                </div>
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Avg Hours/Day</p>
                    <p style="margin: 0; font-size: 20px; font-weight: 700; color: #1f2937;">{{ number_format($totalHours / max(\App\Models\TimeRecord::distinct('clock_in')->count(), 1), 1) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Report Types --}}
    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">Available Reports</h3>
        </div>
        <div class="reports-grid" style="padding: 16px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
            <button onclick="generatePayrollReport()" class="report-btn" style="display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 16px 8px; background: #f9fafb; border-radius: 10px; border: 1px solid #e5e7eb; cursor: pointer; text-align: center; width: 100%;">
                <div style="width: 48px; height: 48px; background: rgba(169,144,102,0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-file-earmark-spreadsheet" style="color: #A99066; font-size: 24px;"></i>
                </div>
                <p style="margin: 0; font-size: 12px; font-weight: 600; color: #1f2937;">Payroll</p>
            </button>
            <button onclick="generateAttendanceReport()" class="report-btn" style="display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 16px 8px; background: #f9fafb; border-radius: 10px; border: 1px solid #e5e7eb; cursor: pointer; text-align: center; width: 100%;">
                <div style="width: 48px; height: 48px; background: #dcfce7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-calendar-check" style="color: #16a34a; font-size: 24px;"></i>
                </div>
                <p style="margin: 0; font-size: 12px; font-weight: 600; color: #1f2937;">Attendance</p>
            </button>
            <button onclick="generateEmployeeReport()" class="report-btn" style="display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 16px 8px; background: #f9fafb; border-radius: 10px; border: 1px solid #e5e7eb; cursor: pointer; text-align: center; width: 100%;">
                <div style="width: 48px; height: 48px; background: #fef3c7; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-people" style="color: #d97706; font-size: 24px;"></i>
                </div>
                <p style="margin: 0; font-size: 12px; font-weight: 600; color: #1f2937;">Employee</p>
            </button>
            <button onclick="generateAnalyticsReport()" class="report-btn" style="display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 16px 8px; background: #f9fafb; border-radius: 10px; border: 1px solid #e5e7eb; cursor: pointer; text-align: center; width: 100%;">
                <div style="width: 48px; height: 48px; background: #f3e8ff; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-graph-up" style="color: #9333ea; font-size: 24px;"></i>
                </div>
                <p style="margin: 0; font-size: 12px; font-weight: 600; color: #1f2937;">Analytics</p>
            </button>
        </div>
    </div>

    <style>
        @media (max-width: 767px) {
            .summary-grid { grid-template-columns: 1fr !important; }
            .stats-grid { grid-template-columns: repeat(2, 1fr) !important; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr !important; }
        }
    </style>

    @push('scripts')
    <script>
        const inputStyle = 'width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; margin-bottom: 12px;';
        const labelStyle = 'display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px; text-align: left;';

        function getDefaultDates() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            return {
                start: firstDay.toISOString().split('T')[0],
                end: today.toISOString().split('T')[0],
                today: today.toISOString().split('T')[0]
            };
        }

        function generatePayrollReport() {
            const dates = getDefaultDates();
            Swal.fire({
                title: '<span style="color: #1f2937;"><i class="bi bi-file-earmark-spreadsheet" style="color: #A99066;"></i> Payroll Report</span>',
                html: `
                    <div style="text-align: left;">
                        <label style="${labelStyle}">Start Date</label>
                        <input type="date" id="report_start" style="${inputStyle}" value="${dates.start}">
                        <label style="${labelStyle}">End Date</label>
                        <input type="date" id="report_end" style="${inputStyle}" value="${dates.end}">
                        <label style="${labelStyle}">Format</label>
                        <select id="report_format" style="${inputStyle}">
                            <option value="html">View in Browser (Print/PDF)</option>
                            <option value="csv">Download CSV</option>
                        </select>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-download"></i> Generate',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#A99066',
                cancelButtonColor: '#6b7280',
                preConfirm: () => {
                    const start = document.getElementById('report_start').value;
                    const end = document.getElementById('report_end').value;
                    if (!start || !end) { Swal.showValidationMessage('Please select date range'); return false; }
                    return { start, end, format: document.getElementById('report_format').value };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(`/reports/payroll?start_date=${result.value.start}&end_date=${result.value.end}&format=${result.value.format}`, '_blank');
                }
            });
        }

        function generateAttendanceReport() {
            const dates = getDefaultDates();
            Swal.fire({
                title: '<span style="color: #1f2937;"><i class="bi bi-calendar-check" style="color: #16a34a;"></i> Attendance Report</span>',
                html: `
                    <div style="text-align: left;">
                        <label style="${labelStyle}">Report Type</label>
                        <select id="attendance_type" style="${inputStyle}">
                            <option value="daily">Daily Summary</option>
                            <option value="weekly">Weekly Summary</option>
                            <option value="monthly">Monthly Summary</option>
                        </select>
                        <label style="${labelStyle}">Date</label>
                        <input type="date" id="attendance_date" style="${inputStyle}" value="${dates.today}">
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-download"></i> Generate',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280',
                preConfirm: () => {
                    const date = document.getElementById('attendance_date').value;
                    if (!date) { Swal.showValidationMessage('Please select a date'); return false; }
                    return { date, type: document.getElementById('attendance_type').value };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(`/reports/attendance?date=${result.value.date}&type=${result.value.type}`, '_blank');
                }
            });
        }

        function generateEmployeeReport() {
            Swal.fire({
                title: '<span style="color: #1f2937;"><i class="bi bi-people" style="color: #d97706;"></i> Employee Report</span>',
                html: `
                    <div style="text-align: left;">
                        <label style="${labelStyle}">Include</label>
                        <div style="margin-bottom: 12px;">
                            <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; cursor: pointer;">
                                <input type="checkbox" id="inc_contact" checked style="width: 16px; height: 16px;"> Contact Information
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="checkbox" id="inc_salary" style="width: 16px; height: 16px;"> Salary Details
                            </label>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-download"></i> Generate',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d97706',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    const contact = document.getElementById('inc_contact').checked ? 1 : 0;
                    const salary = document.getElementById('inc_salary').checked ? 1 : 0;
                    window.open(`/reports/employees?include_contact=${contact}&include_salary=${salary}`, '_blank');
                }
            });
        }

        function generateAnalyticsReport() {
            Swal.fire({
                title: '<span style="color: #1f2937;"><i class="bi bi-graph-up" style="color: #9333ea;"></i> Analytics Report</span>',
                html: `
                    <div style="text-align: left;">
                        <label style="${labelStyle}">Time Period</label>
                        <select id="analytics_period" style="${inputStyle}">
                            <option value="month">Last Month</option>
                            <option value="quarter">Last Quarter</option>
                            <option value="year">Last Year</option>
                            <option value="all">All Time</option>
                        </select>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-download"></i> Generate',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#9333ea',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(`/reports/analytics?period=${document.getElementById('analytics_period').value}`, '_blank');
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
