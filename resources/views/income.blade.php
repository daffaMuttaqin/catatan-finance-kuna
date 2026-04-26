<!DOCTYPE html>
<html>
<head>
    <title>Income</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-4">Income Management</h1>

    <!-- NOTIF -->
    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- FORM -->
    <form method="POST" action="/incomes" class="grid grid-cols-2 gap-4 mb-6">
        @csrf

        <input type="date" name="date" class="border p-2 rounded" required>

        <input type="text" name="name" placeholder="Nama Produk" class="border p-2 rounded" required>

        <input type="number" name="price" placeholder="Harga" class="border p-2 rounded" required>

        <input type="number" name="quantity" placeholder="Quantity" class="border p-2 rounded">

        <select name="category" class="border p-2 rounded" required>
            <option value="">Pilih Kategori</option>
            <option>Cheesecake</option>
            <option>Brownies</option>
            <option>Cookies</option>
            <option>Snack</option>
        </select>

        <input type="text" name="bank_account" placeholder="Bank (optional)" class="border p-2 rounded">

        <textarea name="notes" placeholder="Notes" class="border p-2 rounded col-span-2"></textarea>

        <button class="bg-blue-500 text-white p-2 rounded col-span-2">
            Tambah Income
        </button>
    </form>

    <!-- TABLE -->
    <table class="w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Tanggal</th>
                <th class="p-2">Nama</th>
                <th class="p-2">Qty</th>
                <th class="p-2">Kategori</th>
                <th class="p-2">Harga</th>
                <th class="p-2">Bank</th>
                <th class="p-2">Notes</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incomes as $item)
            <tr class="border-b">
                <td class="p-2">{{ $item->date }}</td>
                <td class="p-2">{{ $item->name }}</td>
                <td class="p-2">{{ $item->quantity ?? 1 }}</td>
                <td class="p-2">{{ $item->category }}</td>
                <td class="p-2">Rp {{ number_format($item->price) }}</td>
                <td class="p-2">{{ $item->bank_account }}</td>
                <td class="p-2">{{ $item->notes }}</td>
                <td class="p-2">
                    <form method="POST" action="/incomes/{{ $item->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-2 py-1 rounded">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

</body>
</html>