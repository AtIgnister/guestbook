<?php
use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

new class extends Component {
    public User $user;
    public Collection $guestbooks;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->user = Auth::user();
        $this->guestbooks = $this->user->guestbooks;
    }
};

?>
<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Developer Settings')" :subheading="__('View Developer Information & change your accounts API settings')">
        <h2 id="guestbook_info">Guestbook Info</h2>
        <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">
            <table class="w-full text-sm text-left">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-zinc-700 dark:text-zinc-200">
                            Guestbook Name
                        </th>
                        <th class="px-6 py-4 font-semibold text-zinc-700 dark:text-zinc-200">
                            Guestbook ID
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach ($this->guestbooks as $guestbook)
                        <tr
                            class="bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-5 font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $guestbook->name }}
                            </td>
                            <td class="px-6 py-5 text-zinc-600 dark:text-zinc-400">
                                {{ $guestbook->id }}

                                <button class="block mt-2 text-sm"
                                    onclick="navigator.clipboard.writeText('{{ $guestbook->id }}')">
                                    Copy
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2>API Settings</h2>
        <p>Coming soon!</p>
    </x-settings.layout>
</section>
