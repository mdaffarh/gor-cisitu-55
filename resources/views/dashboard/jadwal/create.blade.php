@php
    use Carbon\Carbon;
@endphp

@extends('dashboard.layout.main')

@section('title', 'Cek Jadwal')
@section('container')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body col-xl-8">
                <h3 class="mt-4 mb-4 fw-bold mx-2" style="color: var(--navy)">Cek Jadwal</h3>
                @if (session()->has('tanggal_awal'))
                    @php
                        $tanggal_awal = Carbon::parse(session('tanggal_awal'))->translatedFormat('l, j F Y');
                        $tanggal_akhir = Carbon::parse(session('tanggal_akhir'))->translatedFormat('l, j F Y');

                        $waktu_awal = Carbon::parse(session('waktu_awal'))->translatedFormat('H:i');
                        $waktu_akhir = Carbon::parse(session('waktu_akhir'))->translatedFormat('H:i');
                    @endphp
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('nama_lapangan') }} telah dibooking pada
                        @if ($tanggal_awal == $tanggal_akhir)
                            {{ $tanggal_awal }}
                        @else
                            {{ $tanggal_awal }}-{{ $tanggal_akhir }}
                        @endif
                        jam
                        {{ $waktu_awal }}-{{ $waktu_akhir }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="/dashboard/jadwal/cek-jadwal" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pilih Lapangan</label>
                        @if (session()->has('lapangan'))
                            <p class="text-danger">{{ session('lapangan') }}</p>
                        @endif
                        <div class="ms-1 row">
                            @foreach ($fasilitas as $index => $f)
                                <div class="form-check col-md-6">
                                    @php
                                        $field = 'lapangan' . $index + 1;
                                    @endphp
                                    <input class="form-check-input" type="checkbox" value="{{ $f->id_lapangan }}"
                                        name="lapangan{{ $index + 1 }}"
                                        {{ old($field) == $f->id_lapangan ? 'checked' : ' ' }}>
                                    <label class="form-check-label ">
                                        {{ $f->nama_lapangan }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col">
                            <label class="form-label">Tanggal Awal</label>
                            <input type="date"
                                class="form-control text-primary-emphasis  @error('tanggal_mulai') is-invalid @enderror"
                                name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 col">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date"
                                class="form-control text-primary-emphasis  @error('tanggal_akhir') is-invalid @enderror"
                                name="tanggal_akhir" value="{{ old('tanggal_akhir') }}" required>
                            @error('tanggal_akhir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $time = [];
                            for ($i = 7; $i <= 22; $i++) {
                                $time[] = sprintf('%02d:00', $i);
                            }
                        @endphp
                        <div class="mb-3 col">
                            <label class="form-label">Waktu Mulai</label>
                            <select name="waktu_mulai" id="" class="form-control form-select" required>
                                <option selected disabled>Pilih salah satu</option>
                                @foreach ($time as $t)
                                    <option value="{{ $t }}" {{ old('waktu_mulai') == $t ? 'selected' : ' ' }}>
                                        {{ $t }}</option>
                                @endforeach
                            </select>
                            @error('waktu_mulai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 col">
                            <label class="form-label">Waktu Selesai</label>
                            <select name="waktu_selesai" id="" class="form-control form-select" required>
                                <option selected disabled>Pilih salah satu</option>
                                @foreach ($time as $t)
                                    <option value="{{ $t }}"
                                        {{ old('waktu_selesai') == $t ? 'selected' : ' ' }}>
                                        {{ $t }}</option>
                                @endforeach
                            </select>
                            @error('waktu_selesai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success text-white">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
