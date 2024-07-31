<form method="GET" action="{{ $action }}">
    <input type="text" name="search" value="{{ request()->get('search') }}" class="px-4 w-96 h-full py-2 bg-[#F5F6FA] rounded-3xl border border-[#D5D5D5]" placeholder="{{ $placeholder }}">
</form> 