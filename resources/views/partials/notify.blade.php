@if(session()->has('notify'))
    <script>
        "use strict";
        @foreach(session('notify') as $message)
            toastr["{{$message[0]}}"]("{{$message[1]}}")
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
             <script> 
                "use strict";
                toastr["{{$message[0]}}"]("{{$message[1]}}");
            </script>
        @endforeach
    </script>
@endif

@if ($errors->any())
    @php
        $alldata = collect($errors->all());
        $errors = $alldata->unique();
    @endphp

    <script>
        "use strict";
        @foreach ($errors as $message)
            toastr["error"]("{{$message}}")
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
        @endforeach
    </script>
@endif
<script>
    "use strict";
    function notify(status,message) {
        toastr[status](message);
    }
</script>