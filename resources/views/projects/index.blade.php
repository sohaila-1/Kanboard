@extends('layouts.app')

@section('title', 'Mes Projets')

@section('content')
<div class="main-content container py-4">

    <!-- 🎉 Message de succès -->
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- 👤 Bienvenue -->
    <h2 class="mb-3 fw-bold fs-4">Bienvenue, {{ Auth::user()->name }} 👋</h2>
<div class="d-flex justify-content-end mb-4">
    <form method="GET" action="{{ route('projects.index') }}" style="position: relative; width: 250px;">
        <input
            type="text"
            name="search"
            class="form-control pe-5"  {{-- padding-end for space --}}
            placeholder="Rechercher..."
            value="{{ request('search') }}"
            style="padding-right: 2.2rem;"
        >

        <button type="submit"
            style="
                position: absolute;
                right: 0.5rem;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                padding: 0;
                cursor: pointer;
                color: #3F6B6D;
                font-size: 1rem;
            "
            title="Rechercher"
        >
            🔍
        </button>
    </form>
</div>


    <!-- ➕ Bouton création -->
    <div class="mb-4">
        <a href="{{ route('projects.create') }}" class="btn btn-primary">
            ➕ Nouveau projet
        </a>
    </div>

    <!-- 🖼️ Galerie des projets -->
    @if($projects->isEmpty())
        <div class="alert alert-info">Aucun projet trouvé.</div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($projects as $project)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold">{{ $project->title }}</h5>
                            <p class="card-text text-muted">{{ $project->description ?? 'projet' }}</p>
                        </div>
                        <div class="card-footer bg-white border-0 d-flex justify-content-between px-3 pb-3">
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-secondary" title="Voir">📄</a>
                            <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-primary" title="Modifier">✏️</a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit" title="Supprimer">🗑️</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
