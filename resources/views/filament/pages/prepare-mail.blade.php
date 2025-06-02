<x-filament-panels::page>
    <div class="space-y-2">
        <h2 class="text-lg font-semibold">
            Prepare data for sent mail.
        </h2>

        @if ($replacements->count())
            <table class="w-full text-sm text-left text-gray-700 border border-gray-600">
                <thead class="bg-gray-200">
                <tr>
                    <th class="px-3 py-2">Region</th>
                    <th class="px-3 py-2">Distributor Name</th>
                    <th class="px-3 py-2">Retailer Code</th>
                    <th class="px-3 py-2">i'top-up Mobile No</th>
                    <th class="px-3 py-2">New swap Sim Serial No [Full]</th>
                    <th class="px-3 py-2">Reason for SWAP</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($replacements as $item)
                    <tr class="border-t border-gray-600">
                        <td class="px-3 py-2">{{ $item->house->region ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $item->house->name ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $item->issueRetailer->code ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $item->retailer->itop_number ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $item->sim_serial }}</td>
                        <td class="px-3 py-2 capitalize">{{ $item->reason }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">No replacement data found.</p>
        @endif
    </div>
</x-filament-panels::page>
