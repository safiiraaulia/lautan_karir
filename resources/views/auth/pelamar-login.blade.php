<!DOCTYPE html>
<html>
<head>
    <title>Login Pelamar - Lautan Karir</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 50px auto; }
        input { width: 100%; padding: 10px; margin: 5px 0; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 14px; }
        a { color: #007bff; }
    </style>
</head>
<body>
    <h2>Login Pelamar</h2>
    
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ url('/pelamar/login') }}">
        @csrf
        
        <input type="text" name="username" placeholder="Username atau Email" value="{{ old('username') }}" required autofocus>
        
        <input type="password" name="password" placeholder="Password" required>
        
        <label>
            <input type="checkbox" name="remember"> Ingat Saya
        </label>
        
        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="{{ route('pelamar.register') }}">Daftar di sini</a></p>
</body>
</html>