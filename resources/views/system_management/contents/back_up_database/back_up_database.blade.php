@extends('system_management.layout.system_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="card flex-fill p-3">
    <div class="card-header">
        <div class="card-header d-flex">
            <button class="btn btn-success" id="back-up-db">Back Up Now</button>
        </div>
    </div>

</div>

@endsection
@section('js')
<script>
   document.getElementById('back-up-db').addEventListener('click', function() {
            

                fetch(base_url + '/admin/sysm/act/back-up-db')
                .then(response => response.json())
                .then(data => {
                    alert(data.message)
                    // document.getElementById('message').innerText = data.message;
                })
                .catch(error => {
                    console.error('There was an error:', error);
                    // document.getElementById('message').innerText = 'Error occurred during backup.';
                });
        });
</script>
@endsection