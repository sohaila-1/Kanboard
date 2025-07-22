<!-- resources/views/projects/calendar.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Calendrier du projet</h2>
    <div id="calendar"></div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridDay,timeGridThreeDay,timeGridWeek,dayGridMonth'
            },
            views: {
                timeGridThreeDay: {
                    type: 'timeGrid',
                    duration: { days: 3 },
                    buttonText: '3 jours'
                }
            },

            // ✅ ICI : l'événement de clic
            eventClick: function(info) {
                let props = info.event.extendedProps;
                let details = `
                    📌 ${info.event.title}\n
                    📝 Description : ${props.description}
                    👤 Responsable : ${props.responsable}
                    🗂️ Catégorie : ${props.categorie}
                    ⚡ Priorité : ${props.priorite}
                    📅 Date : ${info.event.start.toLocaleString()}
                `;
                alert(details);
            },

            // ✅ ICI : injection des événements Laravel
            events: @json($events)
        });

        calendar.render();
    });
</script>
@endsection
