# CLPIS - Construction Labor Payroll Information System

A payroll management system for construction companies to manage employee time tracking, payroll processing, and reporting.

---

## How The System Works

### Step 1: Admin Setup

Before employees can use the system, the administrator must configure the payroll settings:

1. The admin logs into the system and goes to Settings
2. The admin sets the hourly rate (e.g., 100 pesos per hour)
3. The admin sets the deduction percentage for government contributions (e.g., 10% for SSS, PhilHealth, Pag-IBIG) (OPTIONAL)
4. The admin sets the regular working hours per day (e.g., 8 hours)
5. The admin sets the overtime multiplier (e.g., 1.25x means overtime hours are paid 25% more)
6. The admin turns ON the time clock to allow employees to clock in and out

If the time clock is turned OFF, employees will see a message that the time clock is disabled and they cannot record their attendance.

---

### Step 2: Employee Attendance

Once the admin enables the time clock, employees can record their attendance:

1. The employee logs into the system
2. When the employee arrives at work, they click the "Clock In" button
3. The system records the exact time they clocked in
4. When the employee finishes work, they click the "Clock Out" button
5. The system automatically calculates how many hours they worked that day

For example, if an employee clocks in at 8:00 AM and clocks out at 6:00 PM, the system records 10 hours of work.

---

### Step 3: Overtime Calculation

The system automatically identifies overtime hours based on the settings:

1. If the regular hours per day is set to 8 hours, any hours beyond 8 are considered overtime
2. Overtime hours are paid at a higher rate based on the overtime multiplier

**Example:**
- Employee works 10 hours in one day
- Regular hours: 8 hours at 100 pesos/hour = 800 pesos
- Overtime hours: 2 hours at 100 pesos x 1.25 = 250 pesos
- Total for the day: 1,050 pesos

---

### Step 4: Payroll Processing

At the end of the pay period (weekly, bi-weekly, or monthly), the admin or manager processes the payroll:

1. The admin goes to the Payroll page
2. The admin selects the pay period (start date and end date)
3. The system shows all employees with their total hours worked, regular pay, overtime pay, and calculated net pay
4. The admin can generate paychecks for all employees at once, or individually
5. For new employees or special cases, the admin can create a custom paycheck with manual hours entry

---

### Step 5: Deductions and Net Pay

The system automatically calculates deductions from the gross pay:

1. Gross Pay = Regular Pay + Overtime Pay
2. Deductions = Gross Pay x Deduction Percentage
3. Net Pay = Gross Pay - Deductions

**Example:**
- Gross Pay: 1,050 pesos
- Deductions (10%): 105 pesos
- Net Pay: 945 pesos

---

### Step 6: Paystub Generation

After payroll is processed, employees can view and download their paystubs:

1. The employee goes to Payroll History
2. They can see all their past paychecks with details
3. They can click on any paycheck to view the full paystub
4. They can print or save the paystub as PDF

The paystub shows:
- Employee name and pay period
- Regular hours and regular pay
- Overtime hours and overtime pay
- Total gross pay
- Deductions
- Net pay (take-home amount)

---

### Step 7: Reports and Analytics

The admin can generate various reports to track payroll expenses:

1. **Payroll Report** - Shows all paychecks within a date range with totals
2. **Attendance Report** - Shows employee attendance records (daily, weekly, or monthly)
3. **Employee Report** - Lists all employees and laborers in the system
4. **Analytics Report** - Shows payroll trends and statistics over time

Reports can be viewed in the browser, printed, or exported as CSV files.

---

## User Roles

| Role | What They Can Do |
|------|------------------|
| Admin | Full access - manage users, settings, reports, payroll, attendance, laborers |
| Manager | Manage laborers, view attendance, process payroll |
| Employee | Clock in/out, view own time records, view own payroll history |

---

## Payroll Calculation Summary

```
Regular Pay    = Regular Hours x Hourly Rate
Overtime Pay   = Overtime Hours x Hourly Rate x OT Multiplier
Gross Pay      = Regular Pay + Overtime Pay
Deductions     = Gross Pay x Deduction Percentage
Net Pay        = Gross Pay - Deductions
```

---

## Settings Controlled by Admin

| Setting | Description | Example | Optional |
|---------|-------------|---------|----------|
| Hourly Rate | Base pay per hour of work | 100 pesos | No (Required) |
| Deduction % | Percentage for government contributions | 10% | Yes (Can be 0%) |
| Regular Hours/Day | Standard working hours before overtime | 8 hours | No (Required) |
| OT Multiplier | How much more overtime hours are paid | 1.25x (25% extra) | Yes (Can be 1x for no extra) |
| Time Clock | Enable or disable employee clock in/out | ON or OFF | Yes (Can be OFF) |

**Note:** If deduction is set to 0%, no deductions will be applied and Gross Pay equals Net Pay. If OT Multiplier is set to 1x, overtime hours are paid the same as regular hours.
