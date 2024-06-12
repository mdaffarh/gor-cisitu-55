@extends('dashboard.layout.main')

@section('title', 'Membership')
@section('container')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <!-- Form Add Start-->
                <h3 class="mt-4 mb-4 fw-bold mx-2" style="color: var(--navy)">Tabel Membership</h3>
                <div class="d-flex flex-row-reverse">

                    <a href="/dashboard/membership/create" type="button" class="btn btn-success"">
                        Tambah Data
                    </a>
                </div>

                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0 display" id="myTable" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Member</th>
                                <th>No Telp </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($membership as $m)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $m->nama_member }}</td>
                                    <td>{{ $m->no_telp_member }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Update Button --}}
                                            <a href="/dashboard/membership/{{ $m->id_member }}/edit"
                                                class="btn btn btn-primary">
                                                <span data-bs-toggle="tooltip" data-bs-title="Edit Data">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                                    </svg>
                                                </span>
                                            </a>
                                            {{-- Update Button End --}}

                                            {{-- Delete Button --}}
                                            <button type="button" class="btn btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete{{ $m->id_member }}">
                                                <span data-bs-toggle="tooltip" data-bs-title="Hapus Data">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                                    </svg>
                                                </span>
                                            </button>
                                            {{-- Delete Button End --}}

                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Delete --}}
                                <div class="modal fade" id="delete{{ $m->id_member }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5 fw-bold" style="color: var(--navy);"
                                                    id="deleteLabel">Hapus Data Membership</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <h3 class="fw-bold" style="color: var(--navy)">Anda yakin untuk menghapus
                                                    data ini?</h3>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="/dashboard/membership/{{ $m->id_member }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- Modal Delete End --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
