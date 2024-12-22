<!-- resources/views/components/dropdown.blade.php -->
<div class="relative">
    <button {{ $trigger->attributes->merge(['class' => 'dropdown-trigger']) }}>
        {{ $trigger }}
    </button>

    <div class="dropdown-content">
        {{ $content }}
    </div>
</div>
