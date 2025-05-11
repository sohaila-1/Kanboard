@extends('layouts.app')

@section('title', 'Vue Kanban')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">{{ $project->title }} - Vue Kanban</h2>

    <div class="kanban-board">
        @foreach(['À faire', 'En cours', 'Fait', 'Annulé'] as $column)
            <div class="kanban-column">
                <h4 class="text-center fw-bold">{{ $column }}</h4>

                @php
                    $priorities = ['Élevée' => 1, 'Moyenne' => 2, 'Basse' => 3];

                    $tasks = $project->tasks
                        ->where('category', $column)
                        ->sortBy(function($task) use ($priorities) {
                            return $priorities[$task->priority] ?? 4;
                        });
                @endphp

                <div id="{{ Str::slug($column) }}" class="kanban-list">
                    @foreach ($tasks as $task)
                        <div class="kanban-card" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <strong>{{ $task->title }}</strong>
                                @php
                                    $badgeClass = match($task->priority) {
                                        'Élevée' => 'danger',
                                        'Moyenne' => 'warning',
                                        'Basse' => 'success',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ $task->priority }}</span>
                            </div>

                            @if($task->description)
                                <p class="text-muted small mb-1">{{ $task->description }}</p>
                            @endif

                            @if($task->due_date)
                                <p class="small mb-0 text-muted">📅 {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.querySelectorAll('.kanban-list').forEach(list => {
        new Sortable(list, {
            group: 'shared',
            animation: 150,
            onEnd: function (evt) {
                const taskId = evt.item.dataset.id;
                const newColumn = evt.to.id;

                fetch(`/tasks/${taskId}/move`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ category: newColumn.replace('-', ' ') })
                });
            }
        });
    });
</script>
@endsection
