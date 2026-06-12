@props([
    'calendarMonth',
    'selectedDate' => null,
    'datesWithPosts' => [],
    'archiveYears' => [],
])

@php
    use Carbon\Carbon;

    $monthStart = $calendarMonth->copy()->startOfMonth();
    $monthEnd = $calendarMonth->copy()->endOfMonth();
    $gridStart = $monthStart->copy()->startOfWeek(Carbon::SUNDAY);
    $gridEnd = $monthEnd->copy()->endOfWeek(Carbon::SATURDAY);

    $bnMonths = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
    $bnDays = ['রবি', 'সোম', 'মঙ্গ', 'বুধ', 'বৃহ', 'শুক্র', 'শনি'];
    $bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    $toBn = fn ($value) => str_replace(range(0, 9), $bnDigits, (string) $value);

    $prevMonth = $monthStart->copy()->subMonth()->format('Y-m');
    $nextMonth = $monthStart->copy()->addMonth()->format('Y-m');
    $canGoNext = ! $monthStart->copy()->addMonth()->startOfMonth()->gt(now()->startOfMonth());
    $today = now()->startOfDay();
    $currentYear = (int) now()->year;
    $currentMonth = (int) now()->month;
    $postDates = collect($datesWithPosts)->flip();
    $selectedKey = $selectedDate?->format('Y-m-d');
    $years = ! empty($archiveYears) ? $archiveYears : [$monthStart->year];
@endphp

<div class="archive-calendar-wrap border border-slate-300 bg-white p-3 md:p-4 notranslate">
    <div class="grid grid-cols-2 gap-2 mb-3">
        <select
            class="archive-month-select w-full border border-slate-300 bg-white px-2 py-1.5 text-xs md:text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary rounded-sm"
            aria-label="মাস নির্বাচন"
            data-selected-date="{{ $selectedKey ?? '' }}">
            @foreach($bnMonths as $index => $monthName)
                @php
                    $monthNumber = $index + 1;
                    $isFutureMonth = $monthStart->year === $currentYear && $monthNumber > $currentMonth;
                @endphp
                <option value="{{ str_pad((string) $monthNumber, 2, '0', STR_PAD_LEFT) }}"
                    @selected($monthStart->month === $monthNumber)
                    @disabled($isFutureMonth)>
                    {{ $monthName }}
                </option>
            @endforeach
        </select>

        <select
            class="archive-year-select w-full border border-slate-300 bg-white px-2 py-1.5 text-xs md:text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary rounded-sm"
            aria-label="বছর নির্বাচন">
            @foreach($years as $year)
            <option value="{{ $year }}" @selected($monthStart->year === (int) $year)>{{ $toBn($year) }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex items-center justify-between mb-3">
        <a href="{{ route('archive', array_filter(['month' => $prevMonth, 'date' => $selectedKey])) }}"
            class="p-1 text-slate-800 hover:text-primary transition-colors"
            aria-label="আগের মাস">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </a>
        <div class="text-sm md:text-base font-bold text-slate-900 text-center">
            {{ $bnMonths[$monthStart->month - 1] }} {{ $toBn($monthStart->year) }}
        </div>
        <a href="{{ route('archive', array_filter(['month' => $nextMonth, 'date' => $selectedKey])) }}"
            class="p-1 text-slate-800 hover:text-primary transition-colors {{ $canGoNext ? '' : 'pointer-events-none opacity-30' }}"
            aria-label="পরের মাস">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-7 gap-1 text-center text-[11px] md:text-xs mb-1">
        @foreach($bnDays as $dayLabel)
        <div class="font-bold text-slate-800 py-1">{{ $dayLabel }}</div>
        @endforeach
    </div>

    <div class="grid grid-cols-7 gap-1 text-center text-xs md:text-sm">
        @php $day = $gridStart->copy(); @endphp
        @while($day->lte($gridEnd))
            @php
                $inMonth = $day->isSameMonth($monthStart);
                $dateKey = $day->format('Y-m-d');
                $isFuture = $day->gt($today);
                $hasPosts = $postDates->has($dateKey);
                $isSelected = $selectedKey === $dateKey;
                $isToday = $day->isSameDay($today);
                $dayNumber = $day->day;
            @endphp

            @if($inMonth && ! $isFuture)
            <a href="{{ route('archive', ['date' => $dateKey, 'month' => $monthStart->format('Y-m')]) }}"
                class="aspect-square flex items-center justify-center rounded-sm transition-colors
                    {{ $isSelected ? 'bg-primary text-white font-bold' : ($hasPosts ? 'bg-slate-200 text-slate-900 font-bold hover:bg-primary/15 hover:text-primary' : 'text-slate-900 font-medium hover:bg-slate-100 hover:text-primary') }}
                    {{ $isToday && ! $isSelected ? 'ring-2 ring-primary' : '' }}">
                {{ $toBn($dayNumber) }}
            </a>
            @else
            <span class="aspect-square flex items-center justify-center rounded-sm text-slate-400">
                {{ $inMonth ? $toBn($dayNumber) : '' }}
            </span>
            @endif
            @php $day->addDay(); @endphp
        @endwhile
    </div>

    @if($selectedDate)
    <div class="mt-3 pt-3 border-t border-slate-200 text-center">
        <a href="{{ route('archive', ['month' => $monthStart->format('Y-m')]) }}"
            class="text-xs md:text-sm font-medium text-primary hover:underline">
            সব খবর দেখুন
        </a>
    </div>
    @endif
</div>

<script>
(function () {
    document.querySelectorAll('.archive-calendar-wrap').forEach(function (wrap) {
        var monthSelect = wrap.querySelector('.archive-month-select');
        var yearSelect = wrap.querySelector('.archive-year-select');
        if (!monthSelect || !yearSelect) return;

        var selectedDate = monthSelect.dataset.selectedDate || '';

        function goToArchiveMonthYear() {
            var month = monthSelect.value;
            var year = yearSelect.value;
            var monthParam = year + '-' + month;
            var url = new URL(@json(route('archive')), window.location.origin);
            url.searchParams.set('month', monthParam);

            if (selectedDate && selectedDate.indexOf(monthParam) === 0) {
                url.searchParams.set('date', selectedDate);
            }

            window.location.href = url.toString();
        }

        monthSelect.addEventListener('change', goToArchiveMonthYear);
        yearSelect.addEventListener('change', goToArchiveMonthYear);
    });
})();
</script>
