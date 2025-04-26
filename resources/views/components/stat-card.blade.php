<div>
    <!-- Simplicity is an acquired taste. - Katharine Gerould -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center">
    @if($icon)
        <div class="text-blue-500 mr-4">
            {!! $icon !!}
        </div>
    @endif
    <div>
        <h4 class="text-gray-600 text-sm">{{ $title }}</h4>
        <div class="text-2xl font-bold">{{ $value }}</div>
    </div>
</div>

</div>