<x-layouts.settings>
    <div class="p-6 space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Appearance') }}</flux:heading>
            <flux:subheading>{{ __('Update the appearance settings for your account') }}</flux:subheading>
        </div>

        <div class="rounded-lg border bg-card p-4">
            <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class="w-full">
                <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
                <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
                <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
            </flux:radio.group>
        </div>
    </div>
</x-layouts.settings>