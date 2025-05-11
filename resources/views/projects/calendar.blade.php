@extends('layouts.app')

@section('title', 'Calendrier des tâches')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📅 Calendrier du projet : {{ $project->title }}</h2>

    <div id="calendar"></div>
</div>
@endsection

@section('scripts')
<!-- FullCalendar CSS & JS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            height: 'auto',
            events: @json($events)
        });

        calendar.render();
    });
</script>
@endsection
