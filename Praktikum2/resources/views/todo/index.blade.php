<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 32px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 8px; border: 1px solid #ddd; }
        th { background: #f4f4f4; }
        .done { color: green; font-weight: bold; }
        .not-done { color: #c0392b; }
    </style>
</head>
<body>
    <h1>Todo List</h1>
    <p>Data milik user: <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})</p>

    @if($todos->isEmpty())
        <p>Tidak ada todo untuk user ini.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($todos as $todo)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $todo->title }}</td>
                        <td>{{ $todo->description }}</td>
                        <td class="{{ $todo->is_done ? 'done' : 'not-done' }}">
                            {{ $todo->is_done ? 'Selesai' : 'Belum selesai' }}
                        </td>
                        <td>{{ $todo->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
