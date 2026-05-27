@extends('backend.layout.app')
@section('title', 'Hustle Moments')

@section('content')
<div class="card card-flush">
    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <div class="card-title">
            <h2>Hustle Moments (Published Photos)</h2>
        </div>
    </div>
    <div class="card-body pt-0">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="row g-5">
            @forelse($photos as $photo)
                <div class="col-md-4 col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <img src="{{ Storage::url($photo->image_path) }}" alt="Photo" class="w-100" style="border-top-left-radius: 0.625rem; border-top-right-radius: 0.625rem; height: 200px; object-fit: cover;">
                        </div>
                        <div class="card-footer p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold fs-6">{{ $photo->user ? $photo->user->name : 'Guest (Demo)' }}</div>
                                <div class="text-muted fs-7">{{ $photo->created_at->format('d M Y, H:i') }}</div>
                                <div class="text-muted fs-8">IP: {{ $photo->ip_address }}</div>
                            </div>
                            <form action="{{ route('published-photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto publik ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light-danger btn-icon" title="Hapus Foto">
                                    <i class="ki-duotone ki-trash fs-2">
                                        <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>
                                    </i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-10">
                    Belum ada foto yang dipublish oleh user.
                </div>
            @endforelse
        </div>
        
        <div class="mt-5">
            {{ $photos->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
