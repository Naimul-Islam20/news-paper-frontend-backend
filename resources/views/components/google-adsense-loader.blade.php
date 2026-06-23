@if(google_adsense_configured())
@php $adsenseClient = google_adsense_client(); @endphp
@if($adsenseClient)
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ urlencode($adsenseClient) }}" crossorigin="anonymous"></script>
@endif
@endif
