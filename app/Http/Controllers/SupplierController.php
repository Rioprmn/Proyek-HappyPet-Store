<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('admin.supplier-list', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.supplier-add');
    }

    public function store(Request $request)
    {
        Supplier::create($request->all());

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('admin.supplier-edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->update($request->all());

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil diupdate');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil dihapus');
    }
}