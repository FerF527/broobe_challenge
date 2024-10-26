<div class="metric-results">
    @foreach($metrics as $metricName => $metricValue)
        <div class="metric">
            <strong>{{ $metricName }}</strong>: {{ $metricValue }}
        </div>
    @endforeach
</div>