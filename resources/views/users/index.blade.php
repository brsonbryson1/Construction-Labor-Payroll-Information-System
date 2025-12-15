<x-app-layout>
    @section('page-title', 'User Management')

    {{-- Page Header --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #1f2937;">User Management</h2>
            <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">Manage system users and their roles</p>
        </div>
        <button onclick="addUser()" style="display: inline-flex; align-items: center; gap: 8px; background: #A99066; color: white; font-weight: 600; padding: 10px 20px; border-radius: 10px; border: none; cursor: pointer; font-size: 14px;">
            <i class="bi bi-plus-lg"></i> Add User
        </button>
    </div>

    @php
        $users = \App\Models\User::all();
        $admins = $users->where('role', 'Admin')->count();
        $managers = $users->where('role', 'Manager')->count();
        $employees = $users->where('role', 'Employee')->count();
    @endphp

    {{-- Stats Cards --}}
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px;">
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Users</p>
            <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #1f2937;">{{ $users->count() }}</p>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">Admins</p>
            <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #ef4444;">{{ $admins }}</p>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">Managers</p>
            <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #d97706;">{{ $managers }}</p>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">Employees</p>
            <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #16a34a;">{{ $employees }}</p>
        </div>
    </div>

    {{-- Users List --}}
    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">All Users</h3>
        </div>

        {{-- Mobile Card View --}}
        <div class="mobile-records" style="display: block;">
            @foreach($users as $user)
                <div style="padding: 16px; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
                                @if($user->role === 'Admin') background: #fee2e2;
                                @elseif($user->role === 'Manager') background: #fef3c7;
                                @else background: rgba(169,144,102,0.15); @endif">
                                <i class="bi bi-person" style="font-size: 18px;
                                    @if($user->role === 'Admin') color: #ef4444;
                                    @elseif($user->role === 'Manager') color: #d97706;
                                    @else color: #A99066; @endif"></i>
                            </div>
                            <div>
                                <p style="margin: 0; font-size: 14px; font-weight: 600; color: #1f2937;">{{ $user->name }}</p>
                                <p style="margin: 2px 0 0 0; font-size: 12px; color: #6b7280;">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 4px;">
                            <button onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')" style="background: none; border: none; color: #A99066; cursor: pointer; padding: 8px;">
                                <i class="bi bi-pencil"></i>
                            </button>
                            @if($user->id !== auth()->id())
                                <button onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 8px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <div>
                            @if($user->role === 'Admin')
                                <span style="background: #fee2e2; color: #b91c1c; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;">Admin</span>
                            @elseif($user->role === 'Manager')
                                <span style="background: #fef3c7; color: #b45309; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;">Manager</span>
                            @else
                                <span style="background: rgba(169,144,102,0.15); color: #8B7355; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;">Employee</span>
                            @endif
                        </div>
                        <p style="margin: 0; font-size: 12px; color: #9ca3af;">Joined {{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Desktop Table View --}}
        <div class="desktop-records" style="display: none; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">User</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Email</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Role</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Joined</th>
                        <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr style="border-top: 1px solid #e5e7eb;">
                            <td style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
                                        @if($user->role === 'Admin') background: #fee2e2;
                                        @elseif($user->role === 'Manager') background: #fef3c7;
                                        @else background: rgba(169,144,102,0.15); @endif">
                                        <i class="bi bi-person" style="font-size: 18px;
                                            @if($user->role === 'Admin') color: #ef4444;
                                            @elseif($user->role === 'Manager') color: #d97706;
                                            @else color: #A99066; @endif"></i>
                                    </div>
                                    <p style="margin: 0; font-size: 14px; font-weight: 500; color: #1f2937;">{{ $user->name }}</p>
                                </div>
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: #6b7280;">{{ $user->email }}</td>
                            <td style="padding: 16px;">
                                @if($user->role === 'Admin')
                                    <span style="background: #fee2e2; color: #b91c1c; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">Admin</span>
                                @elseif($user->role === 'Manager')
                                    <span style="background: #fef3c7; color: #b45309; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">Manager</span>
                                @else
                                    <span style="background: rgba(169,144,102,0.15); color: #8B7355; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">Employee</span>
                                @endif
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: #6b7280;">{{ $user->created_at->format('M d, Y') }}</td>
                            <td style="padding: 16px; text-align: center;">
                                <button onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')" style="background: none; border: none; color: #A99066; cursor: pointer; padding: 8px;" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                @if($user->id !== auth()->id())
                                    <button onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 8px;" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
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
            .stats-grid { grid-template-columns: repeat(2, 1fr) !important; }
        }
    </style>

    @push('scripts')
    <script>
        const inputStyle = 'width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; margin-bottom: 12px;';
        const labelStyle = 'display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px; text-align: left;';

        function addUser() {
            Swal.fire({
                title: '<span style="color: #1f2937;">Add New User</span>',
                html: `
                    <div style="text-align: left;">
                        <label style="${labelStyle}">Full Name *</label>
                        <input type="text" id="name" style="${inputStyle}" placeholder="Enter full name">
                        <label style="${labelStyle}">Email Address *</label>
                        <input type="email" id="email" style="${inputStyle}" placeholder="Enter email address">
                        <label style="${labelStyle}">Password *</label>
                        <input type="password" id="password" style="${inputStyle}" placeholder="Enter password">
                        <label style="${labelStyle}">Role *</label>
                        <select id="role" style="${inputStyle}">
                            <option value="Employee">Employee</option>
                            <option value="Manager">Manager</option>
                            <option value="Admin">Admin</option>
                        </select>
                        <div style="margin-top: 8px; padding: 12px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; margin: 0;">
                                <input type="checkbox" id="notify_user" style="width: 18px; height: 18px; accent-color: #A99066;">
                                <span style="font-size: 13px; color: #374151;">
                                    <strong>Notify user about this account</strong><br>
                                    <small style="color: #6b7280;">Send welcome email with login credentials</small>
                                </span>
                            </label>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-plus-lg"></i> Add User',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#A99066',
                cancelButtonColor: '#6b7280',
                preConfirm: () => {
                    const name = document.getElementById('name').value;
                    const email = document.getElementById('email').value;
                    const password = document.getElementById('password').value;
                    const role = document.getElementById('role').value;
                    const notify_user = document.getElementById('notify_user').checked;
                    if (!name || !email || !password) { Swal.showValidationMessage('Please fill in all required fields'); return false; }
                    return { name, email, password, role, notify_user };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading if sending email
                    if (result.value.notify_user) {
                        Swal.fire({ title: 'Creating user...', html: 'Sending welcome email...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                    }
                    
                    fetch('/api/users', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify(result.value)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            Swal.fire({ icon: 'error', title: 'Error', text: data.error, confirmButtonColor: '#A99066' });
                        } else {
                            let message = 'User created successfully';
                            let icon = 'success';
                            if (data.email_sent === true) {
                                message += ' and welcome email sent!';
                            } else if (data.email_sent === false && result.value.notify_user) {
                                message += ' but email could not be sent.';
                                if (data.email_error) {
                                    message += '\n\nError: ' + data.email_error;
                                }
                                icon = 'warning';
                            }
                            Swal.fire({ icon: icon, title: icon === 'success' ? 'Success!' : 'Partial Success', text: message, confirmButtonColor: '#A99066' }).then(() => location.reload());
                        }
                    })
                    .catch(error => {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to create user', confirmButtonColor: '#A99066' });
                    });
                }
            });
        }

        function editUser(id, name, email, role) {
            Swal.fire({
                title: '<span style="color: #1f2937;">Edit User</span>',
                html: `
                    <div style="text-align: left;">
                        <label style="${labelStyle}">Full Name *</label>
                        <input type="text" id="edit_name" style="${inputStyle}" value="${name}">
                        <label style="${labelStyle}">Email Address *</label>
                        <input type="email" id="edit_email" style="${inputStyle}" value="${email}">
                        <label style="${labelStyle}">New Password <small style="color: #9ca3af;">(leave blank to keep current)</small></label>
                        <input type="password" id="edit_password" style="${inputStyle}" placeholder="Enter new password">
                        <label style="${labelStyle}">Role *</label>
                        <select id="edit_role" style="${inputStyle}">
                            <option value="Employee" ${role === 'Employee' ? 'selected' : ''}>Employee</option>
                            <option value="Manager" ${role === 'Manager' ? 'selected' : ''}>Manager</option>
                            <option value="Admin" ${role === 'Admin' ? 'selected' : ''}>Admin</option>
                        </select>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-lg"></i> Update',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#A99066',
                cancelButtonColor: '#6b7280',
                preConfirm: () => {
                    return {
                        name: document.getElementById('edit_name').value,
                        email: document.getElementById('edit_email').value,
                        password: document.getElementById('edit_password').value,
                        role: document.getElementById('edit_role').value
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/users/${id}`, {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify(result.value)
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({ icon: 'success', title: 'Updated!', text: 'User updated successfully', confirmButtonColor: '#A99066' }).then(() => location.reload());
                    });
                }
            });
        }

        function deleteUser(id, name) {
            Swal.fire({
                title: 'Delete User?',
                html: `Are you sure you want to delete <strong>${name}</strong>?<br><small style="color: #6b7280;">This action cannot be undone.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-trash"></i> Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/users/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({ icon: 'success', title: 'Deleted!', text: 'User has been deleted', confirmButtonColor: '#A99066' }).then(() => location.reload());
                    });
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
