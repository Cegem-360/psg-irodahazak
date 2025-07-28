@props(['name', 'options' => [], 'selected' => [], 'label' => null])

<div class="filament-forms-component">
    @if ($label)
        <label>{{ $label }}</label>
    @endif
    <select name="{{ $name }}[]" multiple class="form-select">
        @foreach ($options as $id => $option)
            <option value="{{ $id }}" @if (in_array($id, $selected)) selected @endif>{{ $option }}
            </option>
        @endforeach
    </select>
</div>
