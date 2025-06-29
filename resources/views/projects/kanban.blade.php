@extends('layouts.app')

@section('title', 'Vue Kanban')

@section('content')
<div class="main-content">
    <h2 class="mb-5 text-center display-6">{{ $project->title }} — Vue Kanban</h2>

    <div class="kanban-wrapper d-flex gap-3">
        @foreach ($columns as $status => $tasks)
            <div class="kanban-column" data-category="{{ $status }}">
                <h5 class="kanban-title">
                    @if($status === 'à faire')📃 @elseif($status === 'en cours')📰 @elseif($status === 'fait')✅ @elseif($status === 'annulé')❌ @endif
                    {{ ucfirst($status) }}
                </h5>

                <div class="kanban-cards"
                     ondrop="drop(event, '{{ $status }}')"
                     ondragover="allowDrop(event)">

                    @foreach ($tasks as $task)
                        <div class="kanban-card" draggable="true" ondragstart="drag(event)" id="task-{{ $task->id }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>{{ $task->title }} 👤 {{ $task->user->name ?? 'Inconnu' }}</strong>
                            <div class="d-flex gap-1">
            <a href="{{ route('tasks.edit', ['project' => $project->id, 'task' => $task->id]) }}" class="btn btn-sm btn-outline-secondary px-2">✏️</a>
            <form method="POST" action="{{ route('tasks.destroy', ['project' => $project->id, 'task' => $task->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger px-2">🗑️</button>
            </form>
        </div>
    </div>
 
    <div class="mt-2 text-end small text-muted">
        👤 {{ $task->user->name ?? 'Inconnu' }}
    </div>
</div>

                    @endforeach

                    <a href="{{ route('tasks.create', ['project' => $project->id, 'category' => $status]) }}"
                       class="btn btn-sm btn-outline-primary mt-2">➕ Ajouter une tâche</a>
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
        gap: 2rem;
        flex-wrap: wrap;
        justify-content: center;
        padding: 2rem 0;
        align-items: flex-start;
    }


    .kanban-column {
        width: 300px;
        background: #f9fafb;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }


    .kanban-title {
        text-align: center;
        padding: 0.3rem;
        font-weight: bold;
        border-radius: 6px;
        font-size: 1rem;
    }

    .kanban-column[data-category="à faire"] .kanban-title { background-color: #e0f2fe; }
    .kanban-column[data-category="en cours"] .kanban-title { background-color: #fef9c3; }
    .kanban-column[data-category="fait"] .kanban-title { background-color: #dcfce7; }
    .kanban-column[data-category="annulé"] .kanban-title { background-color: #fee2e2; }

    .kanban-cards {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        min-height: 100px;
        max-height: 500px;
        overflow-y: auto;
    }
    .kanban-card {
        padding: 0.75rem;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease;
        cursor: grab;
        font-size: 0.9rem;
    }


    .kanban-card:hover {
        transform: scale(1.01);
        background-color: #f3f4f6;
    }

    .kanban-cards.drag-over {
        border: 2px dashed #3b82f6;
        background-color: #eff6ff;
    }
</style>
@endsection
