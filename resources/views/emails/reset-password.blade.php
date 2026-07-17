<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!--[if mso]>
    <style type="text/css">
        table { border-collapse: collapse; }
        body, h2, p, span, a { font-family: Arial, Helvetica, sans-serif !important; }
    </style>
    <![endif]-->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
    </style>
</head>

<body style="margin:0; padding:0; background-color:#f1f2f7; font-family:'Poppins', Arial, Helvetica, sans-serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
        style="background-color:#f1f2f7; padding:48px 16px;">
        <tr>
            <td align="center">

                <table role="presentation" width="520" cellpadding="0" cellspacing="0"
                    style="max-width:520px; width:100%;">

                    <!-- Logo / brand row (outside card) -->
                    <tr>
                        <td align="center" style="padding-bottom:24px;">
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td
                                        style="width:40px; height:40px; background-color:#3730a3; border-radius:12px; text-align:center; vertical-align:middle;">
                                        <span style="font-size:20px; line-height:40px;">📚</span>
                                    </td>
                                    <td style="padding-left:10px; vertical-align:middle;">
                                        <span
                                            style="font-family:'Poppins', Arial, sans-serif; font-size:16px; font-weight:700; color:#1f2937; letter-spacing:-0.2px;">Perpustakaan
                                            Digital</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Card -->
                    <tr>
                        <td
                            style="background-color:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 4px 24px rgba(17,24,39,0.06); border:1px solid #eef0f4;">

                            <!-- Top accent bar -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="height:6px; background:linear-gradient(90deg,#4338ca,#6366f1);"></td>
                                </tr>
                            </table>

                            <!-- Icon badge -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding:40px 40px 0 40px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td
                                                    style="width:64px; height:64px; background-color:#eef2ff; border-radius:50%; text-align:center; vertical-align:middle;">
                                                    <span style="font-size:28px; line-height:64px;">🔐</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Body text -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:24px 40px 0 40px;" align="center">
                                        <h2
                                            style="margin:0 0 12px 0; font-family:'Poppins', Arial, sans-serif; font-size:22px; color:#111827; font-weight:700; letter-spacing:-0.3px;">
                                            Reset Password Anda
                                        </h2>
                                        <p
                                            style="margin:0; font-family:'Poppins', Arial, sans-serif; font-size:15px; color:#6b7280; line-height:1.65; font-weight:400;">
                                            Halo <strong
                                                style="color:#111827; font-weight:600;">{{ $anggota->nama }}</strong>,
                                            kami menerima permintaan untuk mengatur ulang password akun Perpustakaan
                                            Digital Anda.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Button -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding:32px 40px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="border-radius:12px; background-color:#3730a3;">
                                                    <a href="{{ $url }}" target="_blank"
                                                        style="display:inline-block; padding:15px 36px; font-family:'Poppins', Arial, sans-serif; font-size:15px; font-weight:600; color:#ffffff; text-decoration:none; border-radius:12px; letter-spacing:0.2px;">
                                                        Reset Password Sekarang
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                        <p
                                            style="margin:16px 0 0 0; font-family:'Poppins', Arial, sans-serif; font-size:12.5px; color:#9ca3af; font-weight:400;">
                                            atau salin dan tempel tautan ini ke browser Anda
                                        </p>
                                        <p
                                            style="margin:6px 0 0 0; font-family:'Poppins', Arial, sans-serif; font-size:12.5px; color:#6366f1; word-break:break-all; font-weight:500;">
                                            {{ $url }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:0 40px;">
                                        <div style="border-top:1px solid #f0f1f5;"></div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Info row -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:24px 40px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                            style="background-color:#f9fafb; border-radius:12px;">
                                            <tr>
                                                <td style="padding:16px 18px;">
                                                    <table role="presentation" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="vertical-align:top; padding-right:10px;">
                                                                <span style="font-size:16px;">⏱️</span>
                                                            </td>
                                                            <td>
                                                                <p
                                                                    style="margin:0; font-family:'Poppins', Arial, sans-serif; font-size:13px; color:#374151; line-height:1.5; font-weight:400;">
                                                                    <strong style="font-weight:600;">Link berlaku 60
                                                                        menit.</strong><br>
                                                                    Setelah itu Anda perlu meminta link reset yang baru.
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Footer note inside card -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:0 40px 36px 40px;">
                                        <p
                                            style="margin:0; font-family:'Poppins', Arial, sans-serif; font-size:13px; color:#9ca3af; line-height:1.6; text-align:center; font-weight:400;">
                                            Jika Anda tidak meminta reset password ini, abaikan saja email ini — akun
                                            Anda tetap aman dan password tidak akan berubah.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Bottom footer -->
                    <tr>
                        <td align="center" style="padding-top:28px;">
                            <p
                                style="margin:0; font-family:'Poppins', Arial, sans-serif; font-size:12px; color:#9ca3af; line-height:1.6; font-weight:400;">
                                &copy; {{ date('Y') }} Perpustakaan Digital &middot; Email otomatis, mohon tidak
                                membalas.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
