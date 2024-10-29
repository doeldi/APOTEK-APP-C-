<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * R: read, menampilkan form untuk menambahkan data
     */
    public function index(Request $request)
    {
        // Ambil data obat berdasarkan kata kunci pencarian, masing-masing diurutkan berdasarkan nama dan stock
        $medicines = Medicine::where('name', 'LIKE', '%' . $request->search_obat . '%');

        if ($request->sort_stock === 'low') {
            $medicines->orderBy('stock', 'ASC');
        } elseif ($request->sort_stock === 'high') {
            $medicines->orderBy('stock', 'DESC');
        } else {
            $medicines->orderBy('name', 'ASC');
        }

        $medicines = $medicines->simplePaginate(5);

        return view('medicine.index', compact('medicines'));
    }

    /**
     * C: create, Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate(
            [
                'name' => 'required|max:100',
                'type' => 'required|min:3',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
            ],
            [
                'name.required' => 'Nama obat harus diisi',
                'type.required' => 'Jenis obat harus diisi',
                'price.required' => 'Harga obat harus diisi',
                'stock.required' => 'Stok obat harus diisi',
                'name.max' => 'Nama obat maksimal 100 karakter',
                'type.min' => 'Jenis obat minimal 3 karakter',
                'price.numeric' => 'Harga obat harus berupa angka',
                'stock.numeric' => 'Stok obat harus berupa angka',
            ]
        );

        Medicine::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan data obat!');
    }

    /**
     * R: read, Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * U: update, Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medicine = Medicine::where('id', $id)->first();

        return view('medicine.edit', compact('medicine'));
    }

    /**
     * U: Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'type' => 'required|min:3',
            'price' => 'required|numeric',
        ]);

        Medicine::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
        ]);

        return redirect()->route('obat.data_obat')->with('success', 'Berhasil mengupdate data obat!');
    }

    /**
     * D: delete, Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteData = Medicine::where('id', $id)->delete();

        if ($deleteData) {
            return redirect()->back()->with('deleted', 'Menghapus data obat!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data obat!');
        }
    }

    // function for update stock
    public function updateStock(Request $request, $id)
    {
        if (isset($request->stock) == FALSE) {  
            $dataSebelumnya = Medicine::where('id', $id)->first();

            return redirect()->back()->with([
                'failed' => 'Stok obat harus diisi!',
                'id' => $id,
                'stock' => $dataSebelumnya->stock,
            ]);
        }

        Medicine::where('id', $id)->update([
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil mengubah stok obat!');
    }
}
