    <?php

    use Livewire\Component;
    use Livewire\Attributes\On;

    new class extends Component
    {
        public string $name;

        public ?string $title = null;

        public string $saveEvent;
        public ?string $cancelEvent = null;

        public function save()
        {
            $this->dispatch($this->saveEvent);
        }

        public function cancel()
        {
            if ($this->cancelEvent) {
                $this->dispatch($this->cancelEvent);
            }
        }
    };
    ?>

    <flux:modal :name="$name" class="max-w-md">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ $title }}
                </flux:heading>
            </div>
            <div>
                {{ $slot }}
            </div>
            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button
                        type="button"
                        variant="ghost"
                        wire:click="cancel"
                    >
                        Cancel
                    </flux:button>
                </flux:modal.close>

                <flux:button
                    variant="primary"
                    wire:click="save"
                >
                    Save
                </flux:button>
            </div>
        </div>
    </flux:modal>