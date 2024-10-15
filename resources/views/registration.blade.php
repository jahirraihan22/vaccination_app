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
    <div class="row">
        <div class="col-12  mb-5">
            <h1 class="text-center">Vaccine Registration</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-4 mx-auto mb-5">
            <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="name" placeholder="Your name" required>
                </div>
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="email" placeholder="Your email" required>
                </div>
                @error('email')
                <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="mb-3">
                    <label for="nid" class="form-label">NID</label>
                    <input type="text" class="form-control" value="{{ old('nid') }}" name="nid" id="nid" placeholder="Your NID" required>
                </div>
                @error('nid')
                <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="mb-3">
                    <select class="form-select" name="vaccine_center" aria-label="Select Center">
                        <option selected value="">Select Vaccine Center</option>
                        @foreach( $vaccine_centers as $vaccine_center)
                            <option value="{{ $vaccine_center->id }}">{{ $vaccine_center->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('vaccine_center')
                <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="mb-3">
                    <button class="btn btn-success" type="submit">Registration</button>
                    &nbsp;
                    <a class="btn btn-primary" href="{{ route('index') }}">Back</a>
                </div>
            </form>
        </div>
    </div>

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
        appendAlert("{{ Session::get('message') }}", "{{ Session::get('alert-type') }}" )
    })
    @endif
</script>
</body>
</html>
