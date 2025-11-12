<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Selamat Datang, {{ Auth::guard('web')->user()->username }}!</h1>
    <p>Role: {{ Auth::guard('web')->user()->role }}</p>
    
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>