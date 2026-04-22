<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::query();

        // Search
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $expenses = $query->latest()->get();

        return response()->json($expenses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'name' => 'required',
            'category' => 'required',
        ]);

        DB::transaction(function () use ($request) {

            $expense = Expense::create([
                'date' => $request->date,
                'name' => $request->name,
                'size' => $request->size,
                'quantity' => $request->quantity,
                'category' => $request->category,
                'bank_account' => $request->bank_account,
                'notes' => $request->notes,
                'created_by' => auth()->id(),
            ]);

            logActivity(
                'create',
                'expense',
                'Menambahkan expense: ' . $expense->name
            );
        });

        return response()->json(['message' => 'Expense berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        $request->validate([
            'date' => 'required|date',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $expense) {

            $expense->update($request->all());

            logActivity(
                'update',
                'expense',
                'Update expense: ' . $expense->name
            );
        });

        return response()->json(['message' => 'Expense berhasil diupdate']);
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);

        DB::transaction(function () use ($expense) {

            $name = $expense->name;
            $expense->delete();

            logActivity(
                'delete',
                'expense',
                'Hapus expense: ' . $name
            );
        });

        return response()->json(['message' => 'Expense berhasil dihapus']);
    }
}
