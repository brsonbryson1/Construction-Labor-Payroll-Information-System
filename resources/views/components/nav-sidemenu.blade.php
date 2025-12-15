@php
    $role = Auth::user()->role ?? 'Employee';
@endphp

<aside id="sidebar" class="sidebar">
    {{-- Logo Header --}}
    <div style="height: 64px; display: flex; align-items: center; justify-content: space-between; padding: 0 16px; background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); flex-shrink: 0;">
        <a href="/dashboard" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
            <div style="background: white; border-radius: 50%; padding: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('assets/images/logo1.png') }}" alt="CLPIS" style="width: 28px; height: 28px; object-fit: contain; display: block;">
            </div>
            <div>
                <span style="color: white; font-weight: 700; font-size: 16px; display: block; line-height: 1.2; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">CLPIS</span>
                <span style="color: rgba(255,255,255,0.85); font-size: 10px; display: block;">Labor Management</span>
            </div>
        </a>
        <button onclick="closeSidebar()" class="mobile-only" style="padding: 8px; background: rgba(255,255,255,0.15); border: none; color: white; font-size: 18px; cursor: pointer; border-radius: 8px; transition: background 0.2s;">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    {{-- User Info --}}
    <div style="padding: 16px; border-bottom: 1px solid #e5e7eb; background: linear-gradient(180deg, #f9fafb 0%, #ffffff 100%); flex-shrink: 0;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, rgba(169,144,102,0.2) 0%, rgba(169,144,102,0.1) 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid rgba(169,144,102,0.3);">
                <i class="bi bi-person-fill" style="font-size: 20px; color: #A99066;"></i>
            </div>
            <div style="min-width: 0; flex: 1;">
                <p style="margin: 0; font-weight: 600; color: #1f2937; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->name }}</p>
                <span style="font-size: 10px; padding: 3px 10px; border-radius: 20px; display: inline-block; margin-top: 4px; font-weight: 500;
                    @if($role === 'Admin') background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #b91c1c;
                    @elseif($role === 'Manager') background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #b45309;
                    @else background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; @endif">
                    {{ $role }}
                </span>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav style="flex: 1; padding: 12px; overflow-y: auto; background: #ffffff;">
        <p class="nav-section-title" style="font-size: 10px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.08em; margin: 8px 0 8px 12px;">Main Menu</p>
        
        <ul style="list-style: none; margin: 0; padding: 0;">
            <li style="margin-bottom: 2px;">
                <a href="/dashboard" onclick="closeSidebar()" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 10px; text-decoration: none; font-size: 14px; transition: all 0.2s;
                    {{ request()->is('dashboard') ? 'background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; font-weight: 500; box-shadow: 0 2px 8px rgba(169,144,102,0.3);' : 'color: #4b5563;' }}">
                    <div style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; {{ request()->is('dashboard') ? 'background: rgba(255,255,255,0.2);' : 'background: rgba(169,144,102,0.1);' }}">
                        <i class="bi bi-grid-1x2-fill" style="font-size: 16px; {{ request()->is('dashboard') ? 'color: white;' : 'color: #A99066;' }}"></i>
                    </div>
                    <span>Dashboard</span>
                </a>
            </li>
            @if($role !== 'Admin')
            <li style="margin-bottom: 2px;">
                <a href="/time-records" onclick="closeSidebar()" class="nav-link {{ request()->is('time-records') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 10px; text-decoration: none; font-size: 14px; transition: all 0.2s;
                    {{ request()->is('time-records') ? 'background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; font-weight: 500; box-shadow: 0 2px 8px rgba(169,144,102,0.3);' : 'color: #4b5563;' }}">
                    <div style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; {{ request()->is('time-records') ? 'background: rgba(255,255,255,0.2);' : 'background: rgba(169,144,102,0.1);' }}">
                        <i class="bi bi-clock-fill" style="font-size: 16px; {{ request()->is('time-records') ? 'color: white;' : 'color: #A99066;' }}"></i>
                    </div>
                    <span>Time Records</span>
                </a>
            </li>
            <li style="margin-bottom: 2px;">
                <a href="/payroll-history" onclick="closeSidebar()" class="nav-link {{ request()->is('payroll-history') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 10px; text-decoration: none; font-size: 14px; transition: all 0.2s;
                    {{ request()->is('payroll-history') ? 'background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; font-weight: 500; box-shadow: 0 2px 8px rgba(169,144,102,0.3);' : 'color: #4b5563;' }}">
                    <div style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; {{ request()->is('payroll-history') ? 'background: rgba(255,255,255,0.2);' : 'background: rgba(169,144,102,0.1);' }}">
                        <i class="bi bi-wallet2" style="font-size: 16px; {{ request()->is('payroll-history') ? 'color: white;' : 'color: #A99066;' }}"></i>
                    </div>
                    <span>Payroll History</span>
                </a>
            </li>
            @endif

            @if($role === 'Admin' || $role === 'Manager')
                <p class="nav-section-title" style="font-size: 10px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.08em; margin: 20px 0 8px 12px;">Management</p>
                
                <li style="margin-bottom: 2px;">
                    <a href="/laborers" onclick="closeSidebar()" class="nav-link {{ request()->is('laborers*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 10px; text-decoration: none; font-size: 14px; transition: all 0.2s;
                        {{ request()->is('laborers*') ? 'background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; font-weight: 500; box-shadow: 0 2px 8px rgba(169,144,102,0.3);' : 'color: #4b5563;' }}">
                        <div style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; {{ request()->is('laborers*') ? 'background: rgba(255,255,255,0.2);' : 'background: rgba(169,144,102,0.1);' }}">
                            <i class="bi bi-people-fill" style="font-size: 16px; {{ request()->is('laborers*') ? 'color: white;' : 'color: #A99066;' }}"></i>
                        </div>
                        <span>Laborers</span>
                    </a>
                </li>
                <li style="margin-bottom: 2px;">
                    <a href="/attendance" onclick="closeSidebar()" class="nav-link {{ request()->is('attendance*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 10px; text-decoration: none; font-size: 14px; transition: all 0.2s;
                        {{ request()->is('attendance*') ? 'background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; font-weight: 500; box-shadow: 0 2px 8px rgba(169,144,102,0.3);' : 'color: #4b5563;' }}">
                        <div style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; {{ request()->is('attendance*') ? 'background: rgba(255,255,255,0.2);' : 'background: rgba(169,144,102,0.1);' }}">
                            <i class="bi bi-calendar-check-fill" style="font-size: 16px; {{ request()->is('attendance*') ? 'color: white;' : 'color: #A99066;' }}"></i>
                        </div>
                        <span>Attendance</span>
                    </a>
                </li>
                <li style="margin-bottom: 2px;">
                    <a href="/payroll" onclick="closeSidebar()" class="nav-link {{ request()->is('payroll') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 10px; text-decoration: none; font-size: 14px; transition: all 0.2s;
                        {{ request()->is('payroll') ? 'background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; font-weight: 500; box-shadow: 0 2px 8px rgba(169,144,102,0.3);' : 'color: #4b5563;' }}">
                        <div style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; {{ request()->is('payroll') ? 'background: rgba(255,255,255,0.2);' : 'background: rgba(169,144,102,0.1);' }}">
                            <i class="bi bi-cash-stack" style="font-size: 16px; {{ request()->is('payroll') ? 'color: white;' : 'color: #A99066;' }}"></i>
                        </div>
                        <span>Process Payroll</span>
                    </a>
                </li>
            @endif

            @if($role === 'Admin')
                <p class="nav-section-title" style="font-size: 10px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.08em; margin: 20px 0 8px 12px;">Administration</p>
                
                <li style="margin-bottom: 2px;">
                    <a href="/reports" onclick="closeSidebar()" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 10px; text-decoration: none; font-size: 14px; transition: all 0.2s;
                        {{ request()->is('reports*') ? 'background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; font-weight: 500; box-shadow: 0 2px 8px rgba(169,144,102,0.3);' : 'color: #4b5563;' }}">
                        <div style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; {{ request()->is('reports*') ? 'background: rgba(255,255,255,0.2);' : 'background: rgba(169,144,102,0.1);' }}">
                            <i class="bi bi-bar-chart-fill" style="font-size: 16px; {{ request()->is('reports*') ? 'color: white;' : 'color: #A99066;' }}"></i>
                        </div>
                        <span>Reports</span>
                    </a>
                </li>
                <li style="margin-bottom: 2px;">
                    <a href="/users" onclick="closeSidebar()" class="nav-link {{ request()->is('users*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 10px; text-decoration: none; font-size: 14px; transition: all 0.2s;
                        {{ request()->is('users*') ? 'background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; font-weight: 500; box-shadow: 0 2px 8px rgba(169,144,102,0.3);' : 'color: #4b5563;' }}">
                        <div style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; {{ request()->is('users*') ? 'background: rgba(255,255,255,0.2);' : 'background: rgba(169,144,102,0.1);' }}">
                            <i class="bi bi-person-gear" style="font-size: 16px; {{ request()->is('users*') ? 'color: white;' : 'color: #A99066;' }}"></i>
                        </div>
                        <span>User Management</span>
                    </a>
                </li>
                <li style="margin-bottom: 2px;">
                    <a href="/settings" onclick="closeSidebar()" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 10px; text-decoration: none; font-size: 14px; transition: all 0.2s;
                        {{ request()->is('settings*') ? 'background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; font-weight: 500; box-shadow: 0 2px 8px rgba(169,144,102,0.3);' : 'color: #4b5563;' }}">
                        <div style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; {{ request()->is('settings*') ? 'background: rgba(255,255,255,0.2);' : 'background: rgba(169,144,102,0.1);' }}">
                            <i class="bi bi-gear" style="font-size: 16px; {{ request()->is('settings*') ? 'color: white;' : 'color: #A99066;' }}"></i>
                        </div>
                        <span>Settings</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>

    {{-- Footer --}}
    <div style="padding: 12px 16px; border-top: 1px solid #e5e7eb; background: #f9fafb; flex-shrink: 0;">
        <p style="margin: 0; font-size: 10px; color: #9ca3af; text-align: center;">© {{ date('Y') }} CLPIS</p>
    </div>
</aside>

<style>
    .nav-link:not(.active):hover {
        background: rgba(169,144,102,0.08) !important;
        transform: translateX(4px);
    }
    .nav-link:not(.active):hover span {
        color: #A99066;
    }
</style>
