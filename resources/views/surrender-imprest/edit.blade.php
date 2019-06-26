@extends('layouts.app')
@section('content')
    <div class="container">
        <edit-surrender-imprest :details='{!! json_encode($imprest) !!}'
                                :canfinalize="{{ hasPermission(App\Role::PERM_FINALIZE_SURRENDER_IMPREST) ? 'true' : 'false' }}"
        ></edit-surrender-imprest>
    </div>
@endsection
@section('footer')
<script>
    $('#cheque_date').datepicker({
        autoclose:true,
        format: 'd-MM-yyyy'
    });
</script>
@endsection