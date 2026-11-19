<section>
    <header class="mb-6">
        <h2 class="text-lg font-bold text-base-content">Delete Account</h2>
        <p class="mt-1 text-sm text-base-content/60">Once your account is deleted, all of its resources and data will be
            permanently deleted.</p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">Delete
        Account</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-base-content">Are you sure?</h2>
            <p class="mt-2 text-sm text-base-content/60">
                Once your account is deleted, all data will be permanently removed. Please enter your password to
                confirm.
            </p>

            <div class="form-control mt-6">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" name="password" type="password" class="w-3/4"
                    placeholder="Enter your password" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-danger-button type="submit">Delete Account</x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
