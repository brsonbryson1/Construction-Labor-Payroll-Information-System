<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to CLPIS</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 500px; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                    {{-- Header --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); padding: 32px; text-align: center;">
                            <h1 style="margin: 0; color: white; font-size: 24px; font-weight: 700;">CLPIS</h1>
                            <p style="margin: 8px 0 0 0; color: rgba(255,255,255,0.9); font-size: 14px;">Construction Labor & Payroll System</p>
                        </td>
                    </tr>
                    
                    {{-- Content --}}
                    <tr>
                        <td style="padding: 32px;">
                            <h2 style="margin: 0 0 16px 0; color: #1f2937; font-size: 20px;">Welcome, {{ $userName }}!</h2>
                            
                            <p style="margin: 0 0 24px 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                Your account has been created on the CLPIS system. You can now access the portal to manage your time records and view your payroll information.
                            </p>
                            
                            {{-- Credentials Box --}}
                            <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                                <p style="margin: 0 0 12px 0; font-size: 13px; font-weight: 600; color: #374151;">Your Login Credentials:</p>
                                
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding: 8px 0; font-size: 13px; color: #6b7280; width: 80px;">Email:</td>
                                        <td style="padding: 8px 0; font-size: 14px; color: #1f2937; font-weight: 500;">{{ $userEmail }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; font-size: 13px; color: #6b7280;">Password:</td>
                                        <td style="padding: 8px 0; font-size: 14px; color: #1f2937; font-weight: 500; font-family: monospace; background: #fef3c7; padding: 4px 8px; border-radius: 4px; display: inline-block;">{{ $password }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; font-size: 13px; color: #6b7280;">Role:</td>
                                        <td style="padding: 8px 0; font-size: 14px; color: #1f2937; font-weight: 500;">{{ $role }}</td>
                                    </tr>
                                </table>
                            </div>
                            
                            {{-- Warning --}}
                            <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 12px 16px; margin-bottom: 24px; border-radius: 0 8px 8px 0;">
                                <p style="margin: 0; font-size: 13px; color: #b91c1c;">
                                    <strong>Important:</strong> Please change your password after your first login for security purposes.
                                </p>
                            </div>
                            
                            {{-- Button --}}
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/login') }}" style="display: inline-block; background: linear-gradient(135deg, #A99066 0%, #8B7355 100%); color: white; text-decoration: none; padding: 14px 32px; border-radius: 10px; font-size: 14px; font-weight: 600;">
                                            Login to CLPIS
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    {{-- Footer --}}
                    <tr>
                        <td style="padding: 24px 32px; background: #f9fafb; border-top: 1px solid #e5e7eb; text-align: center;">
                            <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                                This is an automated message from CLPIS.<br>
                                Please do not reply to this email.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
