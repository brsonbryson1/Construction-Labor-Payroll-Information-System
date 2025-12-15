<?php

namespace App\Http\Controllers;

use App\Models\Paycheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaystubController extends Controller
{
    public function download($id)
    {
        $user = Auth::user();
        
        // Admin/Manager can download any paystub, Employee can only download their own
        if ($user->role === 'Admin' || $user->role === 'Manager') {
            $paycheck = Paycheck::with('user')->findOrFail($id);
            $employee = $paycheck->user;
        } else {
            $paycheck = Paycheck::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            $employee = $user;
        }
        
        // Generate HTML for PDF-like display
        $html = $this->generatePaystubHtml($paycheck, $employee);
        
        return response($html)
            ->header('Content-Type', 'text/html');
    }

    public function downloadPdf($id)
    {
        $user = Auth::user();
        
        // Admin/Manager can download any paystub, Employee can only download their own
        if ($user->role === 'Admin' || $user->role === 'Manager') {
            $paycheck = Paycheck::with('user')->findOrFail($id);
            $employee = $paycheck->user;
        } else {
            $paycheck = Paycheck::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            $employee = $user;
        }
        
        // Generate printable HTML that can be saved as PDF
        $html = $this->generatePaystubHtml($paycheck, $employee);
        
        return response($html)
            ->header('Content-Type', 'text/html');
    }

    private function generatePaystubHtml($paycheck, $user)
    {
        $payPeriodStart = \Carbon\Carbon::parse($paycheck->pay_period_start)->format('M d, Y');
        $payPeriodEnd = \Carbon\Carbon::parse($paycheck->pay_period_end)->format('M d, Y');
        $payDate = \Carbon\Carbon::parse($paycheck->pay_date)->format('M d, Y');
        
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Paystub - ' . htmlspecialchars($user->name) . '</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .paystub { max-width: 800px; margin: 0 auto; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border: 1px solid #e5e7eb; }
        .header { background: #ffffff; color: #1f2937; padding: 30px; border-bottom: 2px solid #e5e7eb; }
        .header h1 { font-size: 28px; margin-bottom: 5px; font-weight: 700; }
        .header p { color: #6b7280; font-size: 14px; }
        .content { padding: 30px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
        .info-box h3 { font-size: 12px; color: #6b7280; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px; }
        .info-box p { font-size: 16px; color: #1f2937; font-weight: 500; }
        .earnings-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .earnings-table th { background: #f9fafb; padding: 12px 16px; text-align: left; font-size: 12px; color: #6b7280; text-transform: uppercase; border-bottom: 2px solid #e5e7eb; }
        .earnings-table td { padding: 16px; border-bottom: 1px solid #e5e7eb; }
        .earnings-table .amount { text-align: right; font-weight: 600; }
        .earnings-table .deduction { color: #1f2937; }
        .total-row { background: #f9fafb; }
        .total-row td { font-weight: 700; font-size: 18px; }
        .total-row .net-pay { color: #1f2937; }
        .footer { background: #f9fafb; padding: 20px 30px; text-align: center; font-size: 12px; color: #6b7280; border-top: 1px solid #e5e7eb; }
        .status-badge { display: inline-block; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
        .print-btn { display: block; margin: 20px auto; padding: 12px 30px; background: white; color: #1f2937; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .print-btn:hover { background: #f9fafb; }
        .logo-section { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
        .logo-img { width: 40px; height: 40px; object-fit: contain; }
        @media print { 
            body { background: white; padding: 0; } 
            .paystub { box-shadow: none; border: none; } 
            .print-btn { display: none; }
        }
    </style>
</head>
<body>
    <div class="paystub">
        <div class="header">
            <div class="logo-section">
                <img src="/assets/images/logo1.png" alt="CLPIS" class="logo-img">
                <div>
                    <h1>CLPIS</h1>
                    <p>Construction Labor Payroll Information System</p>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="info-grid">
                <div class="info-box">
                    <h3>Employee</h3>
                    <p>' . htmlspecialchars($user->name) . '</p>
                    <p style="font-size: 14px; color: #6b7280; margin-top: 4px; font-weight: 400;">' . htmlspecialchars($user->email) . '</p>
                </div>
                <div class="info-box" style="text-align: right;">
                    <h3>Pay Period</h3>
                    <p>' . $payPeriodStart . ' - ' . $payPeriodEnd . '</p>
                    <p style="font-size: 14px; color: #6b7280; margin-top: 4px; font-weight: 400;">Pay Date: ' . $payDate . '</p>
                </div>
            </div>
            
            <table class="earnings-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    ' . ($paycheck->regular_pay > 0 ? '<tr>
                        <td>Regular Pay (' . number_format($paycheck->regular_hours, 1) . ' hrs)</td>
                        <td class="amount">₱' . number_format($paycheck->regular_pay, 2) . '</td>
                    </tr>' : '') . '
                    ' . ($paycheck->overtime_pay > 0 ? '<tr>
                        <td>Overtime Pay (' . number_format($paycheck->overtime_hours, 1) . ' hrs)</td>
                        <td class="amount" style="color: #d97706;">₱' . number_format($paycheck->overtime_pay, 2) . '</td>
                    </tr>' : '') . '
                    <tr style="background: #f9fafb;">
                        <td style="font-weight: 600;">Gross Pay</td>
                        <td class="amount" style="font-weight: 600;">₱' . number_format($paycheck->gross_pay, 2) . '</td>
                    </tr>
                    <tr>
                        <td>Total Deductions</td>
                        <td class="amount deduction">-₱' . number_format($paycheck->total_deductions, 2) . '</td>
                    </tr>
                    <tr class="total-row">
                        <td>Net Pay</td>
                        <td class="amount net-pay">₱' . number_format($paycheck->net_pay, 2) . '</td>
                    </tr>
                </tbody>
            </table>
            
            <div style="text-align: center;">
                <span class="status-badge">' . $paycheck->status . '</span>
            </div>
        </div>
        <div class="footer">
            <p>This is a computer-generated document. No signature required.</p>
            <p style="margin-top: 8px;">© ' . date('Y') . ' CLPIS - Construction Labor Payroll Information System</p>
        </div>
    </div>
    <button class="print-btn" onclick="window.print()">Print / Save as PDF</button>
</body>
</html>';
    }
}
