@extends('layout.app')
<style>
    body,
    html {
        height: 100%;
        margin: 0;
    }

    .bg {
        /* The image used */
        background-image: url("images/Boeing.jpg");

        /* Full height */
        height: 100%;

        /* Center and scale the image nicely */
        background-position: ;
        background-repeat: no-repeat;
        background-size: cover;
    }

</style>
@section('context')


    <div class="flex-center position-ref full-height">

        <div class="jumbotron text-center  card-container" style="background: linear-gradient(45deg, #614ad3, #e42c64);">

            @if ($message = Session::get('success'))
                <div class=" alert alert-success alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="alert-heading h4 my-2">Success</h3>
                    <p class="mb-0">{{ $message }} {{-- <a class="alert-link"
            href="javascript:void(0)">link</a>! --}}</p>
                </div>
            @endif
            @if ($message = Session::get('failed'))
                <div class=" alert alert-warning alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="alert-heading h4 my-2">Please Upload a .txt file</h3>
                    <p class="mb-0">{{ $message }} {{-- <a class="alert-link"
            href="javascript:void(0)">link</a>! --}}</p>
                </div>
            @endif
            <div class="title m-b-md">
                <h1 style="color: aliceblue">Upload .txt File</h1>
            </div>

            <form method="post" action={{ route('file.Uploaded') }} enctype="multipart/form-data">
                @csrf
                <label for="file"></label>
                <input type="file" required name="var_file" />
                <button class="btn btn-primary btn-success" type="submit" name="submit">Upload File </button>
            </form>
        </div>
    </div>

@endsection
