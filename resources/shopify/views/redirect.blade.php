@extends('shopify::layouts.base')

@section('content')
    <div style="text-align: center; position: fixed; left: 0; right: 0; top: 50%; transform: translateY(-50%);">
        <p>Redirecting...</p>
    </div>
@endsection

@push('scripts')
    <script type='text/javascript'>
        // If the current window is the 'parent', change the URL by setting location.href
        if (window.top === window.self) {
            window.top.location.href = "{{ $url }}";
        }

        // If the current window is the 'child', change the parent's URL with postMessage
        else {
            window.parent.postMessage(
                JSON.stringify({
                    message: "Shopify.API.remoteRedirect",
                    data: { location: "{{ $url }}" }
                }),
                "{{ $shop }}"
            );
        }
    </script>
@endpush