{{-- Solaiman Lipi @font-face — asset() পাথ (সাবডিরেক্টরি/ডেপ্লয় সেফ) --}}
<style>
@font-face {
    font-family: "SolaimanLipi";
    font-style: normal;
    font-display: swap;
    font-weight: 400;
    src:
        url("{{ asset('fonts/SolaimanLipi.woff2') }}") format("woff2"),
        url("{{ asset('fonts/SolaimanLipi.ttf') }}") format("truetype");
}
@font-face {
    font-family: "SolaimanLipi";
    font-style: normal;
    font-display: swap;
    font-weight: 700;
    src:
        url("{{ asset('fonts/SolaimanLipi-Bold.woff2') }}") format("woff2"),
        url("{{ asset('fonts/SolaimanLipi-Bold.ttf') }}") format("truetype");
}
</style>
