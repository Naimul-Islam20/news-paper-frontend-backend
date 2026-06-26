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
$activeKey = $selectedKey;
$years = ! empty($archiveYears) ? $archiveYears : [$monthStart->year];
@endphp

<div class="archive-calendar-wrap border border-slate-300 bg-[#EFEFEF] p-3 md:p-4 notranslate" data-calendar-month="{{ $monthStart->format('Y-m') }}">
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
        <button
            type="button"
            data-archive-cal-month="{{ $prevMonth }}"
            class="archive-cal-nav p-1 text-slate-800 hover:text-primary transition-colors"
            aria-label="আগের মাস">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <div class="archive-cal-label text-sm md:text-base font-bold text-slate-900 text-center">
            @if($selectedDate)
                {{ $toBn($selectedDate->day) }} {{ $bnMonths[$selectedDate->month - 1] }} {{ $toBn($selectedDate->year) }}
            @else
                {{ $bnMonths[$monthStart->month - 1] }} {{ $toBn($monthStart->year) }}
            @endif
        </div>
        <button
            type="button"
            data-archive-cal-month="{{ $nextMonth }}"
            class="archive-cal-nav p-1 text-slate-800 hover:text-primary transition-colors {{ $canGoNext ? '' : 'opacity-30 cursor-not-allowed' }}"
            aria-label="পরের মাস"
            @disabled(! $canGoNext)>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
    </div>

    <div class="bg-[#EFEFEF] rounded-sm overflow-hidden border border-slate-300">
        <div class="grid grid-cols-7 text-center text-[11px] md:text-xs">
            @foreach($bnDays as $dayLabel)
            <div class="font-bold text-slate-700 py-1.5 bg-[#DDDDDD] border-r border-b border-slate-300 [&:nth-child(7n)]:border-r-0">{{ $dayLabel }}</div>
            @endforeach
        </div>

        <div class="grid grid-cols-7 text-center text-xl md:text-2xl">
            @php $day = $gridStart->copy(); @endphp
            @while($day->lte($gridEnd))
            @php
            $inMonth = $day->isSameMonth($monthStart);
            $dateKey = $day->format('Y-m-d');
            $isFuture = $day->gt($today);
            $hasPosts = $postDates->has($dateKey);
            $isSelected = $activeKey === $dateKey;
            $isToday = $day->isSameDay($today);
            $dayNumber = $day->day;
            @endphp

            @if($inMonth && ! $isFuture)
            <a href="{{ route('archive', ['date' => $dateKey, 'month' => $monthStart->format('Y-m')]) }}"
                class="aspect-square flex items-center justify-center border-r border-b border-slate-300 [&:nth-child(7n)]:border-r-0 transition-colors
                        {{ $isSelected ? '!border-primary bg-primary text-white font-medium z-10 relative' : 'bg-[#EFEFEF] text-slate-900 font-medium hover:bg-primary/10 hover:text-primary' }}
                        {{ $isToday && ! $isSelected ? 'ring-1 ring-inset ring-primary' : '' }}">
                {{ $toBn($dayNumber) }}
            </a>
            @elseif($inMonth && $isFuture)
            <span class="aspect-square flex items-center justify-center border-r border-b border-slate-300 [&:nth-child(7n)]:border-r-0 bg-[#EFEFEF] text-[#b6bcc5] font-medium">
                {{ $toBn($dayNumber) }}
            </span>
            @else
            <span class="aspect-square flex items-center justify-center border-r border-b border-slate-300 [&:nth-child(7n)]:border-r-0 bg-[#EFEFEF]"></span>
            @endif
            @php $day->addDay(); @endphp
            @endwhile
        </div>
    </div>

    @if($selectedDate)
    <div class="mt-3 pt-3 border-t border-slate-200 text-center">
        <a href="{{ route('archive') }}"
            class="text-xs md:text-sm font-medium text-primary hover:underline">
            সব খবর দেখুন
        </a>
    </div>
    @endif
</div>
