<div class="row">
    <div class="col col-lg-8 col-md-10 col-sm-12">
        <label>{{ __('messages.Title') }}</label>
        <input type="text"
            name="title"
            class="form-control"
            placeholder="{{ __('messages.Title') }}"
            value="{{ $incident->title ?? old('title', '') }}" />
    </div>
</div>
<div class="row">
    <div class="col col-12">
        <label>{{ __('messages.Description') }}</label>
        <textarea name="description"
            class="form-control"
            placeholder="{{ __('messages.Description') }}"
            rows="6"
        >{{ $incident->description ?? old('description', '') }}</textarea>
    </div>
</div>
@php
    $selectedCriticality = $incident->criticality ?? old('criticality', '');
    $selectedType        = $incident->type ?? old('type', '');
    $selectedStatus      = ($incident->status ?? old('status', 'A')) === 'A';
@endphp
<div class="row">
    <div class="col col-lg-3 col-md-4 col-sm-12">
        <label>{{ __('messages.Criticality') }}</label>
        <select name="criticality" class="form-select">
            @foreach ($criticality as $item)
                <option value="{{ $item }}" @if ($selectedType === $item) selected @endif>
                    {{ __('messages.CriticalityOptions.' . $item) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col col-lg-3 col-md-4 col-sm-12">
        <label>{{ __('messages.Type') }}</label>
        <select name="type" class="form-select">
            @foreach ($type as $item)
                <option value="{{ $item }}" @if ($selectedType === $item) selected @endif>
                    {{ __('messages.TypeOptions.' . $item) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col col-lg-3 col-md-4 col-sm-12 pt-4">
        <div class="form-check form-switch mt-1">
            <input type="checkbox"
                class="form-check-input"
                name="status"
                id="status"
                @if ($selectedStatus) checked @endif
            >
            <label class="form-check-label" for="status">
                {{ __('messages.Active')}}
            </label>
        </div>
    </div>
</div>
