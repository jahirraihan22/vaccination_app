<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vaccine Registration Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container-fluid">
    @if(isset($user))
        <div class="row">
            <div class="col-4 mx-auto mb-5">
                <h2 class="text-center">Information</h2>
                <hr>
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">User Information</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Name:</strong> {{ $user->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Email:</strong> {{ $user->email }}
                            </li>
                            <li class="list-group-item">
                                <strong>NID:</strong> {{ $user->nid }}
                            </li>
                            <li class="list-group-item">
                                <strong>Vaccine Center:</strong> {{ $user->vaccineCenter->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Status:</strong> {{ $user->status }}
                            </li>
                            <li class="list-group-item">
                                <strong>Scheduled Date:</strong> {{ $user->scheduled_date ?? 'N/A' }}
                            </li>
                            <li class="list-group-item">
                                <strong>Serial No:</strong> {{ $user->serial > 0 ? $user->serial : 'N/A' }}
                            </li>
                            <li class="list-group-item">
                                <a class="btn btn-sm btn-primary" href="{{ route('index') }}">Back</a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    @endif

    <div id="liveAlertPlaceholder"></div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
    const appendAlert = (message, type) => {
        const wrapper = document.createElement('div')
        wrapper.innerHTML = [
            `<div class="alert alert-${type} alert-dismissible" role="alert">`,
            `   <div>${message}</div>`,
            '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
            '</div>'
        ].join('')

        alertPlaceholder.append(wrapper)
    }

    @if(Session::has('message'))
    document.addEventListener('DOMContentLoaded', () => {
        appendAlert("{!! Session::get('message') !!}", "{{ Session::get('alert-type') }}" )
    })
    @endif
</script>
</body>
</html>
