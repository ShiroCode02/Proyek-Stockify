{{-- resources/views/components/app-layout.blade.php --}}
@props(['title' => config('app.name', 'Stockify')])

{{-- 
    Komponen utama layout aplikasi
    File ini menjembatani penggunaan <x-app-layout>
    agar otomatis menggunakan layout utama dari resources/views/layouts/app.blade.php
--}}

@php
    // Pastikan variabel header dan slot tetap terbaca
    $header = $header ?? null;
    $slot = $slot ?? '';
@endphp

{{-- Render layout utama --}}
@include('layouts.app', [
    'title' => $title,
    'header' => $header,
    'slot' => $slot
])
