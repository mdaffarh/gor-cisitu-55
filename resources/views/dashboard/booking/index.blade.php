@php
    use Carbon\Carbon;
@endphp
@extends('dashboard.layout.main')

@section('title', 'Booking')
@section('container')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <!-- Form Add Start-->
                <h3 class="mt-4 mb-4 fw-bold mx-2" style="color: var(--navy)">Tabel Booking</h3>
                <div class="d-flex flex-row-reverse">

                    <a href="/dashboard/booking/create" type="button" class="btn btn-success"">
                        Tambah Data
                    </a>
                </div>

                {{-- table here --}}

                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0 display" id="myTable" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Cust</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($booking as $b)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $b->nama_member ? $b->nama_member : $b->nama_customer }}</td>
                                    <td>
                                        @if ($b->tanggal_mulai == $b->tanggal_akhir)
                                            {{ Carbon::parse($b->tanggal_mulai)->translatedFormat('l, j F Y') }}
                                        @else
                                            {{ Carbon::parse($b->tanggal_mulai)->translatedFormat('l, j F Y') }}-{{ Carbon::parse($b->tanggal_akhir)->translatedFormat('l, j F Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ Carbon::parse($b->waktu_mulai)->translatedFormat('H:i') }}-{{ Carbon::parse($b->waktu_selesai)->translatedFormat('H:i') }}
                                    </td>
                                    <td>Rp {{ number_format($b->total, 0, ',', '.') }}</td>
                                    <td class="text-capitalize">

                                        @if ($b->status_booking == 'canceled')
                                            <span class="badge text-bg-danger">{{ $b->status_booking }}</span>
                                        @elseif ($b->status_booking == 'booked')
                                            <span class="badge text-bg-success">{{ $b->status_booking }}</span>
                                        @endif

                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('booking.show', $b->id_booking) }}}}"
                                                class="btn btn-sm btn-primary" role="link">
                                                Detail
                                            </a>

                                            @if ($b->status_booking == 'booked')
                                                <button data-bs-toggle="modal" data-bs-target="#cancel{{ $b->id_booking }}"
                                                    class="btn btn-sm btn-danger" role="button">
                                                    Cancel
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                @if ($b->status_booking == 'booked')
                                    {{-- Modal Cancel --}}
                                    <div class="modal fade" id="cancel{{ $b->id_booking }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5 fw-bold" style="color: var(--navy);"
                                                        id="deleteLabel">Cancel Booking</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <p class="fw-bold fs-3" style="color: var(--navy)">Anda yakin untuk
                                                        cancel
                                                        booking ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="/dashboard/booking/cancel/{{ $b->id_booking }}"
                                                        class="btn btn-sm btn-danger" role="button">
                                                        Cancel
                                                    </a>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Modal Cancel End --}}
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
