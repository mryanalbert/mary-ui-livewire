{{-- User --}}
<div>
    @if ($user)
        <x-menu-separator />

        <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
            <x-slot:actions>
                <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate
                    link="/logout" />
            </x-slot:actions>
        </x-list-item>

        <x-menu-separator />
    @endif
</div>
