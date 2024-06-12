@extends('dashboard.layout.main')

@section('title', 'Member')
@section('container')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body col-xl-8">
                <h3 class="mt-4 mb-4 fw-bold mx-2" style="color: var(--navy)">Tambah Data Member</h3>
                <form action="/dashboard/membership" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Member</label>
                        <input type="text"
                            class="form-control text-primary-emphasis  @error('nama_member') is-invalid @enderror"
                            name="nama_member" value="{{ old('nama_member') }}">
                        @error('nama_member')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai Member</label>
                        <input type="tel"
                            class="form-control text-primary-emphasis  @error('no_telp_member') is-invalid @enderror"
                            name="no_telp_member" value="{{ old('no_telp_member') }}">
                        @error('no_telp_member')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <a href="/dashboard/membership" class="btn btn-secondary text-white">Back</a>
                        <button type="submit" class="btn btn-success text-white">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
