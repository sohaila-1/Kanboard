@extends('layouts.app')

@section('title', $project->title . ' — Vue Calendrier')

@section('content')
<div class="container-fluid px-3 px-md-5 mt-4">
    <h4>{{ $project->title }} — Vue Calendrier</h4>
    <div id="calendar"></div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek', // vue avec les heures
        locale: 'fr',
        slotMinTime: "06:00:00",
        slotMaxTime: "22:00:00",
        slotDuration: "00:30:00",
        allDaySlot: false,
        height: "auto",
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: @json($events)
    });
    calendar.render();
});
</script>
@endsection
