@props(['items'])

<form class="pagination-form">
    <span>Show</span>
        <select value="{{ $items }}">
            <option value="10" {{ $items == 10 ? "selected" : "" }}>10</option>
            <option value="25" {{ $items == 25 ? "selected" : "" }}>25</option>
            <option value="50" {{ $items == 50 ? "selected" : "" }}>50</option>
            <option value="100" {{ $items == 100 ? "selected" : "" }}>100</option>
        </select>
    <span>entries</span>
</form>