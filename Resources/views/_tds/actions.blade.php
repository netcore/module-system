<a href="#" class="btn btn-default btn-xs view-data" data-id="{{ $entry->id }}">
    <i class="fa fa-eye"></i> View Data
</a>

<a
    class="btn btn-xs btn-danger confirm-action"
    data-title="Confirmation"
    data-text="Entry will be deleted. Are you sure?"
    data-confirm-button-text="Delete"
    data-method="DELETE"
    data-href="{{ route('admin::system.destroy', $entry) }}"
    data-success-title="Success"
    data-success-text="Entry was deleted"
    data-refresh-datatable="#datatable"
>
    <i class="fa fa-trash"></i> Delete
</a>
