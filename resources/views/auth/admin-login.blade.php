<!DOCTYPE html>
<html>
<head>
    <title>Login Admin - Lautan Karir</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 50px auto; }
        input { width: 100%; padding: 10px; margin: 5px 0; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 14px; }
    </style>
</head>
<body>
    <h2>Login Admin / HR Pusat</h2>
    
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ url('/admin/login') }}">
        @csrf
        
        <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required autofocus>
        
        <input type="password" name="password" placeholder="Password" required>
        
        <label>
            <input type="checkbox" name="remember"> Ingat Saya
        </label>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>