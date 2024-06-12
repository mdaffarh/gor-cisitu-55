@extends('dashboard.layout.main')

@section('title', 'Voucher')
@section('container')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body col-xl-8">
                <h3 class="mt-4 mb-4 fw-bold mx-2" style="color: var(--navy)">Tambah Data Voucher</h3>
                <form action="/dashboard/voucher" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Voucher</label>
                        <input type="text"
                            class="form-control text-primary-emphasis  @error('jenis_voucher') is-invalid @enderror"
                            name="jenis_voucher" value="{{ old('jenis_voucher') }}">
                        @error('jenis_voucher')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai Voucher</label>
                        <input type="number"
                            class="form-control text-primary-emphasis  @error('nilai_voucher') is-invalid @enderror"
                            name="nilai_voucher" value="{{ old('nilai_voucher') }}">
                        @error('nilai_voucher')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <a href="/dashboard/voucher" class="btn btn-secondary text-white">Back</a>
                        <button type="submit" class="btn btn-success text-white">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
