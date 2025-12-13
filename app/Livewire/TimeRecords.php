<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TimeRecord;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimeRecords extends Component
{
    public $currentRecord = null;
    public $status = 'Ready to Clock In';
    public $message = '';

    public function mount()
    {
        $this->loadCurrentRecord();
    }

    public function loadCurrentRecord()
    {
        // Find any open time record (clocked in but not out)
        $this->currentRecord = TimeRecord::where('user_id', Auth::id())
            ->whereNull('clock_out')
            ->latest()
            ->first();

        if ($this->currentRecord) {
            $this->status = 'Currently Clocked In since ' . $this->currentRecord->clock_in->format('h:i A');
        } else {
            $this->status = 'Ready to Clock In';
        }
    }

    public function clockIn()
    {
        // Check if already clocked in
        if ($this->currentRecord && !$this->currentRecord->clock_out) {
            $this->message = 'You are already clocked in!';
            return;
        }

        $this->currentRecord = TimeRecord::create([
            'user_id' => Auth::id(),
            'clock_in' => Carbon::now(),
        ]);

        $this->status = 'Clocked In at ' . $this->currentRecord->clock_in->format('h:i A');
        $this->message = 'Successfully clocked in!';
    }

    public function clockOut()
    {
        if (!$this->currentRecord || $this->currentRecord->clock_out) {
            $this->message = 'You need to clock in first!';
            return;
        }

        $clockOut = Carbon::now();
        $hoursWorked = $this->currentRecord->clock_in->diffInMinutes($clockOut) / 60;

        $this->currentRecord->update([
            'clock_out' => $clockOut,
            'hours_worked' => round($hoursWorked, 2),
        ]);

        $this->message = 'Clocked out! You worked ' . number_format($hoursWorked, 1) . ' hours.';
        $this->status = 'Ready to Clock In';
        $this->currentRecord = null;
    }

    public function render()
    {
        $history = TimeRecord::where('user_id', Auth::id())
            ->latest()
            ->limit(10)
            ->get();

        return view('livewire.time-records', [
            'history' => $history,
        ]);
    }
}
