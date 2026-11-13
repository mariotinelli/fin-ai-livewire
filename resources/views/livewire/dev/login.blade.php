<div class="join h-10">
    <select name="name" wire:model="selectedUser" class="select join-item select-primary">
        <option value="0" selected></option>
        @foreach ($this->users as $user)
            <option value="{{ $user->id }}">{{ $user->formatted_name . ' (' . $user->type->label() . ')' }}</option>
        @endforeach
    </select>
    <x-ui.button sm primary wire:click="login" class="join-item h-10 font-bold"> LOGIN </x-ui.button>
</div>
