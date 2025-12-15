<x-app-layout>
    @section('page-title', 'System Settings')

    {{-- Centered Container --}}
    <div style="max-width: 600px; margin: 0 auto;">
        {{-- Page Header --}}
        <div style="margin-bottom: 20px; text-align: center;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #1f2937;">System Settings</h2>
            <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">Configure payroll rates and deductions</p>
        </div>

        {{-- Payroll Settings Card --}}
        <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="padding: 16px 20px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">
                <i class="bi bi-gear" style="color: #A99066; margin-right: 8px;"></i>
                Payroll Configuration
            </h3>
        </div>
        
        <div style="padding: 24px;">
            {{-- Hourly Rate --}}
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                    <i class="bi bi-currency-exchange" style="color: #A99066; margin-right: 6px;"></i>
                    Hourly Rate (₱)
                </label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #6b7280; font-weight: 500;">₱</span>
                    <input type="number" id="hourly_rate" value="{{ $settings['hourly_rate'] ?? 100 }}" min="1" step="0.01"
                        style="width: 100%; padding: 12px 14px 12px 32px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 16px; font-weight: 500;">
                </div>
                <p style="margin: 6px 0 0 0; font-size: 12px; color: #9ca3af;">Amount paid per hour of work</p>
            </div>

            {{-- Deduction Percentage --}}
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                    <i class="bi bi-percent" style="color: #A99066; margin-right: 6px;"></i>
                    Deduction Percentage (%)
                </label>
                <div style="position: relative;">
                    <input type="number" id="deduction_percentage" value="{{ $settings['deduction_percentage'] ?? 10 }}" min="0" max="100" step="0.1"
                        style="width: 100%; padding: 12px 40px 12px 14px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 16px; font-weight: 500;">
                    <span style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #6b7280; font-weight: 500;">%</span>
                </div>
                <p style="margin: 6px 0 0 0; font-size: 12px; color: #9ca3af;">Percentage deducted from gross pay (SSS, PhilHealth, etc.)</p>
            </div>

            {{-- Time Clock Toggle --}}
            <div style="border-top: 1px solid #e5e7eb; padding-top: 24px; margin-top: 8px; margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #374151;">
                            <i class="bi bi-clock" style="color: #A99066; margin-right: 6px;"></i>
                            Time Clock
                        </label>
                        <p style="margin: 4px 0 0 0; font-size: 12px; color: #9ca3af;">Allow employees to clock in/out</p>
                    </div>
                    <label style="position: relative; display: inline-block; width: 52px; height: 28px; cursor: pointer;">
                        <input type="checkbox" id="time_clock_enabled" {{ ($settings['time_clock_enabled'] ?? '1') === '1' ? 'checked' : '' }}
                            style="opacity: 0; width: 0; height: 0;">
                        <span id="toggle_slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ ($settings['time_clock_enabled'] ?? '1') === '1' ? '#A99066' : '#d1d5db' }}; transition: 0.3s; border-radius: 28px;">
                            <span style="position: absolute; content: ''; height: 22px; width: 22px; left: {{ ($settings['time_clock_enabled'] ?? '1') === '1' ? '27px' : '3px' }}; bottom: 3px; background-color: white; transition: 0.3s; border-radius: 50%; box-shadow: 0 1px 3px rgba(0,0,0,0.2);" id="toggle_knob"></span>
                        </span>
                    </label>
                </div>
            </div>

            {{-- Overtime Settings Section --}}
            <div style="border-top: 1px solid #e5e7eb; padding-top: 24px;">
                <h4 style="margin: 0 0 16px 0; font-size: 14px; font-weight: 600; color: #1f2937;">
                    <i class="bi bi-clock-history" style="color: #A99066; margin-right: 6px;"></i>
                    Overtime Settings
                </h4>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    {{-- Regular Hours Per Day --}}
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                            Regular Hours/Day
                        </label>
                        <div style="position: relative;">
                            <input type="number" id="regular_hours_per_day" value="{{ $settings['regular_hours_per_day'] ?? 8 }}" min="1" max="24" step="0.5"
                                style="width: 100%; padding: 12px 50px 12px 14px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 16px; font-weight: 500;">
                            <span style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #6b7280; font-weight: 500; font-size: 13px;">hrs</span>
                        </div>
                    </div>
                    
                    {{-- Overtime Multiplier --}}
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                            OT Multiplier
                        </label>
                        <div style="position: relative;">
                            <input type="number" id="overtime_multiplier" value="{{ $settings['overtime_multiplier'] ?? 1.25 }}" min="1" max="5" step="0.05"
                                style="width: 100%; padding: 12px 40px 12px 14px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 16px; font-weight: 500;">
                            <span style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #6b7280; font-weight: 500; font-size: 13px;">x</span>
                        </div>
                    </div>
                </div>
                <p style="margin: -12px 0 0 0; font-size: 12px; color: #9ca3af;">Hours beyond regular are paid at OT rate (e.g., 1.25x = 25% extra)</p>
            </div>

            {{-- Preview Calculation --}}
            <div style="background: #f9fafb; border-radius: 10px; padding: 16px; margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <p style="margin: 0; font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Live Preview (1 Day)</p>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <label style="font-size: 12px; color: #6b7280;">Hours:</label>
                        <input type="number" id="preview_hours" value="10" min="1" max="24" step="0.5" 
                            style="width: 60px; padding: 6px 8px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; text-align: center;">
                    </div>
                </div>
                
                {{-- Regular & OT breakdown --}}
                <div id="preview_breakdown" style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #e5e7eb;">
                    <div style="background: white; padding: 8px 12px; border-radius: 6px;">
                        <p style="margin: 0; font-size: 10px; color: #9ca3af;">Regular (<span id="preview_reg_hrs">8</span> hrs)</p>
                        <p id="preview_regular_pay" style="margin: 2px 0 0 0; font-size: 14px; font-weight: 600; color: #1f2937;">₱800.00</p>
                    </div>
                    <div style="background: white; padding: 8px 12px; border-radius: 6px;">
                        <p style="margin: 0; font-size: 10px; color: #d97706;">Overtime (<span id="preview_ot_hrs">2</span> hrs @ <span id="preview_ot_rate">1.25</span>x)</p>
                        <p id="preview_overtime_pay" style="margin: 2px 0 0 0; font-size: 14px; font-weight: 600; color: #d97706;">₱250.00</p>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; text-align: center;">
                    <div>
                        <p style="margin: 0; font-size: 11px; color: #9ca3af;">Gross Pay</p>
                        <p id="preview_gross" style="margin: 4px 0 0 0; font-size: 18px; font-weight: 700; color: #1f2937;">₱1,050.00</p>
                    </div>
                    <div>
                        <p style="margin: 0; font-size: 11px; color: #9ca3af;">Deductions</p>
                        <p id="preview_deductions" style="margin: 4px 0 0 0; font-size: 18px; font-weight: 700; color: #ef4444;">-₱105.00</p>
                    </div>
                    <div>
                        <p style="margin: 0; font-size: 11px; color: #9ca3af;">Net Pay</p>
                        <p id="preview_net" style="margin: 4px 0 0 0; font-size: 18px; font-weight: 700; color: #16a34a;">₱945.00</p>
                    </div>
                </div>
            </div>

            {{-- Save Button --}}
            <button onclick="saveSettings()" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; background: #A99066; color: white; padding: 14px 24px; border-radius: 10px; border: none; cursor: pointer; font-size: 15px; font-weight: 600; transition: all 0.2s;">
                <i class="bi bi-check-lg"></i> Save Settings
            </button>
        </div>
    </div>

        {{-- Info Card --}}
        <div style="background: rgba(169,144,102,0.1); border: 1px solid rgba(169,144,102,0.2); border-radius: 12px; padding: 16px; margin-top: 20px;">
        <div style="display: flex; gap: 12px;">
            <i class="bi bi-info-circle" style="color: #A99066; font-size: 20px; flex-shrink: 0;"></i>
            <div>
                <p style="margin: 0; font-size: 14px; font-weight: 600; color: #8B7355;">How Payroll is Calculated</p>
                <p style="margin: 8px 0 0 0; font-size: 13px; color: #6b7280; line-height: 1.6;">
                    <strong>Regular Pay</strong> = Regular Hours × Hourly Rate<br>
                    <strong>Overtime Pay</strong> = OT Hours × Hourly Rate × OT Multiplier<br>
                    <strong>Gross Pay</strong> = Regular Pay + Overtime Pay<br>
                    <strong>Deductions</strong> = Gross Pay × Deduction %<br>
                    <strong>Net Pay</strong> = Gross Pay - Deductions
                </p>
                <p style="margin: 12px 0 0 0; font-size: 12px; color: #9ca3af;">
                    Example: 10 hrs at ₱100/hr with 8 regular hrs and 1.25x OT = ₱800 + ₱250 = ₱1,050 gross
                </p>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
    <script>
        function updatePreview() {
            const hourlyRate = parseFloat(document.getElementById('hourly_rate').value) || 0;
            const deductionPct = parseFloat(document.getElementById('deduction_percentage').value) || 0;
            const hours = parseFloat(document.getElementById('preview_hours').value) || 8;
            const regularHoursPerDay = parseFloat(document.getElementById('regular_hours_per_day').value) || 8;
            const otMultiplier = parseFloat(document.getElementById('overtime_multiplier').value) || 1.25;
            
            // Calculate regular and overtime
            let regularHours = Math.min(hours, regularHoursPerDay);
            let overtimeHours = Math.max(0, hours - regularHoursPerDay);
            
            const regularPay = regularHours * hourlyRate;
            const overtimePay = overtimeHours * hourlyRate * otMultiplier;
            const gross = regularPay + overtimePay;
            const deductions = gross * (deductionPct / 100);
            const net = gross - deductions;
            
            // Update breakdown
            document.getElementById('preview_reg_hrs').textContent = regularHours.toFixed(1);
            document.getElementById('preview_ot_hrs').textContent = overtimeHours.toFixed(1);
            document.getElementById('preview_ot_rate').textContent = otMultiplier.toFixed(2);
            document.getElementById('preview_regular_pay').textContent = '₱' + regularPay.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('preview_overtime_pay').textContent = '₱' + overtimePay.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            
            // Show/hide OT section based on whether there's overtime
            document.getElementById('preview_breakdown').style.display = overtimeHours > 0 ? 'grid' : 'none';
            
            document.getElementById('preview_gross').textContent = '₱' + gross.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('preview_deductions').textContent = '-₱' + deductions.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('preview_net').textContent = '₱' + net.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
        
        document.getElementById('hourly_rate').addEventListener('input', updatePreview);
        document.getElementById('deduction_percentage').addEventListener('input', updatePreview);
        document.getElementById('preview_hours').addEventListener('input', updatePreview);
        document.getElementById('regular_hours_per_day').addEventListener('input', updatePreview);
        document.getElementById('overtime_multiplier').addEventListener('input', updatePreview);
        
        // Toggle switch handler
        document.getElementById('time_clock_enabled').addEventListener('change', function() {
            const slider = document.getElementById('toggle_slider');
            const knob = document.getElementById('toggle_knob');
            if (this.checked) {
                slider.style.backgroundColor = '#A99066';
                knob.style.left = '27px';
            } else {
                slider.style.backgroundColor = '#d1d5db';
                knob.style.left = '3px';
            }
        });
        
        updatePreview();
        
        function saveSettings() {
            const hourlyRate = document.getElementById('hourly_rate').value;
            const deductionPct = document.getElementById('deduction_percentage').value;
            const regularHours = document.getElementById('regular_hours_per_day').value;
            const otMultiplier = document.getElementById('overtime_multiplier').value;
            
            if (!hourlyRate || hourlyRate < 1) {
                Swal.fire({ icon: 'warning', title: 'Invalid Rate', text: 'Hourly rate must be at least ₱1', confirmButtonColor: '#A99066' });
                return;
            }
            
            if (deductionPct < 0 || deductionPct > 100) {
                Swal.fire({ icon: 'warning', title: 'Invalid Percentage', text: 'Deduction must be between 0% and 100%', confirmButtonColor: '#A99066' });
                return;
            }

            if (regularHours < 1 || regularHours > 24) {
                Swal.fire({ icon: 'warning', title: 'Invalid Hours', text: 'Regular hours must be between 1 and 24', confirmButtonColor: '#A99066' });
                return;
            }

            if (otMultiplier < 1 || otMultiplier > 5) {
                Swal.fire({ icon: 'warning', title: 'Invalid Multiplier', text: 'OT multiplier must be between 1x and 5x', confirmButtonColor: '#A99066' });
                return;
            }
            
            Swal.fire({ title: 'Saving...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
            
            const timeClockEnabled = document.getElementById('time_clock_enabled').checked ? '1' : '0';

            fetch('/api/settings', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ 
                    hourly_rate: hourlyRate, 
                    deduction_percentage: deductionPct,
                    regular_hours_per_day: regularHours,
                    overtime_multiplier: otMultiplier,
                    time_clock_enabled: timeClockEnabled
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({ icon: 'success', title: 'Saved!', text: 'Settings updated successfully', confirmButtonColor: '#A99066' });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Failed to save settings', confirmButtonColor: '#A99066' });
                }
            })
            .catch(error => {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save settings', confirmButtonColor: '#A99066' });
            });
        }
    </script>
    @endpush
</x-app-layout>
