<table>
    <thead>
        <tr>
            @foreach($transformer->keys as $key)
                <th>{{ str()->title(str()->replace('_', ' ', $key)) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($transformer->data as $result)
            <tr>
                @foreach($transformer->keys as $key)
                    <td>
                        {{ $result[$key] }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
