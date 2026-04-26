<!DOCTYPE html>
<html>
<head>
    <title>Activity Logs</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-4">Activity Logs</h1>

    <!-- SEARCH -->
    <form method="GET" class="mb-4 flex gap-2">
        <input 
            type="text" 
            name="search" 
            placeholder="Search activity..." 
            value="{{ request('search') }}"
            class="border p-2 rounded w-full"
        >
        <button class="bg-blue-500 text-white px-4 rounded">Search</button>
    </form>

    <!-- TABLE -->
    <table class="w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Waktu</th>
                <th class="p-2">Admin</th>
                <th class="p-2">Aksi</th>
                <th class="p-2">Module</th>
                <th class="p-2">Detail</th>
            </tr>
        </thead>

        <tbody>
            @forelse($logs as $log)
            <tr class="border-b">
                <td class="p-2">
                    {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}
                </td>
                <td class="p-2">{{ $log->admin_name ?? '-' }}</td>
                <td class="p-2 capitalize">{{ $log->action }}</td>
                <td class="p-2 capitalize">{{ $log->module }}</td>
                <td class="p-2">{{ $log->detail }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center p-4">Belum ada aktivitas</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

</body>
</html>