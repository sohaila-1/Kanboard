@extends('layouts.app')

@section('title', $project->title . ' — Vue Calendrier')

@section('content')
<div class="container-fluid px-3 px-md-5 mt-4">
    <h4>{{ $project->title }} — Vue Calendrier</h4>
    <div id="calendar"></div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'fr',
        slotMinTime: "06:00:00",
        slotMaxTime: "23:59:00",
        slotDuration: "00:30:00",
        allDaySlot: false,
        nowIndicator: true,
        height: "auto",
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: @json($events),

        // ✅ Ajouter la virgule ici pour corriger l'erreur !
        eventClick: function(info) {
            const taskId = info.event.id;
            const projectId = {{ $project->id }};
            window.location.href = `/projects/${projectId}/tasks/${taskId}`;
        },

        eventDidMount: function(info) {
            if (info.event.extendedProps.description) {
                new Tooltip(info.el, {
                    title: info.event.extendedProps.description,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            }
        }
    });

    calendar.render();
});
</script>
@endsection
