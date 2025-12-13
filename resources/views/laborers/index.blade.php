<x-app-layout>
    @section('page-title', 'Laborers')

    {{-- Page Header --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #1f2937;">Laborers Management</h2>
            <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">Manage construction workers and their rates</p>
        </div>
        <button onclick="openAddModal()" style="display: inline-flex; align-items: center; gap: 8px; background: #A99066; color: white; font-weight: 600; padding: 10px 20px; border-radius: 10px; border: none; cursor: pointer; font-size: 14px;">
            <i class="bi bi-plus-lg"></i> Add Laborer
        </button>
    </div>

    {{-- Summary Cards --}}
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px;">
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Laborers</p>
            <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #1f2937;">{{ $laborers->count() }}</p>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">Avg Daily Rate</p>
            <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #1f2937;">₱{{ number_format($laborers->avg('daily_rate') ?? 0, 2) }}</p>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Daily Cost</p>
            <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #1f2937;">₱{{ number_format($laborers->sum('daily_rate') ?? 0, 2) }}</p>
        </div>
    </div>

    {{-- Laborers List --}}
    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">All Laborers</h3>
        </div>

        {{-- Mobile Card View --}}
        <div class="mobile-records" style="display: block;">
            @forelse($laborers as $laborer)
                <div style="padding: 16px; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; background: rgba(169,144,102,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-badge" style="color: #A99066; font-size: 18px;"></i>
                            </div>
                            <div>
                                <p style="margin: 0; font-size: 14px; font-weight: 600; color: #1f2937;">{{ $laborer->first_name }} {{ $laborer->last_name }}</p>
                                <span style="background: rgba(169,144,102,0.15); color: #8B7355; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 500;">
                                    {{ $laborer->job_position }}
                                </span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 4px;">
                            <button onclick="openEditModal({{ $laborer->id }}, '{{ $laborer->first_name }}', '{{ $laborer->last_name }}', '{{ $laborer->job_position }}', {{ $laborer->daily_rate }}, '{{ $laborer->contact }}')" style="background: none; border: none; color: #A99066; cursor: pointer; padding: 8px;">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button onclick="deleteLaborer({{ $laborer->id }}, '{{ $laborer->first_name }} {{ $laborer->last_name }}')" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 8px;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div style="display: flex; gap: 24px;">
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Daily Rate</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 600; color: #16a34a;">₱{{ number_format($laborer->daily_rate, 2) }}</p>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Contact</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; color: #1f2937;">{{ $laborer->contact ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div style="padding: 48px 16px; text-align: center; color: #6b7280;">
                    <i class="bi bi-people" style="font-size: 48px; color: #d1d5db; display: block; margin-bottom: 12px;"></i>
                    <p style="margin: 0; font-size: 14px;">No laborers found.</p>
                    <p style="margin: 4px 0 0 0; font-size: 13px; color: #9ca3af;">Add your first laborer to get started.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="desktop-records" style="display: none; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Name</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Position</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Daily Rate</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Contact</th>
                        <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laborers as $laborer)
                        <tr style="border-top: 1px solid #e5e7eb;">
                            <td style="padding: 16px; font-size: 14px; color: #1f2937; font-weight: 500;">
                                {{ $laborer->first_name }} {{ $laborer->last_name }}
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: #6b7280;">
                                <span style="background: rgba(169,144,102,0.15); color: #8B7355; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                    {{ $laborer->job_position }}
                                </span>
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: #1f2937; font-weight: 600;">
                                ₱{{ number_format($laborer->daily_rate, 2) }}
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: #6b7280;">
                                {{ $laborer->contact ?? '—' }}
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <button onclick="openEditModal({{ $laborer->id }}, '{{ $laborer->first_name }}', '{{ $laborer->last_name }}', '{{ $laborer->job_position }}', {{ $laborer->daily_rate }}, '{{ $laborer->contact }}')" style="background: none; border: none; color: #A99066; cursor: pointer; padding: 8px;" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button onclick="deleteLaborer({{ $laborer->id }}, '{{ $laborer->first_name }} {{ $laborer->last_name }}')" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 8px;" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 48px; text-align: center; color: #6b7280;">
                                <i class="bi bi-people" style="font-size: 48px; color: #d1d5db; display: block; margin-bottom: 12px;"></i>
                                No laborers found. Add your first laborer to get started.
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
            .stats-grid { grid-template-columns: 1fr !important; }
        }
    </style>

    @push('scripts')
    <script>
        const inputStyle = 'width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; margin-bottom: 12px;';
        const labelStyle = 'display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px; text-align: left;';

        function openAddModal() {
            Swal.fire({
                title: '<span style="color: #1f2937;">Add New Laborer</span>',
                html: `
                    <div style="text-align: left;">
                        <label style="${labelStyle}">First Name *</label>
                        <input type="text" id="first_name" style="${inputStyle}" placeholder="Enter first name">
                        
                        <label style="${labelStyle}">Last Name *</label>
                        <input type="text" id="last_name" style="${inputStyle}" placeholder="Enter last name">
                        
                        <label style="${labelStyle}">Job Position *</label>
                        <select id="job_position" style="${inputStyle}">
                            <option value="">Select position</option>
                            <option value="Mason">Mason</option>
                            <option value="Carpenter">Carpenter</option>
                            <option value="Electrician">Electrician</option>
                            <option value="Plumber">Plumber</option>
                            <option value="Laborer">Laborer</option>
                            <option value="Foreman">Foreman</option>
                            <option value="Painter">Painter</option>
                            <option value="Welder">Welder</option>
                        </select>
                        
                        <label style="${labelStyle}">Daily Rate (₱) *</label>
                        <input type="number" id="daily_rate" style="${inputStyle}" placeholder="Enter daily rate" step="0.01">
                        
                        <label style="${labelStyle}">Contact Number</label>
                        <input type="text" id="contact" style="${inputStyle}" placeholder="Enter contact number">
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-plus-lg"></i> Add Laborer',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#A99066',
                cancelButtonColor: '#6b7280',
                width: '450px',
                preConfirm: () => {
                    const first_name = document.getElementById('first_name').value;
                    const last_name = document.getElementById('last_name').value;
                    const job_position = document.getElementById('job_position').value;
                    const daily_rate = document.getElementById('daily_rate').value;
                    const contact = document.getElementById('contact').value;

                    if (!first_name || !last_name || !job_position || !daily_rate) {
                        Swal.showValidationMessage('Please fill in all required fields');
                        return false;
                    }
                    return { first_name, last_name, job_position, daily_rate, contact };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/laborers', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(result.value)
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Laborer added successfully',
                            confirmButtonColor: '#A99066'
                        }).then(() => location.reload());
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to add laborer',
                            confirmButtonColor: '#A99066'
                        });
                    });
                }
            });
        }

        function openEditModal(id, firstName, lastName, position, rate, contact) {
            Swal.fire({
                title: '<span style="color: #1f2937;">Edit Laborer</span>',
                html: `
                    <div style="text-align: left;">
                        <label style="${labelStyle}">First Name *</label>
                        <input type="text" id="edit_first_name" style="${inputStyle}" value="${firstName}">
                        
                        <label style="${labelStyle}">Last Name *</label>
                        <input type="text" id="edit_last_name" style="${inputStyle}" value="${lastName}">
                        
                        <label style="${labelStyle}">Job Position *</label>
                        <select id="edit_job_position" style="${inputStyle}">
                            <option value="Mason" ${position === 'Mason' ? 'selected' : ''}>Mason</option>
                            <option value="Carpenter" ${position === 'Carpenter' ? 'selected' : ''}>Carpenter</option>
                            <option value="Electrician" ${position === 'Electrician' ? 'selected' : ''}>Electrician</option>
                            <option value="Plumber" ${position === 'Plumber' ? 'selected' : ''}>Plumber</option>
                            <option value="Laborer" ${position === 'Laborer' ? 'selected' : ''}>Laborer</option>
                            <option value="Foreman" ${position === 'Foreman' ? 'selected' : ''}>Foreman</option>
                            <option value="Painter" ${position === 'Painter' ? 'selected' : ''}>Painter</option>
                            <option value="Welder" ${position === 'Welder' ? 'selected' : ''}>Welder</option>
                        </select>
                        
                        <label style="${labelStyle}">Daily Rate (₱) *</label>
                        <input type="number" id="edit_daily_rate" style="${inputStyle}" value="${rate}" step="0.01">
                        
                        <label style="${labelStyle}">Contact Number</label>
                        <input type="text" id="edit_contact" style="${inputStyle}" value="${contact || ''}">
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-lg"></i> Update',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#A99066',
                cancelButtonColor: '#6b7280',
                preConfirm: () => {
                    return {
                        first_name: document.getElementById('edit_first_name').value,
                        last_name: document.getElementById('edit_last_name').value,
                        job_position: document.getElementById('edit_job_position').value,
                        daily_rate: document.getElementById('edit_daily_rate').value,
                        contact: document.getElementById('edit_contact').value
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/laborers/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(result.value)
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'Laborer updated successfully',
                            confirmButtonColor: '#A99066'
                        }).then(() => location.reload());
                    });
                }
            });
        }

        function deleteLaborer(id, name) {
            Swal.fire({
                title: 'Delete Laborer?',
                html: `Are you sure you want to delete <strong>${name}</strong>?<br><small style="color: #6b7280;">This action cannot be undone.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-trash"></i> Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/laborers/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Laborer has been deleted',
                            confirmButtonColor: '#A99066'
                        }).then(() => location.reload());
                    });
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
