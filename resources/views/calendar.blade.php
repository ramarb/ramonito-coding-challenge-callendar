@extends('common.layout')

<style>
    /*.col{
        border: solid red 1px;
    }*/
</style>

@section('content')
    <div class="row">
        <div class="col col-12">
            <h1>Calendar</h1>
        </div>
    </div>

    <div class="row">
        <div class="col col-5">

            <form id="event-form" method="post" action="/calendar">
                <div class="form-group">
                    <label for="">Event</label>
                    <input type="text" class="form-control" name="event" id="event" aria-describedby="emailHelp" placeholder="">

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="">From</label>
                        <input type="date" class="form-control" name="from_date" id="from_date" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">To</label>
                        <input type="date" class="form-control" name="to_date" id="to_date" placeholder="">
                    </div>
                </div>
                <div class="form-row align-items-center">
                    @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $index => $day)

                    <div class="col-auto">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="day[{{$index}}]" value="{{$day}}" id="">
                            <label class="form-check-label" for="autoSizingCheck">
                                {{$day}}
                            </label>
                        </div>
                    </div>

                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>

        </div>

        <div class="col col-7">
            <h2>{{$current_month}}</h2>
            <table class="table">
                <thead>

                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Event</th>

                </tr>
                </thead>
                <tbody>
                @for($i = 1; $i <= $last_date; $i++)
                    <?php $the_date = "{$current_month} {$i} {$current_year}"?>
                    <tr class="event-tr" id="{{str_replace(" ","_",$the_date)}}">

                        <td>{{$i . ' ' . date('D',strtotime($the_date))}}</td>
                        <td class="event"></td>

                    </tr>
                @endfor


                </tbody>
            </table>

        </div>
    </div>

    <script type="text/javascript">
        var uri = 'calendar'
    </script>
@endsection
