<div id="sectionSolo" x-show="activeTab === 'solo'">

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Left Content --}}
        <div class="xl:col-span-2 space-y-6">

            @include('study-room.solo.mode-selector')

            @include('study-room.solo.timer-card')

            @include('study-room.solo.info-cards')

        </div>

        {{-- Right Sidebar --}}
        <div>

            @include('study-room.solo.stats-panel')

        </div>

    </div>

</div>