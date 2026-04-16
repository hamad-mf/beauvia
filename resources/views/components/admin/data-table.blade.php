{{-- resources/views/components/admin/data-table.blade.php --}}
@props(['headers' => [], 'bulkActions' => false])

<div class="glass-card overflow-hidden">
    @if($bulkActions)
    <div x-data="{ selected: [], selectAll: false }" x-init="$watch('selectAll', value => selected = value ? Array.from(document.querySelectorAll('.row-checkbox')).map(cb => cb.value) : [])">
        <div x-show="selected.length > 0" class="bg-primary-50 border-b border-primary-100 px-4 py-3 flex items-center justify-between">
            <span class="text-sm text-primary-700"><span x-text="selected.length"></span> selected</span>
            {{ $bulkActions }}
        </div>
    @endif
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    @if($bulkActions)
                    <th class="px-4 py-3 text-left">
                        <input type="checkbox" x-model="selectAll" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    </th>
                    @endif
                    @foreach($headers as $header)
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                {{ $slot }}
            </tbody>
        </table>
    </div>
    
    @if($bulkActions)
    </div>
    @endif
</div>
