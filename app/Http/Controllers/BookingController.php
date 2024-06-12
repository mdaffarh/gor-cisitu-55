<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booking = DB::select('SELECT b.*, m.* FROM booking b LEFT JOIN membership m ON b.id_member = m.id_member ORDER BY b.id_booking DESC');

        return view('dashboard.booking.index', [
            'booking' => $booking
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $membership = DB::select('SELECT * FROM membership');
        $voucher = DB::select('SELECT * FROM voucher');
        $fasilitas = DB::select('SELECT * FROM fasilitas');
        return view('dashboard.booking.create', [
            'membership' => $membership,
            'voucher' => $voucher,
            'fasilitas' => $fasilitas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $request->validate([
                'tanggal_mulai' => 'required|after_or_equal:today',
                'tanggal_akhir' => 'required|after_or_equal:tanggal_mulai',
                'waktu_mulai' => 'required',
                'waktu_selesai' => 'required',
            ]);
        } catch (ValidationException $e) {
            toast('Data gagal ditambahkan', 'error');
            return back()
                ->withInput()
                ->withErrors($e->validator);
        }

        // cari harga satuan
        $harga = 65000; // harga normal
        if ($request->turnamen) {
            $harga += 20000;
        }

        if ($request->voucher) {
            $voucher = DB::select('SELECT * FROM voucher WHERE id_voucher = ?', [
                $request->voucher
            ]);
            $harga -= ($voucher[0]->nilai_voucher);
        }

        // hitung total
        $total = 0;

        // cari durasi_hari
        $tanggal_mulai = Carbon::parse($request->tanggal_mulai);
        $tanggal_akhir = Carbon::parse($request->tanggal_akhir);
        $durasi_hari = $tanggal_mulai->diffInDays($tanggal_akhir);
        $durasi_hari++;

        // durasi jam
        $waktu_mulai = Carbon::createFromFormat('H:i', $request->waktu_mulai);
        $waktu_selesai = Carbon::createFromFormat('H:i', $request->waktu_selesai);
        $durasi_jam = $waktu_mulai->diffInHours($waktu_selesai);


        // cari total lapangan
        $lapanganCount = 0;
        for ($i = 1; $i <= 4; $i++) {
            $field = 'lapangan' . $i;
            if ($request->has($field)) {
                // check availablity
                $lapanganCount++;
                $check = DB::select('SELECT * FROM jadwal 
                WHERE id_lapangan = ? AND status_jadwal != ?
                AND ((tanggal_mulai >= ? AND tanggal_mulai <= ?)
                    OR (tanggal_akhir >= ? AND tanggal_akhir <= ?)
                    OR (tanggal_mulai <= ? AND tanggal_akhir >= ?))
                AND ((waktu_mulai >= ? AND waktu_mulai < ?)
                    OR (waktu_selesai > ? AND waktu_selesai <= ?)
                    OR (waktu_mulai <= ? AND waktu_selesai >= ?))
                LIMIT 1', [
                    $request->$field,
                    'canceled',

                    $request->tanggal_mulai,
                    $request->tanggal_akhir,
                    $request->tanggal_mulai,
                    $request->tanggal_akhir,
                    $request->tanggal_mulai,
                    $request->tanggal_akhir,

                    $request->waktu_mulai,
                    $request->waktu_selesai,
                    $request->waktu_mulai,
                    $request->waktu_selesai,
                    $request->waktu_mulai,
                    $request->waktu_selesai

                ]);

                if ($check) {
                    $lapangan = DB::select('SELECT nama_lapangan FROM fasilitas WHERE id_lapangan = ?', [
                        $check[0]->id_lapangan
                    ]);

                    return back()
                        ->withInput()
                        ->with([
                            'nama_lapangan' => $lapangan[0]->nama_lapangan,
                            'tanggal_awal' => $check[0]->tanggal_mulai,
                            'tanggal_akhir' => $check[0]->tanggal_akhir,
                            'waktu_awal' => $check[0]->waktu_mulai,
                            'waktu_akhir' => $check[0]->waktu_selesai,
                        ]);
                }

                // tambah total
                $total += ($harga * $durasi_hari * $durasi_jam);
            }
        }

        if ($lapanganCount <= 0) {
            toast('Data gagal ditambahkan', 'error');
            return back()
                ->withInput()
                ->with('lapangan', 'Pilih minimal satu lapangan!');
        }

        // cari total fasilitas tambahan
        $fasilitas_tambahan = DB::select('SELECT * FROM fasilitas_tambahan');
        if ($request->sewa_raket) {
            $total += ($request->sewa_raket * $durasi_hari * $fasilitas_tambahan[0]->harga_fasilitas_tambahan);
        }

        if ($request->shuttlecock) {
            $total += ($request->shuttlecock * $durasi_hari * $fasilitas_tambahan[1]->harga_fasilitas_tambahan);
        }

        // butuh total
        DB::insert('INSERT INTO booking (id_member, nama_customer, no_telp_customer, total, status_booking , tanggal_mulai, tanggal_akhir, waktu_mulai, waktu_selesai, turnamen, id_voucher) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->id_member,
            $request->nama_customer,
            $request->no_telp_customer,
            $total,
            'booked',
            $request->tanggal_mulai,
            $request->tanggal_akhir,
            $request->waktu_mulai,
            $request->waktu_selesai,
            $request->turnamen,
            $request->voucher
        ]);

        $id_booking = DB::select("SELECT sf_get_latest_id_booking() as latest_id")[0]->latest_id;

        // lapangan bugged
        for ($i = 1; $i <= 4; $i++) {
            $field = 'lapangan' . $i;
            if ($request->has($field)) {
                DB::insert('INSERT INTO jadwal (id_lapangan, tanggal_mulai, tanggal_akhir, waktu_mulai, waktu_selesai, id_booking, status_jadwal) VALUES (?, ?, ?, ?, ?, ?, ?)', [
                    $request->$field,
                    $request->tanggal_mulai,
                    $request->tanggal_akhir,
                    $request->waktu_mulai,
                    $request->waktu_selesai,
                    $id_booking,
                    'booked'
                ]);
            }
        }

        // fasilitas tambahan
        if ($request->sewa_raket) {
            DB::insert('INSERT INTO transaksi_fasilitas_tambahan (id_booking,id_fasilitas_tambahan, jumlah, status_fasilitas_tambahan) VALUES (?, ?, ?, ?)', [
                $id_booking,
                $fasilitas_tambahan[0]->id_fasilitas_tambahan,
                $request->sewa_raket,
                'booked'
            ]);
        }

        if ($request->shuttlecock) {
            DB::insert('INSERT INTO transaksi_fasilitas_tambahan (id_booking, id_fasilitas_tambahan, jumlah, status_fasilitas_tambahan) VALUES (?, ?, ?, ?)', [
                $id_booking,
                $fasilitas_tambahan[1]->id_fasilitas_tambahan,
                $request->shuttlecock,
                'bokked'
            ]);
        }

        toast('Booking berhasil ditambahkan', 'success');
        return redirect('/dashboard/booking');
    }

    public function cancel($id)
    {
        // update booking
        DB::update('UPDATE booking SET status_booking  = ? WHERE id_booking = ?', [
            'canceled',
            $id
        ]);

        // update jadwal
        DB::update('UPDATE jadwal SET status_jadwal  = ? WHERE id_booking = ?', [
            'canceled',
            $id
        ]);

        // update fasilitas tambahan
        DB::update('UPDATE transaksi_fasilitas_tambahan SET status_fasilitas_tambahan  = ? WHERE id_booking = ?', [
            'canceled',
            $id
        ]);

        toast('Booking berhasil dicancel', 'error');
        return redirect('/dashboard/booking');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $booking = DB::select('SELECT b.*, m.*
        FROM booking b
        LEFT JOIN membership m ON b.id_member = m.id_member
        WHERE b.id_booking = ?
        LIMIT 1', [$id]);


        $jadwal = DB::select('SELECT j.*, f.* FROM jadwal j LEFT JOIN fasilitas f ON j.id_lapangan = f.id_lapangan WHERE id_booking = ?', [$id]);
        $fasilitas_tambahan = DB::select('SELECT t.*, f.* FROM transaksi_fasilitas_tambahan t LEFT JOIN fasilitas_tambahan f ON t.id_fasilitas_tambahan = f.id_fasilitas_tambahan WHERE id_booking = ?', [$id]);
        // $count

        $countLapangan = DB::select('SELECT count(*) as jumlah FROM jadwal WHERE id_booking = ?', [$id]);

        return view('dashboard.booking.detail', [
            'booking' => $booking[0],
            'jadwal' => $jadwal,
            'fasilitas_tambahan' => $fasilitas_tambahan,
            'jumlah' => $countLapangan[0]->jumlah
        ]);
    }


    public function showCekJadwal()
    {
        $fasilitas = DB::select('SELECT * FROM fasilitas');
        return view('dashboard.jadwal.create', [
            'fasilitas' => $fasilitas
        ]);
    }

    public function cekJadwal(Request $request)
    {
        for ($i = 1; $i <= 4; $i++) {
            $field = 'lapangan' . $i;
            if ($request->has($field)) {
                // check availablity
                $check = DB::select('SELECT * FROM jadwal 
                WHERE id_lapangan = ? AND status_jadwal != ?
                AND ((tanggal_mulai >= ? AND tanggal_mulai <= ?)
                    OR (tanggal_akhir >= ? AND tanggal_akhir <= ?)
                    OR (tanggal_mulai <= ? AND tanggal_akhir >= ?))
                AND ((waktu_mulai >= ? AND waktu_mulai < ?)
                    OR (waktu_selesai > ? AND waktu_selesai <= ?)
                    OR (waktu_mulai <= ? AND waktu_selesai >= ?))
                LIMIT 1', [
                    $request->$field,
                    'canceled',

                    $request->tanggal_mulai,
                    $request->tanggal_akhir,
                    $request->tanggal_mulai,
                    $request->tanggal_akhir,
                    $request->tanggal_mulai,
                    $request->tanggal_akhir,

                    $request->waktu_mulai,
                    $request->waktu_selesai,
                    $request->waktu_mulai,
                    $request->waktu_selesai,
                    $request->waktu_mulai,
                    $request->waktu_selesai

                ]);

                if ($check) {
                    $lapangan = DB::select('SELECT nama_lapangan FROM fasilitas WHERE id_lapangan = ?', [
                        $check[0]->id_lapangan
                    ]);

                    alert()->error('Lapangan sudah dibooking!', '');

                    return back()
                        ->withInput()
                        ->with([
                            'nama_lapangan' => $lapangan[0]->nama_lapangan,
                            'tanggal_awal' => $check[0]->tanggal_mulai,
                            'tanggal_akhir' => $check[0]->tanggal_akhir,
                            'waktu_awal' => $check[0]->waktu_mulai,
                            'waktu_akhir' => $check[0]->waktu_selesai,
                        ]);
                } else {
                    alert()->success('Lapangan Tersedia!', '');
                    return back()
                        ->withInput();
                }
            }
        }

        $fasilitas = DB::select('SELECT * FROM fasilitas');
        return view('dashboard.jadwal.create', [
            'fasilitas' => $fasilitas
        ]);
    }
}
