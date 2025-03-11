<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script></script>
</head>

<body>
    <div class="container">


        <form action="{{ url('user/import') }}" method="post" class="card" enctype="multipart/form-data">
            @csrf

            <label for="formFile" class="form-label fs-2"> file input </label>
            <div class="input-group">
                <input type="file" name="importexcel" id="importexcel" class="form-control">
                <button type="submit" class="btn btn-primary">Send</button>
            </div>

        </form>
        @error('file')
            <script>
                let timerInterval;
                Swal.fire({
                    title: "alert!",
                    icon: "error",
                    html: "{{ $message }}",
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log("I was closed by the timer");
                    }
                });
            </script>
        @enderror
        @if (session('status'))
            <script>
                let timerInterval;
                Swal.fire({
                    title: "Success!",
                    html: "imported successfully",
                    timer: 2000,
                    timerProgressBar: true,

                });
            </script>
        @endif
        @if (session('error'))
            <script>
                let timerInterval;
                Swal.fire({
                    title: "Error!",
                    icon: 'error'
                    html: "error while import",
                    timer: 2000,
                    timerProgressBar: true,

                })
            </script>
        @endif
        @foreach ($files as $file)
            <div class="col">
                <img class="img-fluid img-thumbnail" src="{{ asset('/storage/' . $file->file_name) }}" alt="">
                <h1 download>{{ ltrim($file->file_name, 'files/') }}</h1>
                <form action="{{ route('test.destroy', $file->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger mt-3 mb-3">Delete</button>
                    <a href="{{ Storage::url('public/' . $file->file_name) }}" class="btn btn-primary">Download</a>
                </form>

            </div>
        @endforeach
    </div>
    <div class="row">

    </div>
    </div>
 
</body>
</html>
