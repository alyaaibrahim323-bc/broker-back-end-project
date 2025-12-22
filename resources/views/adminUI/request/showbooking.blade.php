@extends('layouts.dashboardUI')

@section('title', 'View Booking')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Back Button -->
    <a href="{{ route('bookings.index') }}" class="inline-flex items-center gap-2 mb-8 text-black hover:text-gray-600">
        <span class="text-3xl">←</span>
        <span class="text-sm font-medium">Back</span>
    </a>

    <h2 class="text-4xl font-bold mb-10 ml-10 font-[Urbanist]">Booking Details</h2>

    <!-- Main Content -->
    <div class="grid gap-8 ml-10 max-w-5xl">
        <!-- User Section -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2 w-30">User Name</label>
                <div class="bg-gray-50 p-4 rounded-full border border-gray-200">
                    {{ $booking->user->name }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <div class="bg-gray-50 p-4 rounded-full border border-gray-200">
                    {{ $booking->phone_number }}
                </div>
            </div>
        </div>

        <!-- Property Section -->
        <div class="grid grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Property</label>
                <div class="bg-gray-50 p-4 rounded-full border border-gray-200">
                    {{ $booking->property->title }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <div class="status-badge {{ $booking->status }}">
                    {{ $booking->status }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                <div class="bg-gray-50 p-4 rounded-full border border-gray-200">
                    ${{ number_format($booking->price, 2) }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Final Booking</label>
                <div class="check-indicator {{ $booking->is_final_booking ? 'active' : '' }}"></div>
            </div>
        </div>

        <!-- Dates Section -->
        <div class="grid grid-cols-4 gap-4 items-center">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Booking Date</label>
                <div class="bg-gray-50 p-4 rounded-full border border-gray-200">
                    {{ $booking->booking_date }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Viewing Date</label>
                <div class="bg-gray-50 p-4 rounded-full border border-gray-200">
                    {{ $booking->viewing_date ?? '-' }}
                </div>
            </div>
            <div class="flex gap-2">
          <button onclick="openActionModal()" class="bg-gray-200 hover:bg-gray-300 rounded-full px-6 py-3 font-medium">
              Add Action
          </button>
          <button onclick="openHistoryModal()" class="bg-[#0a9e6d] text-white rounded-full px-6 py-3 font-medium">
              Action History
          </button>
        </div>
        </div>

        <!-- Developer Section -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Developer Name</label>
                <div class="bg-gray-50 p-4 rounded-full border border-gray-200">
                    {{ $booking->developer_name ?? 'N/A' }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Project Name</label>
                <div class="bg-gray-50 p-4 rounded-full border border-gray-200">
                    {{ $booking->project_name ?? 'N/A' }}
                </div>
            </div>
        </div>


    <!-- Edit Booking Button -->
    <div class="d-flex justify-content-end mt-4" style="margin-inline-end: 70px;">
        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-custom" style="background: #0a9e6d; color: white;">Edit Booking</a>
    </div>
</div>

<!-- Add Action Modal -->
<div id="actionModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
  <div class="bg-white rounded-xl w-full max-w-md p-6 relative">
    <button onclick="closeActionModal()" class="absolute top-3 right-3 text-gray-500">&times;</button>
    <h2 class="text-lg font-semibold mb-4">Add New Action</h2>

    <form method="POST" action="{{ route('bookings.addAction', $booking->id) }}">
        @csrf
        @method('PUT')

        <label class="block text-sm text-gray-500 mb-1">Action Type</label>
        <select name="action_type" class="w-full rounded-md border px-4 py-2 mb-4" required>
            <option value="">Select Action</option>
            <option value="Follow-up">Follow-up</option>
            <option value="Meeting">Meeting</option>
            <option value="Documentation">Documentation</option>
        </select>

        <label class="block text-sm text-gray-500 mb-1">Date</label>
        <input type="date" name="action_date" class="w-full rounded-md border px-4 py-2 mb-4" required>

        <label class="block text-sm text-gray-500 mb-1">Notes</label>
        <textarea name="action_notes" class="w-full rounded-md border px-4 py-2 mb-4"></textarea>

        <button type="submit" class="bg-[#0a9e6d] text-white rounded-md px-4 py-2 w-full hover:bg-green-700">
            Create Action
        </button>
    </form>
  </div>
</div>

<script>
function closeActionModal() {
    document.getElementById('actionModal').classList.add('hidden');
}

// إغلاق المودال عند الإرسال الناجح
document.querySelector('#actionModal form').addEventListener('submit', function() {
    setTimeout(closeActionModal, 500);
});
</script>

<!-- Action History Modal -->
<div id="historyModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
  <div class="bg-white rounded-xl w-full max-w-xl p-6 relative max-h-[80vh] overflow-y-auto">
    <button onclick="closeHistoryModal()" class="absolute top-3 right-3 text-gray-500">&times;</button>
    <h2 class="text-lg font-semibold mb-4">Action History</h2>
    <div class="space-y-4">
      @forelse($booking->list_of_actions ?? [] as $action)
        @if(is_array($action))
          <div class="bg-gray-50 p-4 rounded-lg">
            <div class="flex justify-between items-start mb-2">
              <div>
                <h3 class="font-medium text-gray-800">
                  {{ $action['type'] ?? 'Untitled Action' }}
                </h3>
                @isset($action['date'])
                  <p class="text-sm text-gray-600">
                    {{ \Carbon\Carbon::parse($action['date'])->format('M d, Y') }}
                  </p>
                @endisset
              </div>
              @isset($action['notes'])
             <p class="text-lg text-gray-800">
                {{ $action['notes'] }}
            </p>

              @endisset
            </div>
          </div>
        @endif
      @empty
        <p class="text-center text-gray-500 py-4">No actions found</p>
      @endforelse
    </div>
  </div>
</div>


<style>


.status-badge {
    text-transform: uppercase;
    font-weight: 600;
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    inline-size: fit-content;
}

.status-badge.Pending { background: #88601b; }
.status-badge.Confirmed { background: #0a9e6d; }
.status-badge.Cancelled { background: #dc3545; }

.check-indicator {
    inline-size: 24px;
    block-size: 24px;
    border: 2px solid #E0E0E0;
    border-radius: 6px;
    position: relative;
}

.check-indicator.active {
    background: #007bff;
    border-color: #007bff;
}

.check-indicator.active::after {
    content: '✓';
    color: white;
    position: absolute;
    inset-block-start: 50%;
    inset-inline-start: 50%;
    transform: translate(-50%, -50%);
}

.notes-content {
    min-block-size: 120px;
    white-space: pre-wrap;
}
</style>

<script>
  function openActionModal() {
    document.getElementById('actionModal').classList.remove('hidden');
  }
  function closeActionModal() {
    document.getElementById('actionModal').classList.add('hidden');
  }
  function openHistoryModal() {
    document.getElementById('historyModal').classList.remove('hidden');
  }
  function closeHistoryModal() {
    document.getElementById('historyModal').classList.add('hidden');
  }
document.querySelector('#actionModal form').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this)
    }).then(() => window.location.reload());
});

</script>
@endsection
