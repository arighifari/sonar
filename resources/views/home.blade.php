
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--//bootstrap css--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{--//bootstrap JS--}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Berita</title>
</head>
<body>
<div class="container">
    <div class="">
        <h2 style="text-align: center">Berita</h2>
    </div>
    <div>
        <h4>Total Berita : {{$count}}</h4>
    </div>
    <div>
        <a class="btn btn-primary" href="{{route('rss')}}" role="button">Tambah Berita Dari RSS Link</a>
        <a class="btn btn-primary" href="{{route('xpath')}}" role="button">Tambah Berita Dari xpath</a>
    </div>
    <div>
        @foreach($artikel as $item)
            <ul>
                <li><a href="{{$item['url']}}"> URL : {{$item['url']}}</a></li>
                <li>Judul : {{$item['title']}}</li>
                <li>Waktu Tayang : {{$item['article_ts']}}</li>
                <li> <p>Konten Lengkap : {{$item['content']}}</p></li>
            </ul>
        @endforeach
    </div>
</div>
</body>
</html>
