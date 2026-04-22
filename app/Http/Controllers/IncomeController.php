<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Income::query();

        // Search
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $incomes = $query->latest()->get();

        return response()->json($incomes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:1',
            'category' => 'required',
        ]);

        DB::transaction(function () use ($request) {

            $income = Income::create([
                'date' => $request->date,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity ?? 1,
                'category' => $request->category,
                'bank_account' => $request->bank_account,
                'notes' => $request->notes,
                'created_by' => auth()->id(),
            ]);

            logActivity(
                'create',
                'income',
                'Menambahkan income: ' . $income->name
            );
        });

        return response()->json(['message' => 'Income berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $income = Income::findOrFail($id);

        $request->validate([
            'date' => 'required|date',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $income) {

            $income->update($request->all());

            logActivity(
                'update',
                'income',
                'Update income: ' . $income->name
            );
        });

        return response()->json(['message' => 'Income berhasil diupdate']);
    }

    public function destroy($id)
    {
        $income = Income::findOrFail($id);

        DB::transaction(function () use ($income) {

            $name = $income->name;
            $income->delete();

            logActivity(
                'delete',
                'income',
                'Hapus income: ' . $name
            );
        });

        return response()->json(['message' => 'Income berhasil dihapus']);
    }
}
