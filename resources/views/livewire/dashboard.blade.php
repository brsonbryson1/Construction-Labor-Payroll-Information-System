<div>
    {{-- Welcome Banner --}}
    <div id="welcome-banner" style="background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; position: relative;">
        <button onclick="dismissBanner()" style="position: absolute; top: 12px; right: 12px; background: rgba(255,255,255,0.2); border: none; color: white; width: 28px; height: 28px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
            <i class="bi bi-x-lg"></i>
        </button>
        <div style="margin-bottom: 12px; padding-right: 30px;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 700;">Welcome, {{ Auth::user()->name }}!</h2>
            <p style="margin: 4px 0 0 0; opacity: 0.9; font-size: 14px;">Construction & Labor Office Portal</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="/time-records" style="display: inline-flex; align-items: center; gap: 8px; background: white; color: #A99066; font-weight: 600; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px;">
                <i class="bi bi-clock"></i> Clock In/Out
            </a>
            <a href="/payroll-history" style="display: inline-flex; align-items: center; gap: 8px; border: 2px solid white; color: white; font-weight: 600; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px;">
                <i class="bi bi-file-earmark-text"></i> View Payroll
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div id="stats-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 20px;">
        {{-- Hours This Week --}}
        <div class="stat-card" style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: transform 0.2s, box-shadow 0.2s; cursor: default;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Hours This Week</p>
                    <p style="margin: 4px 0 0 0; font-size: 20px; font-weight: 700; color: #1f2937;">{{ number_format($hoursThisWeek, 1) }}</p>
                </div>
                <div style="width: 40px; height: 40px; background: rgba(169,144,102,0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-clock-history" style="color: #A99066; font-size: 18px;"></i>
                </div>
            </div>
        </div>

        {{-- Last Paycheck --}}
        <div class="stat-card" style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: transform 0.2s, box-shadow 0.2s; cursor: default;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Last Paycheck</p>
                    <p style="margin: 4px 0 0 0; font-size: 20px; font-weight: 700; color: #16a34a;">
                        ₱{{ $lastPaycheck ? number_format($lastPaycheck->net_pay, 2) : '0.00' }}
                    </p>
                </div>
                <div style="width: 40px; height: 40px; background: #dcfce7; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-cash" style="color: #16a34a; font-size: 18px;"></i>
                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="stat-card" style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: transform 0.2s, box-shadow 0.2s; cursor: default;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Status</p>
                    <p style="margin: 4px 0 0 0; font-size: 16px; font-weight: 700; color: {{ $currentStatus === 'Clocked In' ? '#16a34a' : '#d97706' }};">
                        {{ $currentStatus }}
                    </p>
                    @if($lastClockTime)
                        <p style="margin: 2px 0 0 0; font-size: 11px; color: #9ca3af;">{{ $lastClockTime }}</p>
                    @endif
                </div>
                <div style="width: 40px; height: 40px; background: {{ $currentStatus === 'Clocked In' ? '#dcfce7' : '#fef3c7' }}; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-person-check" style="color: {{ $currentStatus === 'Clocked In' ? '#16a34a' : '#d97706' }}; font-size: 18px;"></i>
                </div>
            </div>
        </div>

        {{-- Days This Month --}}
        <div class="stat-card" style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: transform 0.2s, box-shadow 0.2s; cursor: default;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Days This Month</p>
                    <p style="margin: 4px 0 0 0; font-size: 20px; font-weight: 700; color: #1f2937;">{{ $daysThisMonth }}</p>
                </div>
                <div style="width: 40px; height: 40px; background: #f3e8ff; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-calendar3" style="color: #9333ea; font-size: 18px;"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Monthly Payroll Chart - 3D Style (Hidden for Employees) --}}
    @if(Auth::user()->role !== 'Employee')
    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 16px; margin-bottom: 20px;">
        <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600; color: #1f2937;">Monthly Payroll Overview <span style="font-size: 12px; font-weight: 400; color: #9ca3af;">({{ date('Y') }})</span></h3>
        
        @php
            $maxHeight = 120;
            $currentMonth = (int) date('n');
            // For mobile: show last 6 months ending at current month
            $mobileMonths = [];
            for ($i = 5; $i >= 0; $i--) {
                $m = $currentMonth - $i;
                if ($m <= 0) $m += 12;
                $mobileMonths[] = $m;
            }
        @endphp
        
        {{-- Desktop: All 12 months --}}
        <div id="chart-desktop" style="display: none; align-items: flex-end; justify-content: space-around; height: 180px; padding: 0 8px 20px 20px;">
            @foreach($monthlyPayroll as $index => $data)
                @php
                    $hasData = $data['total'] > 0;
                    $barHeight = $hasData ? max(($data['percentage'] / 100) * $maxHeight, 25) : 8;
                @endphp
                <div style="display: flex; flex-direction: column; align-items: center; flex: 1; max-width: 50px;">
                    @if($hasData)
                        <span class="bar-value" style="font-size: 8px; color: #6b7280; margin-bottom: 6px; opacity: 0; transition: opacity 0.3s ease {{ $index * 0.05 + 0.5 }}s;">₱{{ number_format($data['total']/1000, 1) }}k</span>
                    @else
                        <span style="font-size: 8px; color: #d1d5db; margin-bottom: 6px;">—</span>
                    @endif
                    <div class="chart-bar" data-height="{{ $barHeight }}" style="position: relative; width: 28px; height: 0; transition: height 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) {{ $index * 0.05 }}s;">
                        @if($hasData)
                            <div style="position: absolute; width: 28px; height: 100%; background: linear-gradient(180deg, #A99066 0%, #8B7355 100%); border-radius: 2px 2px 0 0;"></div>
                            <div style="position: absolute; top: -6px; left: 3px; width: 28px; height: 10px; background: #C4AD82; transform: skewX(-45deg); border-radius: 2px 2px 0 0;"></div>
                            <div style="position: absolute; top: -3px; right: -6px; width: 8px; height: 100%; background: #7A6545; transform: skewY(-45deg); border-radius: 0 2px 0 0;"></div>
                        @else
                            <div style="position: absolute; width: 28px; height: 100%; background: #e5e7eb; border-radius: 2px;"></div>
                        @endif
                    </div>
                    <span style="font-size: 9px; color: {{ $hasData ? '#6b7280' : '#9ca3af' }}; margin-top: 6px; font-weight: 500;">{{ $data['month'] }}</span>
                </div>
            @endforeach
        </div>
        
        {{-- Mobile: Last 6 months --}}
        @php $mobileIndex = 0; @endphp
        <div id="chart-mobile" style="display: flex; align-items: flex-end; justify-content: space-around; height: 180px; padding: 0 8px 20px 20px;">
            @foreach($monthlyPayroll as $data)
                @if(in_array($data['monthNum'], $mobileMonths))
                    @php
                        $hasData = $data['total'] > 0;
                        $barHeight = $hasData ? max(($data['percentage'] / 100) * $maxHeight, 25) : 8;
                    @endphp
                    <div style="display: flex; flex-direction: column; align-items: center; flex: 1; max-width: 60px;">
                        @if($hasData)
                            <span class="bar-value" style="font-size: 9px; color: #6b7280; margin-bottom: 8px; opacity: 0; transition: opacity 0.3s ease {{ $mobileIndex * 0.08 + 0.5 }}s;">₱{{ number_format($data['total']/1000, 1) }}k</span>
                        @else
                            <span style="font-size: 9px; color: #d1d5db; margin-bottom: 8px;">—</span>
                        @endif
                        <div class="chart-bar" data-height="{{ $barHeight }}" style="position: relative; width: 32px; height: 0; transition: height 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) {{ $mobileIndex * 0.08 }}s;">
                            @if($hasData)
                                <div style="position: absolute; width: 32px; height: 100%; background: linear-gradient(180deg, #A99066 0%, #8B7355 100%); border-radius: 2px 2px 0 0;"></div>
                                <div style="position: absolute; top: -8px; left: 4px; width: 32px; height: 12px; background: #C4AD82; transform: skewX(-45deg); border-radius: 2px 2px 0 0;"></div>
                                <div style="position: absolute; top: -4px; right: -8px; width: 10px; height: 100%; background: #7A6545; transform: skewY(-45deg); border-radius: 0 2px 0 0;"></div>
                            @else
                                <div style="position: absolute; width: 32px; height: 100%; background: #e5e7eb; border-radius: 2px;"></div>
                            @endif
                        </div>
                        <span style="font-size: 10px; color: {{ $hasData ? '#6b7280' : '#9ca3af' }}; margin-top: 8px; font-weight: 500;">{{ $data['month'] }}</span>
                    </div>
                    @php $mobileIndex++; @endphp
                @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- Quick Actions --}}
    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">Quick Actions</h3>
        </div>
        <div style="padding: 12px;">
            <a href="/time-records" class="quick-action" style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #f9fafb; border-radius: 8px; text-decoration: none; margin-bottom: 8px; transition: all 0.2s;">
                <div style="width: 40px; height: 40px; background: rgba(169,144,102,0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-clock" style="color: #A99066;"></i>
                </div>
                <div style="flex: 1;">
                    <p style="margin: 0; font-weight: 500; color: #1f2937; font-size: 14px;">Clock In/Out</p>
                    <p style="margin: 2px 0 0 0; font-size: 12px; color: #6b7280;">Record your time</p>
                </div>
                <i class="bi bi-chevron-right" style="color: #9ca3af; font-size: 14px;"></i>
            </a>
            <a href="/payroll-history" class="quick-action" style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #f9fafb; border-radius: 8px; text-decoration: none; margin-bottom: 8px; transition: all 0.2s;">
                <div style="width: 40px; height: 40px; background: #dcfce7; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-receipt" style="color: #16a34a;"></i>
                </div>
                <div style="flex: 1;">
                    <p style="margin: 0; font-weight: 500; color: #1f2937; font-size: 14px;">View Paystubs</p>
                    <p style="margin: 2px 0 0 0; font-size: 12px; color: #6b7280;">Download pay history</p>
                </div>
                <i class="bi bi-chevron-right" style="color: #9ca3af; font-size: 14px;"></i>
            </a>
            <a href="{{ route('profile.show') }}" class="quick-action" style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #f9fafb; border-radius: 8px; text-decoration: none; transition: all 0.2s;">
                <div style="width: 40px; height: 40px; background: #fef3c7; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-person-gear" style="color: #d97706;"></i>
                </div>
                <div style="flex: 1;">
                    <p style="margin: 0; font-weight: 500; color: #1f2937; font-size: 14px;">My Profile</p>
                    <p style="margin: 2px 0 0 0; font-size: 12px; color: #6b7280;">Update your info</p>
                </div>
                <i class="bi bi-chevron-right" style="color: #9ca3af; font-size: 14px;"></i>
            </a>
        </div>
    </div>

    {{-- Styles and Scripts inside root div --}}
    <style>
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        }
        .quick-action:hover {
            background: #f3f4f6 !important;
            transform: translateX(4px);
        }
        .quick-action:hover .bi-chevron-right {
            color: #A99066 !important;
        }
    </style>

    <script>
        function updateLayout() {
            var grid = document.getElementById('stats-grid');
            var chartDesktop = document.getElementById('chart-desktop');
            var chartMobile = document.getElementById('chart-mobile');
            
            if (window.innerWidth >= 1024) {
                if (grid) {
                    grid.style.gridTemplateColumns = 'repeat(4, 1fr)';
                    grid.style.gap = '16px';
                }
                if (chartDesktop) chartDesktop.style.display = 'flex';
                if (chartMobile) chartMobile.style.display = 'none';
            } else {
                if (grid) {
                    grid.style.gridTemplateColumns = 'repeat(2, 1fr)';
                    grid.style.gap = '12px';
                }
                if (chartDesktop) chartDesktop.style.display = 'none';
                if (chartMobile) chartMobile.style.display = 'flex';
            }
        }
        
        function dismissBanner() {
            var banner = document.getElementById('welcome-banner');
            if (banner) {
                banner.style.transition = 'opacity 0.3s, transform 0.3s';
                banner.style.opacity = '0';
                banner.style.transform = 'translateY(-10px)';
                setTimeout(function() {
                    banner.style.display = 'none';
                }, 300);
                localStorage.setItem('hideDashboardBanner', 'true');
            }
        }
        
        if (localStorage.getItem('hideDashboardBanner') === 'true') {
            var banner = document.getElementById('welcome-banner');
            if (banner) banner.style.display = 'none';
        }
        
        updateLayout();
        window.addEventListener('resize', updateLayout);
        
        // Animate chart bars on load
        function animateChartBars() {
            setTimeout(function() {
                var bars = document.querySelectorAll('.chart-bar');
                bars.forEach(function(bar) {
                    var targetHeight = bar.getAttribute('data-height');
                    bar.style.height = targetHeight + 'px';
                });
                
                var values = document.querySelectorAll('.bar-value');
                values.forEach(function(val) {
                    val.style.opacity = '1';
                });
            }, 100);
        }
        
        animateChartBars();
    </script>
