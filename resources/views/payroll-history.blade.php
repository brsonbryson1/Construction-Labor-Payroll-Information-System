<x-app-layout>
    @section('page-title', 'Payroll History')

    {{-- Page Header --}}
    <div style="margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #1f2937;">Payroll History</h2>
        <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">View your pay stubs and payment history</p>
    </div>

    {{-- Livewire Component --}}
    @livewire('payroll-history')

    @push('scripts')
    <script>
        function viewPaystub(id, period, gross, deductions, net, status) {
            Swal.fire({
                title: '<span style="color: #1f2937;"><i class="bi bi-receipt" style="color: #A99066;"></i> Paystub Details</span>',
                html: `
                    <div style="text-align: left; padding: 10px 0;">
                        <div style="background: #f9fafb; padding: 16px; border-radius: 10px; margin-bottom: 16px;">
                            <p style="margin: 0 0 4px 0; font-size: 12px; color: #6b7280;">Pay Period</p>
                            <p style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">${period}</p>
                        </div>
                        
                        <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden;">
                            <div style="display: flex; justify-content: space-between; padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">
                                <span style="color: #6b7280;">Gross Pay</span>
                                <span style="font-weight: 600; color: #1f2937;">₱${gross.toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">
                                <span style="color: #6b7280;">Deductions</span>
                                <span style="font-weight: 600; color: #ef4444;">-₱${deductions.toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 12px 16px; background: rgba(169,144,102,0.1);">
                                <span style="font-weight: 600; color: #1f2937;">Net Pay</span>
                                <span style="font-weight: 700; color: #16a34a; font-size: 18px;">₱${net.toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
                            </div>
                        </div>
                        
                        <div style="margin-top: 16px; text-align: center;">
                            <span style="display: inline-block; padding: 4px 16px; border-radius: 20px; font-size: 12px; font-weight: 500; ${status === 'Paid' ? 'background: rgba(169,144,102,0.15); color: #8B7355;' : 'background: #fef3c7; color: #b45309;'}">
                                ${status}
                            </span>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-download"></i> Download PDF',
                cancelButtonText: 'Close',
                confirmButtonColor: '#A99066',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open('/paystub/' + id + '/download', '_blank');
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
