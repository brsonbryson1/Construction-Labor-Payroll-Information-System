<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TimeRecord;
use App\Models\Paycheck;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $hoursThisWeek = 0;
    public $lastPaycheck = null;
    public $currentStatus = 'Clocked Out';
    public $lastClockTime = null;
    public $daysThisMonth = 0;
    public $monthlyPayroll = [];

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $userId = Auth::id();
        $now = Carbon::now();

        // Hours this week
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();
        
        $weekRecords = TimeRecord::where('user_id', $userId)
            ->whereBetween('clock_in', [$startOfWeek, $endOfWeek])
            ->get();
        
        $this->hoursThisWeek = $weekRecords->sum('hours_worked') ?? 0;

        // Current status - check if clocked in
        $openRecord = TimeRecord::where('user_id', $userId)
            ->whereNull('clock_out')
            ->latest()
            ->first();

        if ($openRecord) {
            $this->currentStatus = 'Clocked In';
            $this->lastClockTime = $openRecord->clock_in->format('h:i A');
        } else {
            $lastRecord = TimeRecord::where('user_id', $userId)
                ->whereNotNull('clock_out')
                ->latest()
                ->first();
            
            if ($lastRecord) {
                $this->currentStatus = 'Clocked Out';
                $this->lastClockTime = $lastRecord->clock_out->format('M d, h:i A');
            }
        }

        // Last paycheck
        $this->lastPaycheck = Paycheck::where('user_id', $userId)
            ->orderBy('pay_date', 'desc')
            ->first();

        // Days worked this month - count unique dates
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        
        $this->daysThisMonth = TimeRecord::where('user_id', $userId)
            ->whereBetween('clock_in', [$startOfMonth, $endOfMonth])
            ->whereNotNull('clock_out')
            ->get()
            ->groupBy(function ($record) {
                return $record->clock_in->format('Y-m-d');
            })
            ->count();

        // Monthly payroll data for chart - full year (Jan to Dec)
        $this->monthlyPayroll = [];
        $currentYear = $now->year;
        
        for ($m = 1; $m <= 12; $m++) {
            $month = Carbon::create($currentYear, $m, 1);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $total = Paycheck::where('user_id', $userId)
                ->whereBetween('pay_date', [$monthStart, $monthEnd])
                ->sum('net_pay');
            
            $this->monthlyPayroll[] = [
                'month' => $month->format('M'),
                'monthNum' => $m,
                'total' => $total,
                'percentage' => 0
            ];
        }

        // Calculate percentages for chart
        $maxPayroll = collect($this->monthlyPayroll)->max('total');
        if ($maxPayroll > 0) {
            foreach ($this->monthlyPayroll as &$data) {
                $data['percentage'] = ($data['total'] / $maxPayroll) * 100;
            }
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
