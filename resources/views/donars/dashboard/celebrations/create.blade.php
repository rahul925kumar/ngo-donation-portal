@extends('donars.dashboard.celebrations.form')

@section('content')
@php
    $action = route('celebrations.store');
@endphp

@parent
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#celebrationForm').attr('action', '{{ $action }}');
    });
</script>
@endpush 