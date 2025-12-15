<?php

namespace App\Http\Controllers;

use App\Models\Paycheck;
use App\Models\User;
use App\Models\TimeRecord;
use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayrollController extends Controller
{
    /**
     * Calculate pay with overtime
     */
    private function calculatePayWithOvertime($totalHours, $hourlyRate, $regularHoursPerDay, $otMultiplier, $workDays = null)
    {
        // If workDays not provided, estimate based on total hours
        if ($workDays === null) {
            $workDays = ceil($totalHours / $regularHoursPerDay);
        }
        
        $maxRegularHours = $workDays * $regularHoursPerDay;
        
        if ($totalHours <= $maxRegularHours) {
            // No overtime
            return [
                'regular_hours' => $totalHours,
                'overtime_hours' => 0,
                'regular_pay' => $totalHours * $hourlyRate,
                'overtime_pay' => 0,
                'gross_pay' => $totalHours * $hourlyRate
            ];
        }
        
        // Has overtime
        $regularHours = $maxRegularHours;
        $overtimeHours = $totalHours - $maxRegularHours;
        $regularPay = $regularHours * $hourlyRate;
        $overtimePay = $overtimeHours * $hourlyRate * $otMultiplier;
        
        return [
            'regular_hours' => $regularHours,
            'overtime_hours' => $overtimeHours,
            'regular_pay' => $regularPay,
            'overtime_pay' => $overtimePay,
            'gross_pay' => $regularPay + $overtimePay
        ];
    }

    public function index()
    {
        $employees = User::where('role', 'Employee')->get();
        $hourlyRate = Setting::getHourlyRate();
        $deductionPct = Setting::getDeductionPercentage();
        $regularHours = Setting::getRegularHoursPerDay();
        $otMultiplier = Setting::getOvertimeMultiplier();
        
        return view('payroll.index', compact('employees', 'hourlyRate', 'deductionPct', 'regularHours', 'otMultiplier'));
    }

    public function generate(Request $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $payDate = Carbon::parse($request->pay_date);

        $employees = User::where('role', 'Employee')->get();
        $generated = [];

        $hourlyRate = Setting::getHourlyRate();
        $deductionPct = Setting::getDeductionPercentage();
        $regularHours = Setting::getRegularHoursPerDay();
        $otMultiplier = Setting::getOvertimeMultiplier();

        // Calculate work days in period
        $workDays = $startDate->diffInWeekdays($endDate) + 1;

        foreach ($employees as $employee) {
            $hoursWorked = TimeRecord::where('user_id', $employee->id)
                ->whereBetween('clock_in', [$startDate, $endDate])
                ->sum('hours_worked');

            $payCalc = $this->calculatePayWithOvertime($hoursWorked, $hourlyRate, $regularHours, $otMultiplier, $workDays);
            $grossPay = $payCalc['gross_pay'];
            $deductions = $grossPay * ($deductionPct / 100);
            $netPay = $grossPay - $deductions;

            if ($grossPay > 0) {
                $paycheck = Paycheck::create([
                    'user_id' => $employee->id,
                    'pay_period_start' => $startDate,
                    'pay_period_end' => $endDate,
                    'pay_date' => $payDate,
                    'gross_pay' => $grossPay,
                    'total_deductions' => $deductions,
                    'net_pay' => $netPay,
                    'regular_hours' => $payCalc['regular_hours'],
                    'overtime_hours' => $payCalc['overtime_hours'],
                    'regular_pay' => $payCalc['regular_pay'],
                    'overtime_pay' => $payCalc['overtime_pay'],
                    'status' => 'Pending',
                ]);
                $generated[] = $paycheck;
            }
        }

        return response()->json([
            'success' => true,
            'count' => count($generated),
            'message' => count($generated) . ' paychecks generated successfully'
        ]);
    }

    public function generateForEmployee(Request $request, $id)
    {
        $employee = User::findOrFail($id);
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $payDate = Carbon::parse($request->pay_date);

        $hourlyRate = Setting::getHourlyRate();
        $deductionPct = Setting::getDeductionPercentage();
        $regularHours = Setting::getRegularHoursPerDay();
        $otMultiplier = Setting::getOvertimeMultiplier();

        // Calculate work days in period
        $workDays = $startDate->diffInWeekdays($endDate) + 1;

        $hoursWorked = TimeRecord::where('user_id', $employee->id)
            ->whereBetween('clock_in', [$startDate, $endDate])
            ->sum('hours_worked');

        $payCalc = $this->calculatePayWithOvertime($hoursWorked, $hourlyRate, $regularHours, $otMultiplier, $workDays);
        $grossPay = $payCalc['gross_pay'];
        $deductions = $grossPay * ($deductionPct / 100);
        $netPay = $grossPay - $deductions;

        $paycheck = Paycheck::create([
            'user_id' => $employee->id,
            'pay_period_start' => $startDate,
            'pay_period_end' => $endDate,
            'pay_date' => $payDate,
            'gross_pay' => $grossPay,
            'total_deductions' => $deductions,
            'net_pay' => $netPay,
            'regular_hours' => $payCalc['regular_hours'],
            'overtime_hours' => $payCalc['overtime_hours'],
            'regular_pay' => $payCalc['regular_pay'],
            'overtime_pay' => $payCalc['overtime_pay'],
            'status' => 'Pending',
        ]);

        return response()->json([
            'success' => true,
            'paycheck' => $paycheck,
            'message' => 'Paycheck generated for ' . $employee->name
        ]);
    }

    public function preview($id)
    {
        $employee = User::findOrFail($id);
        
        $hourlyRate = Setting::getHourlyRate();
        $deductionPct = Setting::getDeductionPercentage();
        
        // Get current month data
        $hoursWorked = TimeRecord::where('user_id', $employee->id)
            ->whereMonth('clock_in', now()->month)
            ->sum('hours_worked');

        $grossPay = $hoursWorked * $hourlyRate;
        $deductions = $grossPay * ($deductionPct / 100);
        $netPay = $grossPay - $deductions;

        return response()->json([
            'employee' => $employee,
            'hours_worked' => $hoursWorked,
            'hourly_rate' => $hourlyRate,
            'gross_pay' => $grossPay,
            'deductions' => $deductions,
            'net_pay' => $netPay
        ]);
    }

    public function generateCustom(Request $request)
    {
        $employee = User::findOrFail($request->employee_id);
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $payDate = Carbon::parse($request->pay_date);

        $hoursWorked = (float) $request->hours;
        $hourlyRate = (float) $request->hourly_rate;
        $deductionPct = (float) $request->deduction_pct;
        $regularHours = (float) ($request->regular_hours ?? Setting::getRegularHoursPerDay());
        $otMultiplier = (float) ($request->ot_multiplier ?? Setting::getOvertimeMultiplier());

        // Calculate work days in period
        $workDays = $startDate->diffInWeekdays($endDate) + 1;

        $payCalc = $this->calculatePayWithOvertime($hoursWorked, $hourlyRate, $regularHours, $otMultiplier, $workDays);
        $grossPay = $payCalc['gross_pay'];
        $deductions = $grossPay * ($deductionPct / 100);
        $netPay = $grossPay - $deductions;

        $paycheck = Paycheck::create([
            'user_id' => $employee->id,
            'pay_period_start' => $startDate,
            'pay_period_end' => $endDate,
            'pay_date' => $payDate,
            'gross_pay' => $grossPay,
            'total_deductions' => $deductions,
            'net_pay' => $netPay,
            'regular_hours' => $payCalc['regular_hours'],
            'overtime_hours' => $payCalc['overtime_hours'],
            'regular_pay' => $payCalc['regular_pay'],
            'overtime_pay' => $payCalc['overtime_pay'],
            'status' => 'Pending',
        ]);

        return response()->json([
            'success' => true,
            'paycheck' => $paycheck,
            'message' => 'Custom paycheck generated for ' . $employee->name
        ]);
    }
}
