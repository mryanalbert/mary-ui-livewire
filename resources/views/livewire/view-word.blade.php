<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <h1>View word</h1>
    @if ($word)
        <x-list-item :item="$word" />
    @else
        <p>No data available</p>
    @endif
</div>
