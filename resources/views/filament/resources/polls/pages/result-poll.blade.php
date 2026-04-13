<x-filament-panels::page>
    <x-filament::card>
    <div
    style="font-size: larger;
    font-weight: 500;
    margin-bottom: 8px;">{{$poll->question}}</div>
    Total Answers: {{ $ansCount }}
    @foreach ($pollOptions as $key => $option)
        <div style="margin-bottom: 8px;">
            <h3>{{$key + 1 }}. {{$option->option_text}}</h3>
            <span>{{$option->percentage}}%</span>
        </div>
    @endforeach
    </x-filament::card>
</x-filament-panels::page>
