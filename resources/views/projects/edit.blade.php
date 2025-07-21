@extends('layouts.app')

@section('title', 'Modifier le projet')

@section('content')
<div class="container-fluid py-4 px-3 px-md-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Modifier le projet
                </h1>
            </div>
        </div>

        <div class="card-body pt-1">
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <h5 class="alert-heading">Erreurs à corriger :</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('projects.update', $project->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="form-label fw-semibold">Titre du projet</label>
                    <input type="text" 
                           class="form-control form-control-lg" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $project->title) }}" 
                           required
                           placeholder="Nommez votre projet">
                    <div class="invalid-feedback">
                        Veuillez saisir un titre pour votre projet.
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control" 
                              name="description" 
                              id="description" 
                              rows="4"
                              placeholder="Décrivez brièvement votre projet">{{ old('description', $project->description) }}</textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-3">
                    <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Validation Bootstrap
    (function () {
        'use strict'
        
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endpush

@endsection