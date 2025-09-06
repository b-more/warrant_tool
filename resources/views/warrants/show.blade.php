<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Warrant: {{ $warrant->warrant_number }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('warrants.edit', $warrant) }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('warrants.report', $warrant) }}"
                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Generate Report
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <!-- Warrant Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Warrant Information</h3>

                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-700">Warrant Number:</span>
                                    <span class="text-gray-900">{{ $warrant->warrant_number }}</span>
                                </div>

                                <div>
                                    <span class="font-medium text-gray-700">Officer:</span>
                                    <span class="text-gray-900">{{ $warrant->officer_name }}</span>
                                </div>

                                <div>
                                    <span class="font-medium text-gray-700">Station:</span>
                                    <span class="text-gray-900">{{ $warrant->station }}</span>
                                </div>

                                @if($warrant->suspect_name)
                                <div>
                                    <span class="font-medium text-gray-700">Suspect:</span>
                                    <span class="text-gray-900">{{ $warrant->suspect_name }}</span>
                                </div>
                                @endif

                                <div>
                                    <span class="font-medium text-gray-700">Status:</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($warrant->status === 'completed') bg-green-100 text-green-800
                                        @elseif($warrant->status === 'processing') bg-blue-100 text-blue-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($warrant->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Investigation Period</h3>

                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-700">From:</span>
                                    <span class="text-gray-900">{{ $warrant->period_from->format('F j, Y') }}</span>
                                </div>

                                <div>
                                    <span class="font-medium text-gray-700">To:</span>
                                    <span class="text-gray-900">{{ $warrant->period_to->format('F j, Y') }}</span>
                                </div>

                                <div>
                                    <span class="font-medium text-gray-700">Duration:</span>
                                    <span class="text-gray-900">{{ $warrant->period_from->diffInDays($warrant->period_to) + 1 }} days</span>
                                </div>

                                <div>
                                    <span class="font-medium text-gray-700">Created:</span>
                                    <span class="text-gray-900">{{ $warrant->created_at->format('F j, Y g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Phone Numbers -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Target Phone Numbers</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach($warrant->phone_numbers as $phone)
                                    <div class="bg-white px-3 py-2 rounded border text-sm font-mono">
                                        {{ $phone }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $warrant->description }}</p>
                        </div>
                    </div>

                    <!-- Files -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Uploaded Files</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- CDR File -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-2">CDR File</h4>
                                @if($warrant->cdr_file_path)
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-gray-700">{{ basename($warrant->cdr_file_path) }}</span>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No CDR file uploaded</p>
                                @endif
                            </div>

                            <!-- KYC File -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-2">KYC File</h4>
                                @if($warrant->kyc_file_path)
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-gray-700">{{ basename($warrant->kyc_file_path) }}</span>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No KYC file uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between">
                        <a href="{{ route('warrants.index') }}"
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            ← Back to Warrants
                        </a>

                        <div class="space-x-2">
                            <a href="{{ route('warrants.edit', $warrant) }}"
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit Warrant
                            </a>

                            <form method="POST" action="{{ route('warrants.destroy', $warrant) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this warrant?')"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
