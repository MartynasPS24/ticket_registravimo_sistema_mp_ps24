<!doctype html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Aktyvūs ticketai</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin: 0 0 10px 0; }
        .meta { margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #444; padding: 6px; vertical-align: top; }
        th { background: #eee; }
        .small { font-size: 11px; color: #333; }
    </style>
</head>
<body>

<h1>Aktyvių ticket's ataskaita</h1>
<div class="meta small">
    Sugeneruota: {{ $generatedAt }} <br>
</div>

<table>
    <thead>
    <tr>
        <th style="width: 6%;">ID</th>
        <th style="width: 30%;">Pavadinimas</th>
        <th style="width: 18%;">Kategorija</th>
        <th style="width: 16%;">Statusas</th>
        <th style="width: 30%;">Savininkas</th>
    </tr>
    </thead>
    <tbody>
    @forelse($tickets as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->title }}</td>
            <td>{{ $t->category?->name }}</td>
            
            <td>
                {{ match($t->status) {
                    'new' => 'Naujas',
                    'in_progress' => 'Vykdomas',
                    'done' => 'Užbaigtas',
                    default => $t->status,
                } }}
            </td>

            <td>{{ $t->user?->name }} ({{ $t->user?->email }})</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">Aktyvių ticket's nėra.</td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>
