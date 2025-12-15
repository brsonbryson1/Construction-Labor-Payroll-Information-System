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

            {{-- Preview Calculation --}}
            <div style="background: #f9fafb; border-radius: 10px; padding: 16px; margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <p style="margin: 0; font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Live Preview</p>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <label style="font-size: 12px; color: #6b7280;">Hours:</label>
                        <input type="number" id="preview_hours" value="8" min="1" max="24" step="0.5" 
                            style="width: 60px; padding: 6px 8px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; text-align: center;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; text-align: center;">
                    <div>
                        <p style="margin: 0; font-size: 11px; color: #9ca3af;">Gross Pay</p>
                        <p id="preview_gross" style="margin: 4px 0 0 0; font-size: 18px; font-weight: 700; color: #1f2937;">₱800.00</p>
                    </div>
                    <div>
                        <p style="margin: 0; font-size: 11px; color: #9ca3af;">Deductions</p>
                        <p id="preview_deductions" style="margin: 4px 0 0 0; font-size: 18px; font-weight: 700; color: #ef4444;">-₱80.00</p>
                    </div>
                    <div>
                        <p style="margin: 0; font-size: 11px; color: #9ca3af;">Net Pay</p>
                        <p id="preview_net" style="margin: 4px 0 0 0; font-size: 18px; font-weight: 700; color: #16a34a;">₱720.00</p>
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
                    <strong>Gross Pay</strong> = Hours Worked × Hourly Rate<br>
                    <strong>Deductions</strong> = Gross Pay × Deduction %<br>
                    <strong>Net Pay</strong> = Gross Pay - Deductions
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
            
            const gross = hours * hourlyRate;
            const deductions = gross * (deductionPct / 100);
            const net = gross - deductions;
            
            document.getElementById('preview_gross').textContent = '₱' + gross.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('preview_deductions').textContent = '-₱' + deductions.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('preview_net').textContent = '₱' + net.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
        
        document.getElementById('hourly_rate').addEventListener('input', updatePreview);
        document.getElementById('deduction_percentage').addEventListener('input', updatePreview);
        document.getElementById('preview_hours').addEventListener('input', updatePreview);
        
        updatePreview();
        
        function saveSettings() {
            const hourlyRate = document.getElementById('hourly_rate').value;
            const deductionPct = document.getElementById('deduction_percentage').value;
            
            if (!hourlyRate || hourlyRate < 1) {
                Swal.fire({ icon: 'warning', title: 'Invalid Rate', text: 'Hourly rate must be at least ₱1', confirmButtonColor: '#A99066' });
                return;
            }
            
            if (deductionPct < 0 || deductionPct > 100) {
                Swal.fire({ icon: 'warning', title: 'Invalid Percentage', text: 'Deduction must be between 0% and 100%', confirmButtonColor: '#A99066' });
                return;
            }
            
            Swal.fire({ title: 'Saving...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
            
            fetch('/api/settings', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ hourly_rate: hourlyRate, deduction_percentage: deductionPct })
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
