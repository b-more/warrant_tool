<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warrant Report - {{ $warrant->warrant_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-white">

    <!-- Print Button -->
    <div class="no-print p-4 bg-gray-100">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <a href="{{ route('warrants.show', $warrant) }}"
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Back to Warrant
            </a>
            <button onclick="window.print()"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Print Report
            </button>
        </div>
    </div>

    <!-- Report Content -->
    <div class="max-w-4xl mx-auto p-8">

        <!-- Header -->
        <div class="text-center mb-8 border-b-2 border-gray-300 pb-6">
            <div class="flex justify-center items-center mb-4">
                <!-- Zambian Coat of Arms placeholder -->
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                    <span class="text-xs text-gray-500">COAT</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">REPUBLIC OF ZAMBIA</h1>
                    <h2 class="text-lg font-semibold text-gray-700">ANTI-FRAUDS AND CYBER CRIME UNIT</h2>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mt-4">WARRANT INVESTIGATION REPORT</h3>
        </div>

        <!-- Warrant Information -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-300 pb-2">WARRANT DETAILS</h3>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="mb-2"><strong>Warrant Number:</strong> {{ $warrant->warrant_number }}</p>
                    <p class="mb-2"><strong>Investigating Officer:</strong> {{ $warrant->officer_name }}</p>
                    <p class="mb-2"><strong>Station:</strong> {{ $warrant->station }}</p>
                    <p class="mb-2"><strong>Date Created:</strong> {{ $warrant->created_at->format('F j, Y') }}</p>
                </div>
                <div>
                    <p class="mb-2"><strong>Investigation Period:</strong></p>
                    <p class="ml-4 mb-2">From: {{ $warrant->period_from->format('F j, Y') }}</p>
                    <p class="ml-4 mb-2">To: {{ $warrant->period_to->format('F j, Y') }}</p>
                    <p class="mb-2"><strong>Status:</strong> {{ ucfirst($warrant->status) }}</p>
                    @if($warrant->suspect_name)
                    <p class="mb-2"><strong>Suspect:</strong> {{ $warrant->suspect_name }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Target Phone Numbers -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-300 pb-2">TARGET PHONE NUMBERS</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach($warrant->phone_numbers as $index => $phone)
                    <div class="border border-gray-300 p-2 bg-gray-50">
                        <span class="font-medium">{{ $index + 1 }}.</span> {{ $phone }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Investigation Description -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-300 pb-2">INVESTIGATION DESCRIPTION</h3>
            <div class="border border-gray-300 p-4 bg-gray-50">
                <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $warrant->description }}</p>
            </div>
        </div>

        <!-- Files Information -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-300 pb-2">EVIDENCE FILES</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="border border-gray-300 p-4">
                    <h4 class="font-semibold mb-2">Call Detail Records (CDR)</h4>
                    @if($warrant->cdr_file_path)
                        <p class="text-sm">✓ File: {{ basename($warrant->cdr_file_path) }}</p>
                        <p class="text-sm text-gray-600">Status: Uploaded</p>
                    @else
                        <p class="text-sm text-gray-500">No CDR file uploaded</p>
                    @endif
                </div>

                <div class="border border-gray-300 p-4">
                    <h4 class="font-semibold mb-2">Know Your Customer (KYC)</h4>
                    @if($warrant->kyc_file_path)
                        <p class="text-sm">✓ File: {{ basename($warrant->kyc_file_path) }}</p>
                        <p class="text-sm text-gray-600">Status: Uploaded</p>
                    @else
                        <p class="text-sm text-gray-500">No KYC file uploaded</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Analysis Summary (Basic) -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-300 pb-2">ANALYSIS SUMMARY</h3>
            <div class="border border-gray-300 p-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="font-semibold text-2xl text-blue-600">{{ count($warrant->phone_numbers) }}</p>
                        <p class="text-sm text-gray-600">Target Numbers</p>
                    </div>
                    <div>
                        <p class="font-semibold text-2xl text-green-600">{{ $warrant->period_from->diffInDays($warrant->period_to) + 1 }}</p>
                        <p class="text-sm text-gray-600">Investigation Days</p>
                    </div>
                    <div>
                        <p class="font-semibold text-2xl text-purple-600">{{ $warrant->hasFiles() ? 'Yes' : 'No' }}</p>
                        <p class="text-sm text-gray-600">Evidence Files</p>
                    </div>
                </div>

                @if(!$warrant->hasFiles())
                <div class="mt-4 p-3 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
                    <p class="text-sm">⚠️ No CDR or KYC files have been uploaded for analysis.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 pt-6 border-t border-gray-300">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <p class="font-semibold mb-2">Investigating Officer:</p>
                    <div class="border-b border-gray-400 mb-2" style="height: 40px;"></div>
                    <p class="text-sm">{{ $warrant->officer_name }}</p>
                    <p class="text-sm text-gray-600">{{ $warrant->station }}</p>
                </div>
                <div>
                    <p class="font-semibold mb-2">Date:</p>
                    <div class="border-b border-gray-400 mb-2" style="height: 40px;"></div>
                    <p class="text-sm">{{ now()->format('F j, Y') }}</p>
                </div>
            </div>

            <div class="text-center mt-8 text-sm text-gray-600">
                <p>This report was generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
                <p>Warrant Number: {{ $warrant->warrant_number }}</p>
            </div>
        </div>
    </div>
</body>
</html>
