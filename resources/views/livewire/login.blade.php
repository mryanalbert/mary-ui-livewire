<div class="flex justify-center">
    <x-card title="Login" class="mt-[20vh] w-96 shadow-md mx-3">
        <x-form wire:submit="save">
            <x-input label="Username" wire:model="username" />
            <x-password label="Password" wire:model="password" right />

            <x-button label="Login" class="btn-primary mt-5" type="submit" spinner="save" />
        </x-form>

        <!-- Separator with "or with" -->
        <div class="flex items-center my-4">
            <div class="flex-1 border-t border-gray-300"></div>
            <p class="px-3 text-gray-500 text-sm">or with</p>
            <div class="flex-1 border-t border-gray-300"></div>
        </div>

        <!-- Google Login Button -->
        <x-button wire:click="googleLogin"
            class="w-full flex items-center justify-center btn-outline gap-2 b shadow py-2 rounded-lg"
            spinner="googleLogin">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 48 48">
                <path fill="#4285F4"
                    d="M47.6 24.5c0-1.6-.1-3.2-.4-4.7H24v9.3h13.3c-.6 3-2.3 5.6-4.9 7.3v6h7.9c4.6-4.3 7.3-10.5 7.3-17.9z" />
                <path fill="#34A853"
                    d="M24 48c6.3 0 11.7-2.1 15.6-5.8l-7.9-6c-2.3 1.6-5.1 2.5-7.7 2.5-6 0-11-4-12.8-9.4H3.2v5.9C7.2 42.3 14.9 48 24 48z" />
                <path fill="#FBBC05"
                    d="M11.2 29.3c-.6-1.6-.9-3.3-.9-5.1s.3-3.5.9-5.1v-6h-8C1.7 16.3 0 20.1 0 24s1.7 7.7 4.4 10.9l6.8-5.6z" />
                <path fill="#EA4335"
                    d="M24 9.5c3.6 0 6.8 1.3 9.3 3.7l7-6.9C35.7 2.4 30.3 0 24 0 14.9 0 7.2 5.7 3.2 13.7l8 6.2c1.8-5.4 6.8-9.4 12.8-9.4z" />
            </svg>
            <span>Login with Google</span>
        </x-button>
    </x-card>

    <livewire:word-table />
</div>
