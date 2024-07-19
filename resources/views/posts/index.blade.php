@extends('layouts.app')
@section('title', 'Manajemen Post')
@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Manajemen Post') }}</div>

                <div class="card-body">
                    <a href="{{ route('posts.create') }}" class="btn btn-sm btn-primary mb-3">Tambah Data</a>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Konten</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Penulis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($posts as $post)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->content }}</td>
                                        <td>{{ date('d F Y', strtotime($post->date)) }}</td>
                                        <td>{{ $post->user->name }}</td>
                                        <td class="btn-group">
											<a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger" onclick="deleteConfirmation({{ $post->id }})">Hapus</a>
                                            <form id="delete-form-{{ $post->id }}" action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
										</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Data tidak ada...</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Success Data -->
@if (Session::has('success'))
<script>
    Swal.fire({
        title: "Sukses!",
        text: "{{ Session('success') }}",
        icon: "success"
    });
</script>
@endif
<!-- Delete Data -->
<script>
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-outline-danger"
      },
      buttonsStyling: false
    });

    function deleteConfirmation(userId) {
      swalWithBootstrapButtons.fire({
        title: "Apakah kamu yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus Sekarang!",
        cancelButtonText: "Batalkan!",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-form-' + userId).submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire({
            title: "Dibatalkan!",
            text: "Data kamu aman :)",
            icon: "error"
          });
        }
      });
    }
  </script>

@endsection
