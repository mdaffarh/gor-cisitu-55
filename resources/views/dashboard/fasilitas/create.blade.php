@extends('dashboard.layout.main')

@section('title', 'Fasilitas')
@section('container')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body col-xl-8">
                <h3 class="mt-4 mb-4 fw-bold mx-2" style="color: var(--navy)">Tambah Data Fasilitas</h3>
                <form action="/dashboard/fasilitas" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Fasilitas</label>
                        <input type="text"
                            class="form-control text-primary-emphasis  @error('nama_lapangan') is-invalid @enderror"
                            name="nama_lapangan" value="{{ old('nama_lapangan') }}">
                        @error('nama_lapangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Lapangan</label>
                        <input type="number"
                            class="form-control text-primary-emphasis  @error('harga_lapangan') is-invalid @enderror"
                            name="harga_lapangan" value="{{ old('harga_lapangan') }}">
                        @error('harga_lapangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Tournamen</label>
                        <input type="number"
                            class="form-control text-primary-emphasis  @error('harga_tournament') is-invalid @enderror"
                            name="harga_tournament" value="{{ old('harga_tournament') }}">
                        @error('harga_tournament')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <a href="/dashboard/fasilitas" class="btn btn-secondary text-white">Back</a>
                        <button type="submit" class="btn btn-success text-white">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
