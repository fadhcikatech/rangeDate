<!DOCTYPE html>
<html>
<head>
   <title>Livewire</title>
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    rel="stylesheet">
    @livewireStyles
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header text-danger text-center">
                        <h2>Data Range</h2>
                    </div>
                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        @livewire('member')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewireScripts
</body>
</html>