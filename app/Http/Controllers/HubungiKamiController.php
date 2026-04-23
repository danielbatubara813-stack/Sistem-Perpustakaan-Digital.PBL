<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HubungiKamiController extends Controller
{
    public function hubungiKamiPage()
    {
        return view('hubungi-kami');
    }
    public function kirimPesan(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
            'judul' => ['required', 'string', 'max:255'],
            'pesan' => ['required', 'string'],
        ]);

        Mail::send([], [], function ($message) use ($validated) {
            $message->to('franklinchang0129@gmail.com')
                ->replyTo($validated['email'], $validated['nama'])
                ->subject($validated['judul'])
                ->html("
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<link href='https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap' rel='stylesheet'>
</head>
<body style='margin:0; padding:0; background:#f1f5f9; font-family: 'Poppins', Arial, sans-serif;'>

    <div style='max-width:600px; margin:40px auto; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 8px 20px rgba(0,0,0,0.08);'>

        <div style='background:linear-gradient(135deg,#1d4ed8,#2563eb); padding:24px; text-align:center; color:white;'>
            <h1 style='margin:0; font-size:24px;'>📩 Pesan Baru</h1>
            <p style='margin:8px 0 0; font-size:14px; opacity:0.9;'>
                Anda menerima pesan baru dari pengguna website Perpustakaan Polibatam
            </p>
        </div>

        <div style='padding:30px;'>

            <table style='width:100%; border-collapse:collapse;'>
                <tr>
                    <td style='padding:12px 0; color:#64748b; width:120px; font-weight:bold;'>Nama</td>
                    <td style='padding:12px 0; color:#0f172a;'>{$validated['nama']}</td>
                </tr>

                <tr>
                    <td style='padding:12px 0; color:#64748b; font-weight:bold;'>Email</td>
                    <td style='padding:12px 0; color:#0f172a;'>{$validated['email']}</td>
                </tr>

                <tr>
                    <td style='padding:12px 0; color:#64748b; font-weight:bold;'>Subjek</td>
                    <td style='padding:12px 0; color:#0f172a;'>{$validated['judul']}</td>
                </tr>
            </table>

            <div style='margin-top:24px;'>
                <p style='margin:0 0 10px; color:#64748b; font-weight:bold;'>Pesan</p>

                <div style='background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:18px; color:#334155; line-height:1.7;'>
                    " . nl2br(e($validated['pesan'])) . "
                </div>
            </div>

        </div>

        <div style='background:#f8fafc; padding:18px; text-align:center; font-size:12px; color:#94a3b8;'>
            Email ini dikirim otomatis dari form hubungi kami website.
        </div>

    </div>

</body>
</html>
");
        });

        return redirect()->route('hubungi-kami-page')->with('success', 'Pesan berhasil dikirim!');
    }
}
