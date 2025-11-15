@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h3>Selamat Datang</h3>
    <p>Halo {{ Auth::user()->username }}!</p>
@endsection
