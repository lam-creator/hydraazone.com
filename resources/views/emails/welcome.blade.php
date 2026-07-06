<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Welcome to {{ config('app.name') }}</title>
</head>

<body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;color:#333;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f7fb;padding:40px 15px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 8px 25px rgba(0,0,0,.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="background:linear-gradient(135deg,#0d6efd,#4f8cff);padding:40px 30px;color:#ffffff;">

                            <h1 style="margin:0;font-size:30px;font-weight:700;">
                                Welcome 🎉
                            </h1>

                            <p style="margin:12px 0 0;font-size:16px;opacity:.95;">
                                Thank you for joining {{ config('app.name') }}
                            </p>

                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:35px;">

                            <h2 style="margin-top:0;color:#222;">
                                Hello {{ $user->name }},
                            </h2>

                            <p style="font-size:15px;line-height:26px;color:#555;">
                                Your account has been created successfully. Below are your login details.
                            </p>

                            <!-- Account Box -->
                            <table width="100%" cellpadding="12" cellspacing="0"
                                style="background:#f8f9fc;border:1px solid #e9ecef;border-radius:8px;">

                                <tr>
                                    <td width="35%">
                                        <strong>Name</strong>
                                    </td>
                                    <td>{{ $user->name }}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>Email</strong>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>Phone</strong>
                                    </td>
                                    <td>{{ $user->phone }}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>Password</strong>
                                    </td>
                                    <td>
                                        <span style="background:#fff3cd;padding:6px 10px;border-radius:5px;font-weight:bold;color:#856404;">
                                            {{ $password }}
                                        </span>
                                    </td>
                                </tr>

                            </table>

                            <!-- Notice -->
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="margin-top:25px;background:#fff8e6;border-left:4px solid #ffc107;border-radius:6px;">
                                <tr>
                                    <td style="padding:15px;font-size:14px;color:#6c5700;line-height:22px;">
                                        <strong>Security Notice</strong><br>
                                        Please log in and change your password as soon as possible to keep your account secure.
                                    </td>
                                </tr>
                            </table>

                            <!-- Button -->
                            <table cellpadding="0" cellspacing="0" style="margin:35px auto;">
                                <tr>
                                    <td align="center"
                                        style="background:#0d6efd;border-radius:6px;">
                                        <a href="{{ route('user.login') }}"
                                            style="display:inline-block;padding:14px 30px;color:#ffffff;text-decoration:none;font-weight:bold;font-size:15px;">
                                            Login to Your Account
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:15px;color:#555;line-height:24px;">
                                Thank you for shopping with us. We hope you enjoy your experience.
                            </p>

                            <p style="margin-top:35px;color:#666;font-size:14px;">
                                Best Regards,<br>
                                <strong>{{ config('app.name') }}</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="background:#f8f9fa;padding:20px;color:#888;font-size:13px;">

                            © {{ date('Y') }} {{ config('app.name') }}<br>
                            This is an automated email. Please do not reply.

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
