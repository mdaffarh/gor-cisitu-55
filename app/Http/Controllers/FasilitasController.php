<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fasilitas = DB::select('SELECT * FROM fasilitas');

        return view('dashboard.fasilitas.index', compact('fasilitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.fasilitas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_lapangan' => 'required',
                'harga_lapangan' => 'required',
                'harga_tournament' => 'required'
            ]);
        } catch (ValidationException $e) {
            toast('Data gagal ditambahkan', 'error');
            return back()
                ->withInput()
                ->withErrors($e->validator);
        }

        DB::insert('INSERT INTO fasilitas (nama_lapangan, harga_lapangan, harga_tournament) VALUES (?, ?, ?)', [
            $request->nama_lapangan,
            $request->harga_lapangan,
            $request->harga_tournament
        ]);

        toast('Data berhasil ditambahkan', 'success');
        return redirect('/dashboard/fasilitas');
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
        $fasilitas = DB::select('SELECT * FROM fasilitas WHERE id_lapangan = ?', [$id]);

        return view('dashboard.fasilitas.edit', ['fasilitas' => $fasilitas[0]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_lapangan' => 'required',
                'harga_lapangan' => 'required',
                'harga_tournament' => 'required'
            ]);
        } catch (ValidationException $e) {
            toast('Data gagal diedit', 'error');
            return back()
                ->withInput()
                ->withErrors($e->validator);
        }

        DB::update('UPDATE fasilitas SET nama_lapangan = ?, harga_lapangan = ?, harga_tournament = ? WHERE id_lapangan = ?', [
            $request->nama_lapangan,
            $request->harga_lapangan,
            $request->harga_tournament,
            $id
        ]);

        toast('Data berhasil diedit', 'success');
        return redirect('/dashboard/fasilitas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::delete('DELETE FROM fasilitas WHERE id_lapangan = ?', [$id]);
        } catch (\Throwable $th) {
            toast('Data gagal dihapus', 'error');
            return back();
        }

        toast('Data berhasil dihapus', 'success');
        return redirect('/dashboard/fasilitas');
    }
}
