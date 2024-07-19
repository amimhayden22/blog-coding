@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Selamat datang di Blog Sederhana</h3>
                    <p>
                        Blog ini dibuat untuk mengisi waktu luang ketika gabut saja dan membagaikan hasil belajar saya tentang Laravel.
                    </p>
                    <hr>
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        @foreach ($posts as $post)
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <p class="card-text">
                                            {{ $post->content }}
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <small class="text-body-secondary">Penulis: {{ $post->user->name }} dibuat pada {{ date('d F Y', strtotime($post->date)) }} </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (Session::has('error'))
<script>
    Swal.fire({
        title: "Sukses!",
        text: "{{ Session('error') }}",
        icon: "error"
    });
</script>
@endif
@endsection
