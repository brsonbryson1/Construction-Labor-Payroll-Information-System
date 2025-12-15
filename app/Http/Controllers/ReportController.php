<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Laborer;
use App\Models\Paycheck;
use App\Models\TimeRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function payroll(Request $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $format = $request->format ?? 'html';

        $paychecks = Paycheck::with('user')
            ->whereBetween('pay_date', [$startDate, $endDate])
            ->orderBy('pay_date', 'desc')
            ->get();

        $totalGross = $paychecks->sum('gross_pay');
        $totalDeductions = $paychecks->sum('total_deductions');
        $totalNet = $paychecks->sum('net_pay');

        $html = $this->generatePayrollReportHtml($paychecks, $startDate, $endDate, $totalGross, $totalDeductions, $totalNet);

        if ($format === 'csv') {
            return $this->generatePayrollCsv($paychecks, $startDate, $endDate);
        }

        return response($html)->header('Content-Type', 'text/html');
    }

    public function attendance(Request $request)
    {
        $date = Carbon::parse($request->date);
        $type = $request->type ?? 'daily';

        if ($type === 'weekly') {
            $startDate = $date->copy()->startOfWeek();
            $endDate = $date->copy()->endOfWeek();
        } elseif ($type === 'monthly') {
            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();
        } else {
            $startDate = $date->copy()->startOfDay();
            $endDate = $date->copy()->endOfDay();
        }

        $records = TimeRecord::with('user')
            ->whereBetween('clock_in', [$startDate, $endDate])
            ->orderBy('clock_in', 'desc')
            ->get();

        $totalHours = $records->sum('hours_worked');
        $uniqueEmployees = $records->pluck('user_id')->unique()->count();

        $html = $this->generateAttendanceReportHtml($records, $startDate, $endDate, $type, $totalHours, $uniqueEmployees);

        return response($html)->header('Content-Type', 'text/html');
    }

    public function employees(Request $request)
    {
        $includeContact = $request->include_contact ?? true;
        $includeSalary = $request->include_salary ?? false;

        $employees = User::where('role', 'Employee')->get();
        $laborers = Laborer::all();

        $html = $this->generateEmployeeReportHtml($employees, $laborers, $includeContact, $includeSalary);

        return response($html)->header('Content-Type', 'text/html');
    }

    public function analytics(Request $request)
    {
        $period = $request->period ?? 'month';

        switch ($period) {
            case 'quarter':
                $startDate = Carbon::now()->subMonths(3);
                break;
            case 'year':
                $startDate = Carbon::now()->subYear();
                break;
            case 'all':
                $startDate = Carbon::now()->subYears(10);
                break;
            default:
                $startDate = Carbon::now()->subMonth();
        }

        $endDate = Carbon::now();

        $paychecks = Paycheck::whereBetween('pay_date', [$startDate, $endDate])->get();
        $timeRecords = TimeRecord::whereBetween('clock_in', [$startDate, $endDate])->get();

        $totalPayroll = $paychecks->sum('net_pay');
        $totalHours = $timeRecords->sum('hours_worked');
        $avgPaycheck = $paychecks->count() > 0 ? $paychecks->avg('net_pay') : 0;

        // Monthly breakdown
        $monthlyData = [];
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths($i);
            $monthPayroll = Paycheck::whereMonth('pay_date', $month->month)
                ->whereYear('pay_date', $month->year)
                ->sum('net_pay');
            $monthHours = TimeRecord::whereMonth('clock_in', $month->month)
                ->whereYear('clock_in', $month->year)
                ->sum('hours_worked');
            $monthlyData[] = [
                'month' => $month->format('M Y'),
                'payroll' => $monthPayroll,
                'hours' => $monthHours
            ];
        }

        $html = $this->generateAnalyticsReportHtml($period, $totalPayroll, $totalHours, $avgPaycheck, array_reverse($monthlyData));

        return response($html)->header('Content-Type', 'text/html');
    }

    private function generatePayrollReportHtml($paychecks, $startDate, $endDate, $totalGross, $totalDeductions, $totalNet)
    {
        $rows = '';
        foreach ($paychecks as $p) {
            $rows .= '<tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . $p->user->name . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . Carbon::parse($p->pay_date)->format('M d, Y') . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: right;">₱' . number_format($p->gross_pay, 2) . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: right; color: #ef4444;">-₱' . number_format($p->total_deductions, 2) . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: right; font-weight: 600; color: #16a34a;">₱' . number_format($p->net_pay, 2) . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: center;">' . $p->status . '</td>
            </tr>';
        }

        return $this->wrapReport('Payroll Report', $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y'), '
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;">
                <div style="background: #f9fafb; padding: 16px; border-radius: 8px;">
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Gross Pay</p>
                    <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700;">₱' . number_format($totalGross, 2) . '</p>
                </div>
                <div style="background: #f9fafb; padding: 16px; border-radius: 8px;">
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Deductions</p>
                    <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #ef4444;">₱' . number_format($totalDeductions, 2) . '</p>
                </div>
                <div style="background: #f9fafb; padding: 16px; border-radius: 8px;">
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Net Pay</p>
                    <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #16a34a;">₱' . number_format($totalNet, 2) . '</p>
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb;">
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Employee</th>
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Pay Date</th>
                        <th style="padding: 12px 10px; text-align: right; font-size: 12px; color: #6b7280;">Gross</th>
                        <th style="padding: 12px 10px; text-align: right; font-size: 12px; color: #6b7280;">Deductions</th>
                        <th style="padding: 12px 10px; text-align: right; font-size: 12px; color: #6b7280;">Net Pay</th>
                        <th style="padding: 12px 10px; text-align: center; font-size: 12px; color: #6b7280;">Status</th>
                    </tr>
                </thead>
                <tbody>' . $rows . '</tbody>
            </table>
            <p style="margin-top: 16px; font-size: 12px; color: #9ca3af;">Total Records: ' . $paychecks->count() . '</p>
        ');
    }

    private function generatePayrollCsv($paychecks, $startDate, $endDate)
    {
        $csv = "Employee,Pay Date,Gross Pay,Deductions,Net Pay,Status\n";
        foreach ($paychecks as $p) {
            $csv .= '"' . $p->user->name . '",' . Carbon::parse($p->pay_date)->format('Y-m-d') . ',' . $p->gross_pay . ',' . $p->total_deductions . ',' . $p->net_pay . ',' . $p->status . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="payroll-report-' . $startDate->format('Y-m-d') . '-to-' . $endDate->format('Y-m-d') . '.csv"');
    }

    private function generateAttendanceReportHtml($records, $startDate, $endDate, $type, $totalHours, $uniqueEmployees)
    {
        $rows = '';
        foreach ($records as $r) {
            $rows .= '<tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . $r->user->name . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . $r->clock_in->format('M d, Y') . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . $r->clock_in->format('h:i A') . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . ($r->clock_out ? $r->clock_out->format('h:i A') : '—') . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: right; font-weight: 600;">' . ($r->hours_worked ? number_format($r->hours_worked, 1) . ' hrs' : 'In Progress') . '</td>
            </tr>';
        }

        $typeLabel = ucfirst($type) . ' Summary';

        return $this->wrapReport('Attendance Report - ' . $typeLabel, $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y'), '
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;">
                <div style="background: #f9fafb; padding: 16px; border-radius: 8px;">
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Records</p>
                    <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700;">' . $records->count() . '</p>
                </div>
                <div style="background: #f9fafb; padding: 16px; border-radius: 8px;">
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Unique Employees</p>
                    <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700;">' . $uniqueEmployees . '</p>
                </div>
                <div style="background: #f9fafb; padding: 16px; border-radius: 8px;">
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Hours</p>
                    <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #1f2937;">' . number_format($totalHours, 1) . '</p>
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb;">
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Employee</th>
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Date</th>
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Clock In</th>
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Clock Out</th>
                        <th style="padding: 12px 10px; text-align: right; font-size: 12px; color: #6b7280;">Hours</th>
                    </tr>
                </thead>
                <tbody>' . $rows . '</tbody>
            </table>
        ');
    }

    private function generateEmployeeReportHtml($employees, $laborers, $includeContact, $includeSalary)
    {
        $empRows = '';
        foreach ($employees as $e) {
            $empRows .= '<tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . $e->name . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . $e->email . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . $e->role . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . $e->created_at->format('M d, Y') . '</td>
            </tr>';
        }

        $labRows = '';
        foreach ($laborers as $l) {
            $labRows .= '<tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . $l->first_name . ' ' . $l->last_name . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . $l->job_position . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . ($l->contact ?? '—') . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: right; font-weight: 600;">₱' . number_format($l->daily_rate, 2) . '</td>
            </tr>';
        }

        return $this->wrapReport('Employee & Laborer Report', 'Generated on ' . Carbon::now()->format('M d, Y h:i A'), '
            <h3 style="margin: 0 0 16px 0; font-size: 16px; color: #1f2937;">System Users (' . $employees->count() . ')</h3>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 32px;">
                <thead>
                    <tr style="background: #f9fafb;">
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Name</th>
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Email</th>
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Role</th>
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Joined</th>
                    </tr>
                </thead>
                <tbody>' . $empRows . '</tbody>
            </table>
            
            <h3 style="margin: 0 0 16px 0; font-size: 16px; color: #1f2937;">Laborers (' . $laborers->count() . ')</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb;">
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Name</th>
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Position</th>
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Contact</th>
                        <th style="padding: 12px 10px; text-align: right; font-size: 12px; color: #6b7280;">Daily Rate</th>
                    </tr>
                </thead>
                <tbody>' . $labRows . '</tbody>
            </table>
        ');
    }

    private function generateAnalyticsReportHtml($period, $totalPayroll, $totalHours, $avgPaycheck, $monthlyData)
    {
        $chartBars = '';
        $maxPayroll = max(array_column($monthlyData, 'payroll')) ?: 1;
        foreach ($monthlyData as $m) {
            $height = $maxPayroll > 0 ? max(($m['payroll'] / $maxPayroll) * 100, 5) : 5;
            $chartBars .= '<div style="flex: 1; text-align: center;">
                <div style="height: ' . $height . 'px; background: #374151; border-radius: 4px 4px 0 0; margin: 0 2px;"></div>
                <p style="margin: 8px 0 0 0; font-size: 9px; color: #6b7280;">' . substr($m['month'], 0, 3) . '</p>
            </div>';
        }

        $tableRows = '';
        foreach ($monthlyData as $m) {
            $tableRows .= '<tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">' . $m['month'] . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: right;">₱' . number_format($m['payroll'], 2) . '</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: right;">' . number_format($m['hours'], 1) . ' hrs</td>
            </tr>';
        }

        return $this->wrapReport('Analytics Report', ucfirst($period) . ' Overview', '
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;">
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Payroll</p>
                    <p style="margin: 4px 0 0 0; font-size: 28px; font-weight: 700; color: #1f2937;">₱' . number_format($totalPayroll, 2) . '</p>
                </div>
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Hours</p>
                    <p style="margin: 4px 0 0 0; font-size: 28px; font-weight: 700;">' . number_format($totalHours, 1) . '</p>
                </div>
                <div style="background: #f9fafb; padding: 20px; border-radius: 8px;">
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Avg Paycheck</p>
                    <p style="margin: 4px 0 0 0; font-size: 28px; font-weight: 700; color: #16a34a;">₱' . number_format($avgPaycheck, 2) . '</p>
                </div>
            </div>
            
            <h3 style="margin: 0 0 16px 0; font-size: 16px; color: #1f2937;">Payroll Trend</h3>
            <div style="display: flex; align-items: flex-end; height: 120px; padding: 0 10px; margin-bottom: 24px; background: #f9fafb; border-radius: 8px;">
                ' . $chartBars . '
            </div>
            
            <h3 style="margin: 0 0 16px 0; font-size: 16px; color: #1f2937;">Monthly Breakdown</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb;">
                        <th style="padding: 12px 10px; text-align: left; font-size: 12px; color: #6b7280;">Month</th>
                        <th style="padding: 12px 10px; text-align: right; font-size: 12px; color: #6b7280;">Payroll</th>
                        <th style="padding: 12px 10px; text-align: right; font-size: 12px; color: #6b7280;">Hours</th>
                    </tr>
                </thead>
                <tbody>' . $tableRows . '</tbody>
            </table>
        ');
    }

    private function wrapReport($title, $subtitle, $content)
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>' . $title . ' - CLPIS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .report { max-width: 900px; margin: 0 auto; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border: 1px solid #e5e7eb; }
        .header { background: #ffffff; color: #1f2937; padding: 24px; border-bottom: 2px solid #e5e7eb; }
        .header h1 { font-size: 24px; margin-bottom: 4px; font-weight: 700; }
        .header p { color: #6b7280; font-size: 14px; }
        .logo-section { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
        .logo-img { width: 40px; height: 40px; object-fit: contain; }
        .content { padding: 24px; }
        .footer { background: #f9fafb; padding: 16px 24px; text-align: center; font-size: 12px; color: #6b7280; border-top: 1px solid #e5e7eb; }
        .no-print { margin-bottom: 16px; }
        @media print { 
            body { background: white; padding: 0; } 
            .report { box-shadow: none; border: none; } 
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="max-width: 900px; margin: 0 auto;">
        <button onclick="window.print()" style="background: white; color: #1f2937; padding: 10px 20px; border: 1px solid #d1d5db; border-radius: 8px; cursor: pointer; font-weight: 500;">
            Print / Save as PDF
        </button>
        <button onclick="window.close()" style="background: #6b7280; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 500; margin-left: 8px;">
            Close
        </button>
    </div>
    <div class="report">
        <div class="header">
            <div class="logo-section">
                <img src="/assets/images/logo1.png" alt="CLPIS" class="logo-img">
                <div>
                    <p style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0;">CLPIS</p>
                    <p style="font-size: 11px; color: #6b7280; margin: 0;">Construction Labor Payroll Information System</p>
                </div>
            </div>
            <h1>' . $title . '</h1>
            <p>' . $subtitle . '</p>
        </div>
        <div class="content">' . $content . '</div>
        <div class="footer">
            <p>This is a computer-generated document. No signature required.</p>
            <p style="margin-top: 4px;">© ' . date('Y') . ' CLPIS - Construction Labor Payroll Information System</p>
        </div>
    </div>
</body>
</html>';
    }
}
