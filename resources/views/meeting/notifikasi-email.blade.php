<!DOCTYPE html>
<html>

<head>
    <title>PEMBERITAHUAN AGENDA RAPAT SMI</title>
</head>

<body>
    <b>{{ $judul }}</b>
    <br>
    Kepada {{ $nama }}, <br>
    <br>
    Diberitahukan kepada saudara bahwa terdapat agenda rapat pada: <br>
    Tanggal : {{ $date }} <br>
    Jam : {{ $time }} <br>
    Tempat : {{ $place }} <br>
    <br>
    Dimohon untuk hadir dan mengikuti agenda rapat tersebut. Atas perhatian dan waktunya kami ucapkan terima kasih
    <br>
    <b>Ket:</b> {{ $description }}
</body>

</html>