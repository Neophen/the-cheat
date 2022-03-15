<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

  <meta name="description" content="Easy way to create cheat sheets" />

  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
  <link rel="manifest" href="/site.webmanifest" />
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5" />
  <meta name="msapplication-TileColor" content="#da532c" />
  <meta name="theme-color" content="#D946EF" />



  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@700;800;900&family=Lato:wght@400;700;900&display=swap" rel="stylesheet">

  @production
  @php
  $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
  @endphp
  <script type="module" src="/build/{{ $manifest['app_client/app.ts']['file'] }}"></script>
  <link rel="stylesheet" href="/build/{{ $manifest['app_client/app.ts']['css'][0] }}">
  @else
  <script type="module" src="http://localhost:3030/@vite/client"></script>
  <script type="module" src="http://localhost:3030/app_client/app.ts"></script>
  @endproduction

  @inertiaHead
</head>

<body class="h-full">
  @inertia
</body>

</html>
