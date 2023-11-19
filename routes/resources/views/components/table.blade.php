<div class="dt-responsive table-responsive">
    <table id="datatable" class="table nowrap datatable">
        <thead>
            <tr>
                @forelse ($keys as $key)
                    <th>{{ $key }}</th>
                @empty
                @endforelse
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="{{ count($keys) }}" align="center">No matching records found</td>
            </tr>
        </tbody>
    </table>
</div>
