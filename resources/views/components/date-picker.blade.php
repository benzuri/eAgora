<div>
    <input x-data x-ref="input" x-on:change="$dispatch('input', $el.value)" x-init="new Pikaday({field: $refs.input})" type="text" {{ $attributes }}>
</div>