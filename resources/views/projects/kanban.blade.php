@extends('layouts.app')

@section('title', 'Vue Kanban')

@section('content')
<div class="main-content">
    <h2 class="mb-5 text-center display-6 text-primary-emphasis">{{ $project->title }} — Vue Kanban</h2>

    <div class="kanban-wrapper">
        @foreach ($columns as $status => $tasks)
            <div class="kanban-column" data-category="{{ $status }}">
                <div class="kanban-header">
                    <h6 class="fw-bold mb-0">
                        @if($status === 'à faire')📃 @elseif($status === 'en cours')📰 @elseif($status === 'fait')✅ @elseif($status === 'annulé')❌ @endif
                        {{ ucfirst($status) }}
                    </h6>
                </div>

                <div class="kanban-cards"
                     ondrop="drop(event, '{{ $status }}')"
                     ondragover="allowDrop(event)">

                    @foreach ($tasks as $task)
                        <div class="kanban-card" draggable="true" ondragstart="drag(event)" id="task-{{ $task->id }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">{{ $task->title }}</div>
                                    <div class="small text-muted">{{ \Illuminate\Support\Str::limit($task->description, 60) }}</div>
                                    @if($task->user)
                                <div class="text-muted small mt-1">👤 Créé par <strong>{{ $task->user->name }}</strong></div>
                            @endif
                                    @if ($task->priority)
                                        <span class="badge bg-{{ match($task->priority) {
                                            'Élevée' => 'danger',
                                            'Moyenne' => 'warning',
                                            'Basse' => 'success',
                                            default => 'secondary'
                                        } }}">
                                            {{ $task->priority }}
                                        </span>
                                    @endif
                                    @if ($task->due_date)
                                        <div class="small text-muted mt-1">
                                            📅 {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <a href="{{ route('tasks.edit', [$project, $task]) }}" class="btn btn-sm btn-light border px-2 py-1">✏️</a>
                                    <form method="POST" action="{{ route('tasks.destroy', [$project, $task]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border px-2 py-1">🗑️</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <a href="{{ route('tasks.create', ['project' => $project->id, 'category' => $status]) }}"
                       class="btn btn-outline-primary btn-sm w-100 mt-2">➕ Ajouter une tâche</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection



@section('scripts')
<script>
    function allowDrop(ev) {
        ev.preventDefault();
        ev.currentTarget.classList.add("drag-over");
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev, newCategory) {
        ev.preventDefault();
        ev.currentTarget.classList.remove("drag-over");

        const taskId = ev.dataTransfer.getData("text").replace("task-", "");
        const taskElement = document.getElementById("task-" + taskId);

        ev.currentTarget.appendChild(taskElement);

        fetch(`/tasks/${taskId}/move`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ category: newCategory })
        }).then(res => {
            if (!res.ok) {
                alert("Erreur lors du déplacement.");
            }
        });
    }
</script>

<style>
.kanban-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    justify-content: center;
    padding-bottom: 2rem;
}

.kanban-column {
    width: 300px;
    background-color: #f8fafc;
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #96d6f5;
}

.kanban-header {
    background-color: #f1f5f9;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    text-align: center;
    font-size: 1rem;
    color: #1f2937;
}

.kanban-cards {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    min-height: 100px;
}

.kanban-card {
    background: white;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    padding: 0.75rem;
    transition: 0.2s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.03);
}

.kanban-card:hover {
    background-color: #f9fafb;
    transform: translateY(-2px);
}

.kanban-cards.drag-over {
    background-color: #e0f2fe;
    border: 2px dashed #3b82f6;
    border-radius: 10px;
}
</style>
@endsection
