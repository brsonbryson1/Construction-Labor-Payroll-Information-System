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
    public function index()
    {
        $employees = User::where('role', 'Employee')->get();
        $hourlyRate = Setting::getHourlyRate();
        $deductionPct = Setting::getDeductionPercentage();
        
        return view('payroll.index', compact('employees', 'hourlyRate', 'deductionPct'));
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

        foreach ($employees as $employee) {
            $hoursWorked = TimeRecord::where('user_id', $employee->id)
                ->whereBetween('clock_in', [$startDate, $endDate])
                ->sum('hours_worked');

            $grossPay = $hoursWorked * $hourlyRate;
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

        $hoursWorked = TimeRecord::where('user_id', $employee->id)
            ->whereBetween('clock_in', [$startDate, $endDate])
            ->sum('hours_worked');

        $grossPay = $hoursWorked * $hourlyRate;
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

        $grossPay = $hoursWorked * $hourlyRate;
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
            'status' => 'Pending',
        ]);

        return response()->json([
            'success' => true,
            'paycheck' => $paycheck,
            'message' => 'Custom paycheck generated for ' . $employee->name
        ]);
    }
}
