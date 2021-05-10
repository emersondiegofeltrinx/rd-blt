@extends('layout.main')

@section('breadcrumb')
    {{ __('messages.IncidentList') }}
@endsection

@section('content')
    <div class="text-end mb-2">
        <a href="{{ route('incidents.create') }}" class="btn btn-primary">
            {{ __('messages.Add') }}
        </a>
    </div>
    <table class="table table-bordered table-hover table-stripped">
        <thead>
            <tr>
                <th>{{ __('messages.Id') }}</th>
                <th>{{ __('messages.Title') }}</th>
                <th class="d-none d-md-table-cell">
                    {{ __('messages.Criticality') }}</th>
                <th class="d-none d-lg-table-cell">
                    {{ __('messages.Type') }}</th>
                <th class="d-none d-md-table-cell">
                    {{ __('messages.Status') }}</th>
                <th class="d-none d-lg-table-cell">
                    {{ __('messages.CreatedAt') }}</th>
                <th style="width: 130px"></th>
            </tr>
        </thead>
        <tbody>
            @if ($incidents->count() === 0)
                <tr>
                    <td colspan="100%" class="text-center">
                        {{ __('messages.NoItemsFound') }}
                    </td>
                </tr>
            @else
                @foreach ($incidents as $incident)
                    <tr>
                        <td>{{ $incident->id }}</td>
                        <td>{{ $incident->title }}</td>
                        <td class="d-none d-md-table-cell">
                            {{ __('messages.CriticalityOptions.' . $incident->criticality) }}
                        </td>
                        <td class="d-none d-lg-table-cell">
                            {{ __('messages.TypeOptions.' . $incident->type) }}
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ __('messages.StatusOptions.' . $incident->status) }}
                        </td>
                        <td class="d-none d-lg-table-cell">
                            {{ $incident->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="p-1">
                            <a href="{{ route('incidents.edit', $incident->id) }}" class="btn btn-sm btn-primary">
                                {{ __('messages.Edit') }}
                            </a>

                            <form method="post"
                                action="{{ route('incidents.destroy', $incident->id) }}"
                                class="d-inline"
                            >
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-danger">
                                    {{ __('messages.Delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div>
        {{ $incidents->links() }}
    </div>
@endsection
