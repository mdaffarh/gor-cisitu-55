<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $membership = DB::select('SELECT * FROM membership');

        return view('dashboard.membership.index', compact('membership'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.membership.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_member' => 'required',
                'no_telp_member' => 'required'
            ]);
        } catch (ValidationException $e) {
            toast('Data gagal ditambahkan', 'error');
            return back()
                ->withInput()
                ->withErrors($e->validator);
        }

        DB::insert('INSERT INTO membership (nama_member, no_telp_member) VALUES (?, ?, ?)', [
            $request->nama_member,
            $request->no_telp_member
        ]);

        toast('Data berhasil ditambahkan', 'success');
        return redirect('/dashboard/membership');
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
        $membership = DB::select('SELECT * FROM membership WHERE id_member = ?', [$id]);

        return view('dashboard.membership.edit', ['membership' => $membership[0]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_member' => 'required',
                'no_telp_member' => 'required',
            ]);
        } catch (ValidationException $e) {
            toast('Data gagal diedit', 'error');
            return back()
                ->withInput()
                ->withErrors($e->validator);
        }

        DB::update('UPDATE membership SET nama_member = ?, no_telp_member = ? WHERE id_member = ?', [
            $request->nama_member,
            $request->no_telp_member,
            $id
        ]);

        toast('Data berhasil diedit', 'success');
        return redirect('/dashboard/membership');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::delete('DELETE FROM membership WHERE id_member = ?', [$id]);
        } catch (\Throwable $th) {
            toast('Data gagal dihapus', 'error');
            return back();
        }

        toast('Data berhasil dihapus', 'success');
        return redirect('/dashboard/membership');
    }
}
