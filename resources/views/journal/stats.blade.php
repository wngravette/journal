@extends('journal.master')
@section('additional_head')
@endsection
@section('content')
<div class="columns intro">
    <div class="single-column column">
        <h2>Your Writing Stats</h2>
    </div>
</div>
<div class="columns stats">
    <div class="column one-fifth stats_block">
        <p>
            Words this Month
        </p>
        <h1>{{$word_count}}</h1>
    </div>
    <div class="column one-fifth stats_block">
        <p>
            Words last Month
        </p>
        <h1>{{$prev_word_count}}</h1>
    </div>
    <div class="column one-fifth stats_block">
        <p>
            Average Words per Entry
        </p>
        <h1>{{$avg_words}}</h1>
    </div>
    <div class="column one-fifth stats_block">
        <p>
            Average Time Taken
        </p>
        <h1>{{$avg_time}}</h1>
    </div>
    <div class="column one-fifth stats_block">
        <p>
            Average Finish Time
        </p>
        <h1>{{$avg_fin}}</h1>
    </div>
</div>
<div class="columns stats">
    <!--
    <div class="column one-third stats_block">
        <script>
        $(function () {
            $('#highchart').highcharts({
                chart: {
                    type: 'spline'
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                },
                yAxis: {
                    title: {
                        text: 'Temperature (°C)'
                    },
                    labels: {
                        enabled: true,
                        align: 'right',
                        format: '{value} words',
                    },
                    minPadding: 5,
                    floor: 0,
                    opposite:true
                },
                tooltip: {
                    valueSuffix: ''
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: 'Words',
                    data: [
                        @foreach ($word_counts as $word_count)
                        {{$word_count}},
                        @endforeach
                    ]
                }]
            });
        });
        </script>
        <p>
            Words per Entry
        </p>
        <div id="highchart" style="height:150px"></div>
    </div>
    -->
    <div class="column one-third stats_block common_words">
        <p>
            Most Common Words
        </p>
        @foreach ($common_words as $word => $count)
        <p>
            {{$word}}
        </p>
        @endforeach
    </div>
</div>
@endsection
