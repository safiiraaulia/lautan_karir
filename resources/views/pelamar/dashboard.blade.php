<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Pelamar</title>
</head>
<body>
    <h1>Selamat Datang, {{ Auth::guard('pelamar')->user()->nama }}!</h1>
    <p>Username: {{ Auth::guard('pelamar')->user()->username }}</p>
    <p>Email: {{ Auth::guard('pelamar')->user()->email }}</p>
    
    <form method="POST" action="{{ route('pelamar.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>