<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FasilitasTambahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fasilitas_tambahan = DB::select('SELECT * FROM fasilitas_tambahan');

        return view('dashboard.fasilitas_tambahan.index', compact('fasilitas_tambahan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.fasilitas_tambahan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'harga_fasilitas_tambahan' => 'required',
                'jenis_fasilitas_tambahan' => 'required',
            ]);
        } catch (ValidationException $e) {
            toast('Data gagal ditambahkan', 'error');
            return back()
                ->withInput()
                ->withErrors($e->validator);
        }

        DB::insert('INSERT INTO fasilitas_tambahan (jenis_fasilitas_tambahan, harga_fasilitas_tambahan) VALUES (?, ?, ?)', [
            $request->jenis_fasilitas_tambahan,
            $request->harga_fasilitas_tambahan
        ]);

        toast('Data berhasil ditambahkan', 'success');
        return redirect('/dashboard/fasilitas_tambahan');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fasilitas_tambahan = DB::select('SELECT * FROM fasilitas_tambahan WHERE id_fasilitas_tambahan = ?', [$id]);

        return view('dashboard.fasilitas_tambahan.edit', ['fasilitas_tambahan' => $fasilitas_tambahan[0]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'jenis_fasilitas_tambahan' => 'required',
                'harga_fasilitas_tambahan' => 'required',
            ]);
        } catch (ValidationException $e) {
            toast('Data gagal diedit', 'error');
            return back()
                ->withInput()
                ->withErrors($e->validator);
        }

        DB::update('UPDATE fasilitas_tambahan SET jenis_fasilitas_tambahan = ?, harga_fasilitas_tambahan = ? WHERE id_fasilitas_tambahan = ?', [
            $request->jenis_fasilitas_tambahan,
            $request->harga_fasilitas_tambahan,
            $id
        ]);

        toast('Data berhasil diedit', 'success');
        return redirect('/dashboard/fasilitas_tambahan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::delete('DELETE FROM fasilitas_tambahan WHERE id_fasilitas_tambahan = ?', [$id]);
        } catch (\Throwable $th) {
            toast('Data gagal dihapus', 'error');
            return back();
        }

        toast('Data berhasil dihapus', 'success');
        return redirect('/dashboard/fasilitas_tambahan');
    }
}
