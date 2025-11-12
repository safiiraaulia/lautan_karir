<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pelamar - Lautan Karir</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 50px auto; }
        input { width: 100%; padding: 10px; margin: 5px 0; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 14px; }
        a { color: #007bff; }
    </style>
</head>
<body>
    <h2>Daftar Akun Pelamar</h2>
    
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ url('/pelamar/register') }}">
        @csrf
        
        <input type="text" name="nama" placeholder="Nama Lengkap" value="{{ old('nama') }}" required autofocus>
        
        <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
        
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        
        <input type="text" name="nomor_whatsapp" placeholder="Nomor WhatsApp" value="{{ old('nomor_whatsapp') }}" required>
        
        <input type="password" name="password" placeholder="Password (min. 8 karakter)" required>
        
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
        
        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('pelamar.login') }}">Login di sini</a></p>
</body>
</html>