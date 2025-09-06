<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Warrant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('warrants.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Warrant Number -->
                            <div>
                                <label for="warrant_number" class="block text-sm font-medium text-gray-700">Warrant Number</label>
                                <input type="text" name="warrant_number" id="warrant_number" value="{{ old('warrant_number') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('warrant_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Officer Name -->
                            <div>
                                <label for="officer_name" class="block text-sm font-medium text-gray-700">Officer Name</label>
                                <input type="text" name="officer_name" id="officer_name" value="{{ old('officer_name') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('officer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Station -->
                            <div>
                                <label for="station" class="block text-sm font-medium text-gray-700">Station</label>
                                <input type="text" name="station" id="station" value="{{ old('station') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('station')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Suspect Name -->
                            <div>
                                <label for="suspect_name" class="block text-sm font-medium text-gray-700">Suspect Name (Optional)</label>
                                <input type="text" name="suspect_name" id="suspect_name" value="{{ old('suspect_name') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('suspect_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone Numbers -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Numbers</label>
                            <div id="phone-numbers-container">
                                <div class="flex mb-2">
                                    <input type="text" name="phone_numbers[]" placeholder="e.g., +260977209848" required
                                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <button type="button" onclick="addPhoneNumber()"
                                            class="ml-2 px-3 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">+</button>
                                </div>
                            </div>
                            @error('phone_numbers')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Period -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="period_from" class="block text-sm font-medium text-gray-700">Period From</label>
                                <input type="date" name="period_from" id="period_from" value="{{ old('period_from') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('period_from')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="period_to" class="block text-sm font-medium text-gray-700">Period To</label>
                                <input type="date" name="period_to" id="period_to" value="{{ old('period_to') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('period_to')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Uploads -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="cdr_file" class="block text-sm font-medium text-gray-700">CDR File (Optional)</label>
                                <input type="file" name="cdr_file" id="cdr_file" accept=".xlsx,.xls,.csv"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @error('cdr_file')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kyc_file" class="block text-sm font-medium text-gray-700">KYC File (Optional)</label>
                                <input type="file" name="kyc_file" id="kyc_file" accept=".xlsx,.xls,.csv"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @error('kyc_file')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('warrants.index') }}"
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Warrant
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addPhoneNumber() {
            const container = document.getElementById('phone-numbers-container');
            const div = document.createElement('div');
            div.className = 'flex mb-2';
            div.innerHTML = `
                <input type="text" name="phone_numbers[]" placeholder="e.g., +260977209848" required
                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <button type="button" onclick="removePhoneNumber(this)"
                        class="ml-2 px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">-</button>
            `;
            container.appendChild(div);
        }

        function removePhoneNumber(button) {
            button.parentElement.remove();
        }
    </script>
</x-app-layout>
