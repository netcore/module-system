@if($data)
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Key</th>
            <th>Value</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $key => $value)
            <tr>
                <td>{{ $key }}</td>
                <td>
                    @if(is_array($value) || is_object($value))
                        {{ json_encode($value) }}
                    @else
                        {{ $value }}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <h3 class="text-center">No data available</h3>
@endif