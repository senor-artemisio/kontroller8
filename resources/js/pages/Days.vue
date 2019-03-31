<template>
    <b-container>
        <div id="days-calendar" class="mt-4"></div>
        <b-modal id="days-calendar-add" ref="modal-add-item" :title="getModalAddItemTitle()">

        </b-modal>
    </b-container>
</template>
<script>
    import {Calendar} from '@fullcalendar/core';
    import dayGridPlugin from '@fullcalendar/daygrid';
    import interactionPlugin from '@fullcalendar/interaction';
    import bootstrapPlugin from '@fullcalendar/bootstrap';
    import {toMoment, toDuration} from '@fullcalendar/moment';
    import locale from '@fullcalendar/core/locales/en-gb';

    export default {
        data: function () {
            return {
                selectedDate: {m: null},
                items:[]
            };
        },
        mounted() {
            const component = this;
            let calendarEl = document.getElementById('days-calendar'),
                calendar = new Calendar(calendarEl, {
                    plugins: [dayGridPlugin, interactionPlugin, bootstrapPlugin],
                    defaultView: 'dayGridMonth',
                    locale: locale,
                    themeSystem: 'bootstrap',
                    bootstrapFontAwesome: {
                        prev: 'fa-arrow-left',
                        next: 'fa-arrow-right',
                    },
                    header: {
                        left: 'dayGridMonth,dayGridWeek',
                        center: 'title',
                        right: 'today prev,next'
                    },
                    dayRender(dayRenderInfo) {
                        let td = dayRenderInfo.el;
                        td.classList.add('secondary-hover');
                        td.classList.add('cursor-pointer');
                    },
                    dateClick(info) {
                        component.selectedDate.m = toMoment(info.date, calendar);
                        component.$refs['modal-add-item'].show();
                    }
                });

            calendar.render();
        },
        methods: {
            getModalAddItemTitle() {
                return this.selectedDate.m ? this.selectedDate.m.format('MMMM Do') : '';
            }
        }
    }
</script>