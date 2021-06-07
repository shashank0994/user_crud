<input {!! $attributes->merge(['class' => 'w-full border-gray-600 border py-1 rounded-sm focus:ring-0']) !!}>
@error($attributes['name'])
    <div class="w-full text-red-600 text-xs">{{$message}}</div>
@enderror
