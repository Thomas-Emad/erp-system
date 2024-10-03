@props(['name' => ''])

@error($name)
    <p class="text-red-500 text-sm">{{ $message }}</p>
@enderror
