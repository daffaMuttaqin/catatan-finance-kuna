<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Income</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-4">Income Management</h1>

    <!-- FORM -->
    <form id="incomeForm" class="grid grid-cols-2 gap-4 mb-6">

        <input type="date" name="date" class="border p-2 rounded" required>

        <input type="text" name="name" placeholder="Nama Produk" class="border p-2 rounded" required>

        <input type="number" name="price" placeholder="Harga" class="border p-2 rounded" required>

        <input type="number" name="quantity" placeholder="Quantity" class="border p-2 rounded">

        <select name="category" class="border p-2 rounded" required>
            <option value="">Pilih Kategori</option>
            <option>Cheesecake</option>
            <option>Brownies</option>
            <option>Cookies</option>
        </select>

        <input type="text" name="bank_account" placeholder="Bank (optional)" class="border p-2 rounded">

        <textarea name="notes" placeholder="Notes" class="border p-2 rounded col-span-2"></textarea>

        <button class="bg-blue-500 text-black p-2 rounded col-span-2">
            Tambah Income
        </button>

    </form>

    <!-- TABLE -->
    <table class="w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Tanggal</th>
                <th class="p-2">Nama</th>
                <th class="p-2">Harga</th>
                <th class="p-2">Qty</th>
                <th class="p-2">Kategori</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody id="incomeTable"></tbody>
    </table>

</div>

<script>
async function loadData() {
    const res = await fetch('/incomes');
    const data = await res.json();

    let html = '';

    data.forEach(item => {
        html += `
            <tr class="border-b">
                <td class="p-2">${item.date}</td>
                <td class="p-2">${item.name}</td>
                <td class="p-2">${item.price}</td>
                <td class="p-2">${item.quantity ?? 1}</td>
                <td class="p-2">${item.category}</td>
                <td class="p-2">
                    <button onclick="deleteData(${item.id})" class="bg-red-500 text-black px-2 py-1 rounded">Delete</button>
                </td>
            </tr>
        `;
    });

    document.getElementById('incomeTable').innerHTML = html;
}

document.getElementById('incomeForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = new FormData(e.target);

    await fetch('/incomes', {
        method: 'POST',
        headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: form
    });

    e.target.reset();
    loadData();
});

async function deleteData(id) {
    await fetch(`/incomes/${id}`, {
        method: 'DELETE',
        headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });

    loadData();
}

loadData();
</script>

</body>
</html>