<x-filament-panels::page>
    <x-filament::card>
        <div style="font-size: larger;
    font-weight: 500;
    margin-bottom: 8px;">{{$poll->question}}</div>
        Total Answers: <span id="total_answers">{{ $ansCount }}</span>
        @foreach ($pollOptions as $key => $option)
        <div style="margin-bottom: 8px;">
            <h3>{{$key + 1 }}. {{$option->option_text}}</h3>
            <span id="{{$option->option_text}}">{{$option->percentage}}%</span>
        </div>
        @endforeach
    </x-filament::card>
</x-filament-panels::page>
<script src="https://js.pusher.com/8.3.0/pusher.min.js"></script>
<script>
    const pusher = new Pusher("{{config('broadcasting.connections.pusher.key')}}", {
        cluster: "{{config('broadcasting.connections.pusher.options.cluster')}}"
    });
    const channel = pusher.subscribe("{{$poll->slug}}");

    channel.bind('App\\Events\\PollAnswerAdded', (data) => {
        document.getElementById("total_answers").textContent = data.ansCount;
        Object.entries(data.ansPercentage).forEach(([key, value]) => {
            const element = document.getElementById(key);
            if (element) {
                element.textContent = (value.percentage ?? value) + "%";
            }
        });

    });

</script>
