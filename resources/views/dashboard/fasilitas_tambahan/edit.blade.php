@extends('dashboard.layout.main')

@section('title', 'Fasilitas')
@section('container')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body col-xl-8">
                <h3 class="mt-4 mb-4 fw-bold mx-2" style="color: var(--navy)">Edit Data Fasilitas</h3>
                <form action="/dashboard/fasilitas_tambahan/{{ $fasilitas_tambahan->id_fasilitas_tambahan }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Fasilitas</label>
                        <input type="text"
                            class="form-control text-primary-emphasis  @error('jenis_fasilitas_tambahan') is-invalid @enderror"
                            name="jenis_fasilitas_tambahan"
                            value="{{ old('jenis_fasilitas_tambahan') ? old('jenis_fasilitas_tambahan') : $fasilitas_tambahan->jenis_fasilitas_tambahan }}">
                        @error('jenis_fasilitas_tambahan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Lapangan</label>
                        <input type="number"
                            class="form-control text-primary-emphasis  @error('harga_fasilitas_tambahan') is-invalid @enderror"
                            name="harga_fasilitas_tambahan"
                            value="{{ old('harga_fasilitas_tambahan') ? old('harga_fasilitas_tambahan') : $fasilitas_tambahan->harga_fasilitas_tambahan }}">
                        @error('harga_fasilitas_tambahan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <a href="/dashboard/fasilitas_tambahan" class="btn btn-secondary text-white">Back</a>
                        <button type="submit" class="btn btn-success text-white">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
