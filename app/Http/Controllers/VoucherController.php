<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $voucher = DB::select('SELECT * FROM voucher');

        return view('dashboard.voucher.index', compact('voucher'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.voucher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'jenis_voucher' => 'required',
                'nilai_voucher' => 'required'
            ]);
        } catch (ValidationException $e) {
            toast('Data gagal ditambahkan', 'error');
            return back()
                ->withInput()
                ->withErrors($e->validator);
        }

        DB::insert('INSERT INTO voucher (jenis_voucher, nilai_voucher) VALUES (?, ?)', [
            $request->jenis_voucher,
            $request->nilai_voucher
        ]);

        toast('Data berhasil ditambahkan', 'success');
        return redirect('/dashboard/voucher');
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
        $voucher = DB::select('SELECT * FROM voucher WHERE id_voucher = ?', [$id]);

        return view('dashboard.voucher.edit', ['voucher' => $voucher[0]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'jenis_voucher' => 'required',
                'nilai_voucher' => 'required'
            ]);
        } catch (ValidationException $e) {
            toast('Data gagal diedit', 'error');
            return back()
                ->withInput()
                ->withErrors($e->validator);
        }

        DB::update('UPDATE voucher SET jenis_voucher = ?, nilai_voucher = ? WHERE id_voucher = ?', [
            $request->jenis_voucher,
            $request->nilai_voucher,
            $id
        ]);

        toast('Data berhasil diedit', 'success');
        return redirect('/dashboard/voucher');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::delete('DELETE FROM voucher WHERE id_voucher = ?', [$id]);
        } catch (\Throwable $th) {
            toast('Data gagal dihapus', 'error');
            return back();
        }

        toast('Data berhasil dihapus', 'success');
        return redirect('/dashboard/voucher');
    }
}
