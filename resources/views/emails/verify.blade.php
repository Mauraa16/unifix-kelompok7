<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        /* CSS Reset untuk Email Client */
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; width: 100%; -webkit-text-size-adjust: none; }
        .wrapper { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 40px 20px; border-radius: 8px; margin-top: 40px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #7e22ce; text-decoration: none; }
        .content { color: #374151; line-height: 1.6; font-size: 16px; }
        .btn-container { text-align: center; margin: 30px 0; }
        .btn { display: inline-block; background-color: #7e22ce; color: #ffffff !important; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #9ca3af; }
        .link-break { word-break: break-all; color: #7e22ce; }
    </style>
</head>
<body>
    <div style="background-color: #f3f4f6; padding: 40px 0;">
        <div class="wrapper">
            <div class="header">
                {{-- Ganti URL logo dengan logo online jika ada, atau teks saja --}}
                <a href="{{ url('/') }}" class="logo">UNIFIX</a>
            </div>

            <div class="content">
                <p>Halo, <strong>{{ $user->name }}</strong>!</p>
                <p>Terima kasih telah mendaftar di UNIFIX. Untuk mulai menggunakan akun Anda dan melaporkan fasilitas kampus, mohon verifikasi alamat email Anda terlebih dahulu.</p>
                
                <div class="btn-container">
                    <a href="{{ $url }}" class="btn">Verifikasi Email Saya</a>
                </div>

                <p>Jika Anda tidak merasa mendaftar di UNIFIX, abaikan email ini.</p>
                <p>Salam hangat,<br>Tim UNIFIX</p>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 20px;">
                <p style="font-size: 12px; color: #6b7280;">Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:</p>
                <p style="font-size: 12px;"><a href="{{ $url }}" class="link-break">{{ $url }}</a></p>
            </div>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} UNIFIX. All rights reserved.
        </div>
    </div>
</body>
</html>