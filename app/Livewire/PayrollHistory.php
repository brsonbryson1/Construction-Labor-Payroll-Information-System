<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Paycheck;
use Illuminate\Support\Facades\Auth;

class PayrollHistory extends Component
{
    // -------------------------------------------------------------------
    // FIX: Set the layout property directly for Livewire V2 compatibility
    // -------------------------------------------------------------------
    protected $layout = 'layouts.app'; // <--- ADD THIS LINE

    public $paychecks;

    public function mount()
    {
        $this->loadPaychecks();
    }

    public function loadPaychecks()
    {
        $this->paychecks = Paycheck::where('user_id', Auth::id())
                                   ->orderBy('pay_date', 'desc')
                                   ->get();
    }

    public function render()
    {
        // Now you just return the view, Livewire handles the wrapping
        return view('livewire.payroll-history');
    }
}