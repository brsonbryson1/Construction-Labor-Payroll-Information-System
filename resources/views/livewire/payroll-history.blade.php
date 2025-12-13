<div>
    {{-- Summary Cards --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px;">
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: rgba(169,144,102,0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-cash-stack" style="color: #A99066; font-size: 18px;"></i>
                </div>
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Earned (YTD)</p>
                    <p style="margin: 4px 0 0 0; font-size: 20px; font-weight: 700; color: #1f2937;">₱{{ number_format($paychecks->sum('net_pay'), 2) }}</p>
                </div>
            </div>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #dbeafe; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-receipt" style="color: #2563eb; font-size: 18px;"></i>
                </div>
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Paychecks</p>
                    <p style="margin: 4px 0 0 0; font-size: 20px; font-weight: 700; color: #1f2937;">{{ $paychecks->count() }}</p>
                </div>
            </div>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #fee2e2; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-dash-circle" style="color: #ef4444; font-size: 18px;"></i>
                </div>
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Deductions</p>
                    <p style="margin: 4px 0 0 0; font-size: 20px; font-weight: 700; color: #1f2937;">₱{{ number_format($paychecks->sum('total_deductions'), 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Payment History --}}
    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">Payment History</h3>
        </div>
        
        {{-- Mobile Card View --}}
        <div class="mobile-records" style="display: block;">
            @forelse($paychecks as $paycheck)
                <div style="padding: 16px; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <p style="margin: 0; font-size: 14px; font-weight: 600; color: #1f2937;">
                                {{ \Carbon\Carbon::parse($paycheck->pay_period_start)->format('M d') }} - {{ \Carbon\Carbon::parse($paycheck->pay_period_end)->format('M d, Y') }}
                            </p>
                            <p style="margin: 4px 0 0 0; font-size: 12px; color: #6b7280;">
                                Pay Date: {{ \Carbon\Carbon::parse($paycheck->pay_date)->format('M d, Y') }}
                            </p>
                        </div>
                        @if($paycheck->status == 'Paid')
                            <span style="background: #A99066; color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                                <i class="bi bi-check-circle"></i> Paid
                            </span>
                        @else
                            <span style="background: #fef3c7; color: #b45309; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                                <i class="bi bi-clock"></i> Pending
                            </span>
                        @endif
                    </div>
                    <div style="display: flex; gap: 16px; margin-bottom: 12px; flex-wrap: wrap;">
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Gross</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 500; color: #1f2937;">₱{{ number_format($paycheck->gross_pay, 2) }}</p>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Deductions</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 500; color: #ef4444;">-₱{{ number_format($paycheck->total_deductions, 2) }}</p>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Net Pay</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 700; color: #16a34a;">₱{{ number_format($paycheck->net_pay, 2) }}</p>
                        </div>
                    </div>
                    <button onclick="viewPaystub({{ $paycheck->id }}, '{{ \Carbon\Carbon::parse($paycheck->pay_period_start)->format('M d') }} - {{ \Carbon\Carbon::parse($paycheck->pay_period_end)->format('M d, Y') }}', {{ $paycheck->gross_pay }}, {{ $paycheck->total_deductions }}, {{ $paycheck->net_pay }}, '{{ $paycheck->status }}')" 
                            style="display: inline-flex; align-items: center; gap: 6px; background: rgba(169,144,102,0.1); color: #A99066; padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer; font-size: 13px; font-weight: 500;">
                        <i class="bi bi-eye"></i> View Paystub
                    </button>
                </div>
            @empty
                <div style="padding: 48px 16px; text-align: center; color: #6b7280;">
                    <i class="bi bi-wallet2" style="font-size: 48px; color: #d1d5db; display: block; margin-bottom: 12px;"></i>
                    <p style="margin: 0; font-size: 14px;">No payroll records found yet.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="desktop-records" style="display: none; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Pay Period</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Pay Date</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Gross Pay</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Deductions</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Net Pay</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Status</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paychecks as $paycheck)
                        <tr style="border-top: 1px solid #e5e7eb;">
                            <td style="padding: 16px; font-size: 14px; font-weight: 500; color: #1f2937;">
                                {{ \Carbon\Carbon::parse($paycheck->pay_period_start)->format('M d') }} - {{ \Carbon\Carbon::parse($paycheck->pay_period_end)->format('M d, Y') }}
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: #6b7280;">
                                {{ \Carbon\Carbon::parse($paycheck->pay_date)->format('M d, Y') }}
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: #1f2937;">
                                ₱{{ number_format($paycheck->gross_pay, 2) }}
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: #ef4444;">
                                -₱{{ number_format($paycheck->total_deductions, 2) }}
                            </td>
                            <td style="padding: 16px; font-size: 14px; font-weight: 700; color: #16a34a;">
                                ₱{{ number_format($paycheck->net_pay, 2) }}
                            </td>
                            <td style="padding: 16px;">
                                @if($paycheck->status == 'Paid')
                                    <span style="background: #A99066; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                        <i class="bi bi-check-circle"></i> Paid
                                    </span>
                                @else
                                    <span style="background: #fef3c7; color: #b45309; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                        <i class="bi bi-clock"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 16px;">
                                <button onclick="viewPaystub({{ $paycheck->id }}, '{{ \Carbon\Carbon::parse($paycheck->pay_period_start)->format('M d') }} - {{ \Carbon\Carbon::parse($paycheck->pay_period_end)->format('M d, Y') }}', {{ $paycheck->gross_pay }}, {{ $paycheck->total_deductions }}, {{ $paycheck->net_pay }}, '{{ $paycheck->status }}')" 
                                        style="background: none; border: none; color: #A99066; cursor: pointer; font-size: 14px; font-weight: 500;">
                                    <i class="bi bi-eye"></i> View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 48px; text-align: center; color: #6b7280;">
                                <i class="bi bi-wallet2" style="font-size: 48px; color: #d1d5db; display: block; margin-bottom: 12px;"></i>
                                No payroll records found yet.
                            </td>
                        </tr>
                    @endforelse
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
            div[style*="grid-template-columns: repeat(3"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</div>
