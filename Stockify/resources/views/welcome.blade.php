<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Stockify - Manajemen Stok Efisien</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <style>
            * { box-sizing: border-box; }
            body { font-family: 'Figtree', sans-serif; margin: 0; background: #f3f4f6; color: #1f2937; }
            .hero { position: relative; min-height: 100vh; background: linear-gradient(135deg, #3b82f6 0%, #9333ea 100%); overflow: hidden; }
            .hero::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 10s infinite; pointer-events: none; } /* Tambah pointer-events: none */
            @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }
            .container { max-width: 80rem; margin: 0 auto; padding: 2rem; position: relative; z-index: 10; }
            .header { text-align: center; padding: 2rem 0; }
            .header h1 { font-size: 2.5rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem; animation: fadeInDown 1s ease; }
            .header p { font-size: 1.2rem; color: #e5e7eb; animation: fadeInDown 1.2s ease; }
            @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
            .nav { position: absolute; top: 1rem; right: 1rem; z-index: 20; } /* Tingkatkan z-index */
            .nav a { display: inline-block; padding: 0.75rem 1.5rem; color: #ffffff; font-weight: 600; text-decoration: none; transition: all 0.3s; min-width: 80px; text-align: center; cursor: pointer; } /* Tambah cursor: pointer */
            .nav a:hover { background: rgba(255,255,255,0.2); border-radius: 0.375rem; }
            .nav a + a { margin-left: 0.5rem; }
            .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 2rem; }
            .card { background: #ffffff; border-radius: 0.5rem; padding: 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s; }
            .card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }
            .card h2 { font-size: 1.5rem; font-weight: 600; color: #1f2937; margin-bottom: 0.75rem; }
            .card p { font-size: 0.95rem; color: #6b7280; line-height: 1.6; }
            .card-icon { width: 3rem; height: 3rem; background: #bfdbfe; border-radius: 9999px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
            .card-icon svg { width: 1.5rem; height: 1.5rem; stroke: #3b82f6; }
            .footer { text-align: center; padding: 2rem 0; color: #9ca3af; font-size: 0.875rem; }
            @media (max-width: 640px) { .nav { position: static; text-align: center; margin-bottom: 1rem; } .nav a { margin: 0 0.25rem; } }
            @media (prefers-color-scheme: dark) { body { background: #111827; color: #d1d5db; } .card { background: #1f2937; } .card-icon { background: #374151; } .card h2 { color: #f9fafb; } .card p { color: #9ca3af; } .hero { background: linear-gradient(135deg, #1e40af 0%, #6b21a8 100%); } .header h1, .header p { color: #ffffff; } .nav a { color: #d1d5db; } .nav a:hover { background: rgba(255,255,255,0.1); } }
        </style>
    </head>
    <body class="antialiased">
        <div class="hero">
            @if (Route::has('login'))
                <div class="nav z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="font-semibold ml-4">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="container">
                <div class="header">
                    <h1>Stockify</h1>
                    <p>Manajemen Stok Barang yang Efisien dan Terpercaya</p>
                </div>

                <div class="cards">
                    <div class="card">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m-6 0h12m6 0h-12m-6-6h12m6 0h-12" />
                            </svg>
                        </div>
                        <h2>Manajemen Produk</h2>
                        <p>Kelola data produk, kategori, dan stok dengan mudah melalui antarmuka yang intuitif.</p>
                    </div>

                    <div class="card">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75a.75.75 0 00-0.75.75v.75H3a.75.75 0 01.75.75v.75h0a.75.75 0 01-.75.75H3v.75A.75.75 0 013 11.25h-.75a.75.75 0 00-.75.75v.75H3a.75.75 0 01.75.75v.75h0a.75.75 0 01-.75.75H3v.75A.75.75 0 013 16.5h-.75a.75.75 0 00-.75.75v.75H3A.75.75 0 01.75 18v.75H3m0-16.5h.75v.75A.75.75 0 013 6h-.75" />
                            </svg>
                        </div>
                        <h2>Pelacakan Stok</h2>
                        <p>Monitor stok secara real-time dan dapatkan notifikasi saat stok mendekati batas minimum.</p>
                    </div>

                    <div class="card">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                        </div>
                        <h2>Pengguna Berbasis Role</h2>
                        <p>Kontrol akses dengan role Admin, Manager, dan Staff untuk keamanan dan efisiensi.</p>
                    </div>
                </div>

                <div class="footer">
                    Dibangun dengan Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>
    </body>
</html>