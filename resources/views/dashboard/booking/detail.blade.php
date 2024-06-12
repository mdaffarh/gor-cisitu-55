@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;

    $harga = 65000;
    if ($booking->turnamen == 1) {
        $harga += 20000;
    }

    if ($booking->id_voucher) {
        $voucher = DB::select('SELECT * FROM voucher WHERE id_voucher = ?', [$booking->id_voucher]);
        $harga -= $voucher[0]->nilai_voucher;
    }

    $tanggal_mulai = Carbon::parse($booking->tanggal_mulai);
    $tanggal_akhir = Carbon::parse($booking->tanggal_akhir);
    $durasi_hari = $tanggal_mulai->diffInDays($tanggal_akhir);
    $durasi_hari++;

    // durasi jam
    $waktu_mulai = Carbon::createFromFormat('H:i:s', $booking->waktu_mulai);
    $waktu_selesai = Carbon::createFromFormat('H:i:s', $booking->waktu_selesai);
    $durasi_jam = $waktu_mulai->diffInHours($waktu_selesai);

    $harga = $harga * $durasi_hari * $durasi_jam;
@endphp

@extends('dashboard.layout.main')

@section('title', 'Booking')
@section('container')
    <div class="container-fluid">
        <h3 class="mb-4 fw-bold">
            Detail Booking
        </h3>
        <div class="card shadow col-xl-10">
            <div class="card-header py-3">
                <p class="text-success m-0 fw-bold">

                    Booking Detail

                    @switch($booking->status_booking)
                        @case('booked')
                            <span class="ms-2 badge text-bg-success text-capitalize">{{ $booking->status_booking }}</span>
                        @break

                        @case('canceled')
                            <span class="ms-2 badge text-bg-danger text-capitalize">{{ $booking->status_booking }}</span>
                        @break

                        @default
                    @endswitch
                </p>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="fw-bold text-dark">
                        @if ($booking->id_member)
                            Nama Member
                        @else
                            Nama Customer
                        @endif
                    </h6>
                    <p class="text-dark" style="font-size: 1.1em">
                        {{ $booking->id_member ? $booking->nama_member : $booking->nama_customer }}</p>
                </div>
                <div class="mb-3">
                    <h6 class="fw-bold text-dark">
                        Nomor Telepon
                    </h6>
                    <p class="text-dark" style="font-size: 1.1em">
                        {{ $booking->id_member ? $booking->no_telp_member : $booking->no_telp_customer }}</p>
                </div>
                <div class="mb-3">
                    <h6 class="fw-bold text-dark">Hari dan Durasi</h6>
                    <p class="text-dark d-inline" style="font-size: 1.1em">
                        {{ Carbon::parse($booking->tanggal_mulai)->translatedFormat('l, d F Y') }}
                        -
                        {{ Carbon::parse($booking->tanggal_akhir)->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-dark" style="font-size: 1.1em">
                        {{ Carbon::parse($booking->waktu_mulai)->translatedFormat('H:i') }} -
                        {{ Carbon::parse($booking->waktu_selesai)->translatedFormat('H:i') }}</p>
                </div>
                <div class="mb-3">
                    <h6 class="fw-bold text-dark mt-3">Fasilitas <small style="font-size: 0.7em">({{ $jumlah }} Lapangan)</small> </h6>
                    <ol class="w-100">

                        @foreach ($jadwal as $j)
                            <li class="text-dark" style="font-size: 1.1em">
                                <span class="me-3">
                                    {{ $j->nama_lapangan }}
                                </span>
                                <span style="font-size: 0.9em">
                                    Rp.{{ number_format($harga, 0, ',', '.') }}
                                </span>
                            </li>
                        @endforeach
                    </ol>

                    @if ($booking->id_voucher)
                        @php
                            $voucher = DB::select('SELECT * FROM voucher WHERE id_voucher = ? LIMIT 1', [
                                $booking->id_voucher,
                            ]);
                        @endphp
                        <p class="text-dark fw-bold">Diskon Terpakai:
                            Rp.{{ number_format($voucher[0]->nilai_voucher, 0, ',', '.') }} per Lapangan
                            <small class="fw-normal">
                                ({{ $voucher[0]->jenis_voucher }})
                            </small>
                        </p>
                    @endif

                </div>

                @if ($fasilitas_tambahan)
                    <div class="mb-3">
                        <h6 class="fw-bold text-dark mt-3">Fasilitas Tambahan</h6>
                        <ol>
                            @foreach ($fasilitas_tambahan as $f)
                                <li class="text-dark" style="font-size: 1.1em">
                                    {{ $f->jenis_fasilitas_tambahan }}
                                    <span class="ms-3" style="font-size: 0.9em">
                                        {{ $f->jumlah }}x
                                    </span>
                                    <span class="ms-3" style="font-size: 0.9em">
                                        Rp.{{ number_format($f->jumlah * $f->harga_fasilitas_tambahan * $durasi_hari, 0, ',', '.') }}
                                    </span>
                                </li>
                            @endforeach
                        </ol>

                    </div>
                @endif

                <div class="text-end">
                    <h5 class="fw-bold text-dark mb-1">Total Keseluruhan
                    </h5>
                    <p style="font-size: 1.2em" class="text-dark">Rp.{{ number_format($booking->total, 0, ',', '.') }}</p>
                    <a class="btn btn-secondary" href="/dashboard/booking">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
