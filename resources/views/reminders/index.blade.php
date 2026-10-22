<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Task Reminders') }}
            </h2>
            <a href="{{ route('reminders.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Reminder
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4 flex gap-2">
                        <a href="{{ route('reminders.index', ['filter' => 'all']) }}" 
                           class="px-3 py-2 rounded {{ $filter === 'all' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                            All
                        </a>
                        <a href="{{ route('reminders.index', ['filter' => 'due']) }}" 
                           class="px-3 py-2 rounded {{ $filter === 'due' ? 'bg-red-500 text-white' : 'bg-gray-200' }}">
                            Due
                        </a>
                        <a href="{{ route('reminders.index', ['filter' => 'upcoming']) }}" 
                           class="px-3 py-2 rounded {{ $filter === 'upcoming' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
                            Upcoming
                        </a>
                        <a href="{{ route('reminders.index', ['filter' => 'completed']) }}" 
                           class="px-3 py-2 rounded {{ $filter === 'completed' ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                            Completed
                        </a>
                    </div>

                    @if ($reminders->isEmpty())
                        <p class="text-gray-500 text-center py-8">No reminders found.</p>
                    @else
                        <div class="space-y-4">
                            @foreach ($reminders as $reminder)
                                <div class="border rounded-lg p-4 {{ $reminder->completed ? 'bg-gray-50' : 'bg-white' }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-lg {{ $reminder->completed ? 'line-through text-gray-500' : '' }}">
                                                {{ $reminder->title }}
                                            </h3>
                                            @if ($reminder->description)
                                                <p class="text-gray-600 mt-1">{{ $reminder->description }}</p>
                                            @endif
                                            <div class="mt-2 text-sm text-gray-500 space-y-1">
                                                <p>
                                                    <strong>Due:</strong> 
                                                    <span class="{{ $reminder->due_date->isPast() && !$reminder->completed ? 'text-red-600 font-semibold' : '' }}">
                                                        {{ $reminder->due_date->format('M d, Y H:i') }}
                                                    </span>
                                                </p>
                                                @if ($reminder->remind_at)
                                                    <p><strong>Remind at:</strong> {{ $reminder->remind_at->format('M d, Y H:i') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex gap-2 ml-4">
                                            @if (!$reminder->completed)
                                                <form action="{{ route('reminders.complete', $reminder) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                        Complete
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('reminders.uncomplete', $reminder) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                                        Reopen
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('reminders.edit', $reminder) }}" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('reminders.destroy', $reminder) }}" method="POST" onsubmit="return confirm('Delete this reminder?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $reminders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
