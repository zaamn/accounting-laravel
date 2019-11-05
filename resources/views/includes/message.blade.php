@if (session()->get('status'))
    <div class="alert alert-success">
        {{session()->get('status')}}
    </div>
@endif