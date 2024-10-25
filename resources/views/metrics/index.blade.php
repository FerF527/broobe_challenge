@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Broobe Challenge</h1>
    <div class="tabs">
        <button class="tab active" data-tab="run-metric">Run Metric</button>
        <button class="tab" data-tab="metric-history">Metric History</button>
    </div>

    <div id="run-metric" class="tab-content active">
        <form id="metrics-form">
            @csrf
            <div class="form-group">
                <label for="url">URL</label>
                <input type="text" id="url" name="url" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="categories">Categories</label>
                <div class="checkbox-group">
                    @foreach($categories as $category)
                        <label>
                            <input type="checkbox" name="categories[]" value="{{ $category->name }}" checked>
                            {{ $category->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="strategy">Strategy</label>
                <select id="strategy" name="strategy" class="form-control" required>
                    @foreach($strategies as $strategy)
                        <option value="{{ $strategy->id }}">{{ $strategy->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="button" id="get-metrics" class="btn btn-primary">Get Metrics</button>
        </form>

        <div id="metrics-results" class="metrics-results" style="display:none;">
            
        </div>

        <button type="button" id="save-metric" class="btn btn-success" style="display:none;">Save Metric Run</button>
    </div>
</div>

@endsection