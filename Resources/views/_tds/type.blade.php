@if($entry->type === 'entry')
    <label class="label label-success">Entry</label>
@elseif($entry->type === 'error')
    <label class="label label-danger">Error</label>
@elseif($entry->type === 'warning')
    <label class="label label-warning">Warning</label>
@elseif($entry->type === 'debug' || $entry->type === 'info' || $entry->type === 'log')
    <label class="label label-info">{{ ucfirst($entry->type) }}</label>
@endif