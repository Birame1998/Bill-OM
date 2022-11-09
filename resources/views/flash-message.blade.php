{{--
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
    Please check the form below for errors
</div>
@endif --}}

@if (session()->has('message'))
    <script type="text/javascript">
        $(function() {
            setTimeout(function() {
                $.bootstrapGrowl("{{session()->get('message')}}", {
                    type: 'danger',
                    position:"top",
                    align: 'center',
                    width:"auto"
                });
            }, 2000);
        });
    </script>
@elseif (session()->has('message_success'))
    <script type="text/javascript">
        $(function() {
            setTimeout(function() {
                $.bootstrapGrowl("{{session()->get('message_success')}}", {
                    type: 'success',
                    position:"top",
                    align: 'center',
                    width:"auto"
                });
            }, 2000);
        });
    </script>
@endif
